<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Mark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index(){

        
        $teacher = Auth::user();

        // Get basic counts
        $data = [
            'subjects_count' => $teacher->teachingSubjects()->count(),
            'subjects' => $teacher->teachingSubjects()->with('level')->get(),
            'recent_marks' => $teacher->taughtMarks()
                ->with(['student', 'subject'])
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('teacher.dashboard.index', $data);
        
       
    
    }

    public function showSubject($id)
{
    $subject = Auth::user()->teachingSubjects()
        ->with(['level'])
        ->findOrFail($id);

    $students = $subject->level->students()
        ->withCount('marks')
        ->withAvg('marks as marks_average', 'score')
        ->with(['marks' => function($query) use ($subject) {
            $query->where('subject_id', $subject->id)
                  ->latest()
                  ->take(1);
        }])
        ->get()
        ->map(function($student) {
            $student->latestMark = $student->marks->first();
            return $student;
        });

    $marks = Mark::where('subject_id', $subject->id)
        ->where('teacher_id', Auth::id())
        ->get();

    return view('teacher.subject-details', compact('subject', 'students', 'marks'));
}

public function storeMark(Request $request, $studentId)
{
    $request->validate([
        'score' => 'required|numeric|min:0|max:100',
        'subject_id' => 'required|exists:subjects,id',
        'remarks' => 'nullable|string'
    ]);

    Mark::create([
        'student_id' => $studentId,
        'subject_id' => $request->subject_id,
        'teacher_id' => Auth::id(),
        'score' => $request->score,
        'remarks' => $request->remarks
    ]);

    return back()->with('success', 'Mark added successfully');
}

public function showStudents()
{
    $subjects = Auth::user()->teachingSubjects()
        ->with(['level.students' => function($query) {
            $query->withCount('marks')
                  ->withAvg('marks as average_score', 'score');
        }])
        ->get();

    return view('teacher.students', [
        'subjects' => $subjects
    ]);
}

  

}
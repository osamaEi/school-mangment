<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use App\Models\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::students()
                       ->with(['studentLevels', 'studentMarks'])
                       ->latest()
                       ->paginate(10);
        
        return view('backend.students.index', compact('students'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('backend.students.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'family_name' => ['nullable', 'string', 'max:255'],
            'family_name2' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'level_id' => ['required', 'exists:levels,id']
        ]);

        $age = Carbon::parse($request->dob)->age;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('student-photos', 'public');
        }

        $student = User::create([
            ...$validated,
            'age' => $age,
            'role' => 'student',
            'password' => Hash::make($request->password),
            'photo' => $photoPath ?? null,
            'status' => true
        ]);

        // Enroll student in selected level
        $student->studentLevels()->attach($request->level_id, [
            'status' => 'active',
            'enrolled_at' => now()
        ]);

        return redirect()->route('Adminstudent.index')
            ->with('success', 'Student created successfully.');
    }

    public function show($id)
    {
        $student = User::where('id', $id)
            ->where('role', 'student')
            ->with([
                'studentLevels.subjects',
                'studentMarks.subject',
                'studentMarks.teacher'
            ])
            ->firstOrFail();

        $marks = $student->studentMarks()
            ->with(['subject', 'teacher'])
            ->latest()
            ->paginate(5);

        $averageScore = $student->studentMarks()->avg('score');
        
        return view('backend.students.show', compact('student', 'marks', 'averageScore'));
    }

    public function edit(User $student)
    {
        abort_if($student->role !== 'student', 404);
        
        $levels = Level::all();
        return view('backend.students.edit', compact('student', 'levels'));
    }

    public function update(Request $request, User $student)
    {
        abort_if($student->role !== 'student', 404);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'family_name' => ['nullable', 'string', 'max:255'],
            'family_name2' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . $student->id],
            'phone' => ['required', 'string', 'unique:users,phone,' . $student->id],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'level_id' => ['required', 'exists:levels,id']
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $validated['photo'] = $request->file('photo')->store('student-photos', 'public');
        }

        $student->update([
            ...$validated,
            'age' => Carbon::parse($request->dob)->age,
            'password' => $request->password ? Hash::make($request->password) : $student->password
        ]);

        // Update level if changed
        if ($request->level_id != $student->currentLevel()?->id) {
            // Mark current level as completed
            $student->studentLevels()
                   ->wherePivot('status', 'active')
                   ->update(['status' => 'completed', 'completed_at' => now()]);

            // Enroll in new level
            $student->studentLevels()->attach($request->level_id, [
                'status' => 'active',
                'enrolled_at' => now()
            ]);
        }

        return redirect()->route('Adminstudent.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        abort_if($student->role !== 'student', 404);

        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        // Delete related records
        $student->studentLevels()->detach();
        $student->studentMarks()->delete();
        
        $student->delete();

        return redirect()->route('Adminstudent.index')
            ->with('success', 'Student deleted successfully.');
    }

    // Additional methods for student management

    public function updateStatus(Request $request, User $student)
    {
        abort_if($student->role !== 'student', 404);

        $student->update(['status' => !$student->status]);

        $status = $student->status ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Student {$status} successfully.");
    }

    public function changeLevel(Request $request, User $student)
    {
        $request->validate([
            'level_id' => ['required', 'exists:levels,id']
        ]);

        // Mark current level as completed
        $student->studentLevels()
               ->wherePivot('status', 'active')
               ->update(['status' => 'completed', 'completed_at' => now()]);

        // Enroll in new level
        $student->studentLevels()->attach($request->level_id, [
            'status' => 'active',
            'enrolled_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Student level changed successfully.');
    }
}
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

    
    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);
    
        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'family_name' => 'nullable|string|max:255',
            'family_name2' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'country' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        // Update fields if they are changed
        $student->first_name = $request->first_name !== $student->first_name ? $request->first_name : $student->first_name;
        $student->last_name = $request->last_name !== $student->last_name ? $request->last_name : $student->last_name;
        $student->family_name = $request->family_name !== $student->family_name ? $request->family_name : $student->family_name;
        $student->family_name2 = $request->family_name2 !== $student->family_name2 ? $request->family_name2 : $student->family_name2;
        $student->dob = $request->dob !== $student->dob->format('Y-m-d') ? $request->dob : $student->dob;
        $student->country = $request->country !== $student->country ? $request->country : $student->country;
        $student->email = $request->email !== $student->email ? $request->email : $student->email;
        $student->phone = $request->phone !== $student->phone ? $request->phone : $student->phone;
    
        if ($request->filled('password')) {
            $student->password = bcrypt($request->password);
        }
    
        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::delete($student->photo);
            }
            $student->photo = $request->file('photo')->store('students_photos');
        } elseif ($request->has('remove_photo') && $student->photo) {
            Storage::delete($student->photo);
            $student->photo = null;
        }
    
        $student->save();
    
        return redirect()->route('Adminstudent.index')->with('success', 'Student updated successfully.');
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
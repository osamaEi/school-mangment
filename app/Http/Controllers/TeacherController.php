<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
                       ->with(['teachingSubjects.level', 'marks'])
                       ->latest()
                       ->paginate(10);
        
        return view('backend.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('backend.teachers.create', compact('levels'));
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
            'photo' => ['nullable', 'image', 'max:2048'], // 2MB Max
        ]);
    
        $age = \Carbon\Carbon::parse($request->dob)->age;
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teacher-photos', 'public');
        }
    
        $teacher = User::create([
            ...$validated,
            'age' => $age,
            'role' => 'teacher',
            'password' => Hash::make($request->password),
            'photo' => $photoPath ?? null,
        ]);
    
        return redirect()->route('Adminteacher.index')
            ->with('success', 'Teacher created successfully.');
    }
   

    public function show($id)
    {
        $teacher = User::where('id', $id)
            ->where('role', 'teacher')
            ->with([
                'teachingSubjects.level',
                'marks.student',
                'marks.subject'
            ])
            ->firstOrFail();

        // Get available subjects for assignment
        $availableSubjects = Subject::whereDoesntHave('teachers', function($query) use ($id) {
                                $query->where('users.id', $id);
                            })
                            ->with('level')
                            ->get();

        // Get marks data for chart
        $marksData = $teacher->marks()
                            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();

        return view('backend.teachers.show', compact('teacher', 'availableSubjects', 'marksData'));
    }

    public function edit($id)
    {
        $levels = Level::all();
        $teacher = User::find($id);
        return view('backend.teachers.edit', compact('teacher', 'levels'));
    }

    public function update(Request $request, User $teacher)
{
    // Define base validation rules
    $rules = [
        'first_name' => ['sometimes', 'required', 'string', 'max:255'],
        'last_name' => ['sometimes', 'nullable', 'string', 'max:255'],
        'family_name' => ['sometimes', 'nullable', 'string', 'max:255'],
        'family_name2' => ['sometimes', 'nullable', 'string', 'max:255'],
        'country' => ['sometimes', 'nullable', 'string', 'max:255'],
        'dob' => ['sometimes', 'required', 'date', 'before:today'],
        'password' => ['sometimes', 'nullable', 'min:8', 'confirmed'],
        'photo' => ['sometimes', 'nullable', 'image', 'max:2048'],
    ];

    // Only validate email if it's provided and different from current
    if ($request->has('email')) {
        // If email is unchanged, remove it from the request
        if ($request->email === $teacher->email) {
            $request->request->remove('email');
        } else {
            $rules['email'] = ['required', 'string', 'email', 'unique:users,email,' . $teacher->id];
        }
    }

    // Only validate phone if it's provided and different from current
    if ($request->has('phone')) {
        // If phone is unchanged, remove it from the request
        if ($request->phone === $teacher->phone) {
            $request->request->remove('phone');
        } else {
            $rules['phone'] = ['required', 'string', 'unique:users,phone,' . $teacher->id];
        }
    }

    // Validate request data
    $validated = $request->validate($rules);

    // Handle photo upload if provided
    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $validated['photo'] = $request->file('photo')->store('teacher-photos', 'public');
    }

    // Remove password from validated data if not provided
    if (empty($validated['password'])) {
        unset($validated['password']);
    } else {
        $validated['password'] = Hash::make($validated['password']);
    }

    // Calculate age only if dob is provided
    if (isset($validated['dob'])) {
        $validated['age'] = Carbon::parse($validated['dob'])->age;
    }

    // Update teacher data
    $teacher->update($validated);

    return redirect()->route('Adminteacher.index')
        ->with('success', 'Teacher updated successfully.');
}
    


    public function destroy(User $teacher)
    {
        abort_if($teacher->role !== 'teacher', 404);

        // Delete photo if exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        // Delete related records
        $teacher->teachingSubjects()->detach();
        $teacher->marks()->delete();
        
        $teacher->delete();

        return redirect()->route('Adminteacher.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    // Additional Methods for new functionality

    public function updatePhoto(Request $request, User $teacher)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048']
        ]);

        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $photoPath = $request->file('photo')->store('teacher-photos', 'public');
        $teacher->update(['photo' => $photoPath]);

        return redirect()->back()->with('success', 'Profile photo updated successfully.');
    }

    public function toggleStatus(User $teacher)
    {
        abort_if($teacher->role !== 'teacher', 404);

        $teacher->update(['status' => !$teacher->status]);

        $message = $teacher->status ? 'Teacher activated successfully.' : 'Teacher deactivated successfully.';
        return redirect()->back()->with('success', $message);
    }

    public function assignSubject(Request $request, User $teacher)
    {
        $request->validate([
            'subject_id' => ['required', 'exists:subjects,id']
        ]);

        if (!$teacher->teachingSubjects()->where('subject_id', $request->subject_id)->exists()) {
            $teacher->teachingSubjects()->attach($request->subject_id);
            return redirect()->back()->with('success', 'Subject assigned successfully.');
        }

        return redirect()->back()->with('error', 'Subject is already assigned to this teacher.');
    }

    public function removeSubject(Request $request, User $teacher)
    {
        $request->validate([
            'subject_id' => ['required', 'exists:subjects,id']
        ]);

        $teacher->teachingSubjects()->detach($request->subject_id);
        return redirect()->back()->with('success', 'Subject removed successfully.');
    }
}
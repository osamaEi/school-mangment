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
        // Validate incoming request
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
            'photo' => ['nullable', 'max:2048'], // Max 2MB image
        ]);
        
        // Calculate age from the date of birth
        $age = \Carbon\Carbon::parse($request->dob)->age;
    
        // Handle photo upload if the file is present
        $photoPath = null; // Default photo path
    
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Store the photo in the 'teacher-photos' directory
            $photoPath = $request->file('photo')->store('teacher-photos', 'public');
        }
    
        // Create the teacher user
        $teacher = User::create([
            ...$validated,
            'age' => $age,
            'role' => 'teacher',
            'password' => Hash::make($request->password),
            'photo' => $photoPath, // Store the photo path in the database
        ]);
    
        // Redirect back to the teacher index with success message
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

    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);
    
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
        $teacher->first_name = $request->first_name !== $teacher->first_name ? $request->first_name : $teacher->first_name;
        $teacher->last_name = $request->last_name !== $teacher->last_name ? $request->last_name : $teacher->last_name;
        $teacher->family_name = $request->family_name !== $teacher->family_name ? $request->family_name : $teacher->family_name;
        $teacher->family_name2 = $request->family_name2 !== $teacher->family_name2 ? $request->family_name2 : $teacher->family_name2;
        $teacher->dob = $request->dob !== $teacher->dob->format('Y-m-d') ? $request->dob : $teacher->dob;
        $teacher->country = $request->country !== $teacher->country ? $request->country : $teacher->country;
        $teacher->email = $request->email !== $teacher->email ? $request->email : $teacher->email;
        $teacher->phone = $request->phone !== $teacher->phone ? $request->phone : $teacher->phone;
    
        if ($request->filled('password')) {
            $teacher->password = bcrypt($request->password);
        }
    
        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                Storage::delete($teacher->photo);
            }
            $teacher->photo = $request->file('photo')->store('teacher_photos');
        } elseif ($request->has('remove_photo') && $teacher->photo) {
            Storage::delete($teacher->photo);
            $teacher->photo = null;
        }
    
        $teacher->save();
    
        return redirect()->route('Adminteacher.index')->with('success', 'Teacher updated successfully.');
    }
    

  


public function destroy($id)
{
    try {
           $teacher = User::find($id);

        if ($teacher->photo) {
            \Log::info('Deleting photo at: ' . $teacher->photo);  // Debugging line
            Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->teachingSubjects()->detach();
        
        $teacher->delete();

        // Redirect with success message
        return redirect()->route('Adminteacher.index')
            ->with('success', 'Teacher deleted successfully.');
    } catch (\Exception $e) {
        \Log::error('Error deleting teacher: ' . $e->getMessage());  // Log the error
        return redirect()->route('Adminteacher.index')
            ->with('error', 'Error deleting teacher.');
    }
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
<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
                       ->latest()
                       ->paginate(10);
        
        return view('backend.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('backend.teachers.create');
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
        ]);

        $age = \Carbon\Carbon::parse($request->dob)->age;

        $teacher = User::create([
            ...$validated,
            'age' => $age,
            'role' => 'teacher',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('Adminteacher.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function show(User $teacher)
    {
    
    
        return view('backend.teachers.show', compact('teacher'));
    }
}


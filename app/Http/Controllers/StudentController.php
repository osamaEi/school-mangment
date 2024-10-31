<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
                       ->latest()
                       ->paginate(10);
        
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
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

        $student = User::create([
            ...$validated,
            'age' => $age,
            'role' => 'student',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(User $student)
    {
        if ($student->role !== 'student') {
            abort(404);
        }
        
        return view('students.show', compact('student'));
    }
    
}
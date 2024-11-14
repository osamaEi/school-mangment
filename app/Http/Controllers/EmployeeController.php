<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'manager'])
                     ->get(['id', 'first_name', 'last_name', 'email', 'phone', 'age', 'role']);
        return view('backend.employee.index', compact('users'));
    }

    // Show the form for creating a new user with role restriction
    public function create()
    {
        return view('backend.employee.create');
    }

    // Store a newly created user with only "admin" or "manager" role
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'age' => 'required|integer',
            'role' => ['required', Rule::in(['admin', 'manager'])],
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user with only the required fields
        User::create([
            'first_name' => $validatedData['first_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'age' => $validatedData['age'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Display the specified user with role restriction
    public function show(User $user)
    {
        if (!in_array($user->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    public function destroy($id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Delete the user
    $user->delete();

    // Redirect with a success message
    return redirect()->route('employee.index')->with('success', __('User deleted successfully.'));
}

}

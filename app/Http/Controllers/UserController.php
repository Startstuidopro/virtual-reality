<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // For password hashing

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Retrieve all users (we'll add pagination later if needed)
        $users = User::all();

        // 2. Pass the users to a view
        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Requires password confirmation field
            'role' => 'required|in:admin,doctor,student',
            'is_active' => 'sometimes|boolean', // Optional checkbox
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password!
            'role' => $request->role,
            'is_active' => $request->has('is_active'), // Check if checkbox is checked
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        // dd($request->is_active);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // Unique email validation, ignoring the current user
            'password' => 'nullable|string|min:8|confirmed', // Password is optional for updates
            'role' => 'required|in:admin,doctor,student',
            // 'is_active' => 'sometimes|boolean',
        ]);
       
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            // Update password only if provided
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
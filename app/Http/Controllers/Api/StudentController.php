<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Protect all actions with Sanctum
    }

    public function show(Request $request)
    {
        // Get the authenticated student
        $student = $request->user();

        // You can return specific fields if needed:
        return response()->json([
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            // ... other fields ...
        ]);
    }

    public function update(Request $request)
    {
        $student = $request->user();

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:users,email,' . $student->id,
            // ... other validation rules ...
        ]);

        $student->update($request->all());

        return response()->json(['message' => 'Profile updated successfully', 'student' => $student], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For Auth::user()
use App\Models\User;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Apply authentication to all methods in this controller
    }

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $exams = Exam::all(); // Admins see all exams
        } else {
            $exams = Exam::where('doctor_id', Auth::id())->get(); // Doctors see their exams
        }

        return view('exams.index', ['exams' => $exams]);
    }

    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('exams.create', ['doctors' => $doctors]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'doctor_id' => 'required|exists:users,id' // Ensure doctor exists
        ]);

        Exam::create($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam created successfully!');
    }

    public function show(Exam $exam)
    {
        return view('exams.show', ['exam' => $exam]);
    }

    public function edit(Exam $exam)
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('exams.edit', ['exam' => $exam, 'doctors' => $doctors]);
    }
    public function update(Request $request, Exam $exam)
    {
        // 1. Authorization: Check if the authenticated user is the doctor who created the exam
        $this->authorize('update', $exam); // Using a policy (recommended)

        // 2. Check if any attempts have been made on the exam
        if ($exam->attempts()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot update an exam that has attempts!');
        }

        // 3. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // ... other validation rules
        ]);

        $exam->update($request->all());
        return redirect()->route('exams.index')->with('success', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam)
    {
        // Instead of deleting, we'll "soft delete" or hide the exam:
        $exam->delete(); // This will use Laravel's soft delete if enabled in your model

        return redirect()->route('exams.index')->with('success', 'Exam hidden successfully!');
    }
}
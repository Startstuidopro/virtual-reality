<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Exam $exam, ExamAttempt $attempt)
    {
        // 1. Authorization: Only the attempt owner (student) or the exam's doctor can view the results
        if (Auth::user()->id !== $attempt->student_id && Auth::user()->id !== $exam->doctor_id) {
            abort(403, 'Unauthorized');
        }

        $attempt->load('exam.questions', 'answers'); 

        return view('attempts.show', [
            'attempt' => $attempt, 
            'exam' => $exam,
        ]);
    }

    public function index(Exam $exam) 
    {
        // 1. Authorization: Only the doctor of the exam can view all attempts
        // if (Auth::user()->id !== $exam->doctor_id) {
        //     abort(403, 'Unauthorized');
        // }

        $attempts = $exam->attempts()->with('student')->get();

        return view('attempts.index', [
            'exam' => $exam,
            'attempts' => $attempts,
        ]);
    }
    public function assess(Exam $exam, ExamAttempt $attempt)
{
    // 1. Authorization: Make sure only the exam's doctor can assess attempts.

    // 2. Call the assessAnswers() function (or dispatch a job) to trigger assessment:
    $this->assessAnswers($attempt); // Or dispatch a job if using queues

    return redirect()->back()->with('success', 'Assessment initiated!'); 
}
}
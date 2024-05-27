<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Resources\ExamResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // Or use Policies

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $user = $request->user(); // Get the authenticated user

        if ($user->role === 'admin') {
            $exams = Exam::all();
        } else {
            // For students and doctors, show only accessible exams
            $exams = Exam::where(function ($query) use ($user) {
                $query->where('doctor_id', $user->id) // Doctor's own exams
                    ->orWhereHas('permissions', function ($query) use ($user) {
                        $query->where('student_id', $user->id)
                            ->where('allowed', true); // Exams the student is allowed to take
                    });
            })->get();
        }

        return ExamResource::collection($exams);
    }

    public function show(Exam $exam)
    {
        // Authorization: Ensure the authenticated user can access this exam
        Gate::authorize('view', $exam); // Or use a Policy

        return new ExamResource($exam);
    }
}
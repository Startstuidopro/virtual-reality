<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use App\Models\ExamPermission;
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
        $user = $request->user();

        $exams = Exam::where(function ($query) use ($user) {
            $query->whereHas('permissions', function ($subQuery) use ($user) {
                $subQuery->where('student_id', $user->id)
                    ->where('allowed', true);
            })
                ->whereDoesntHave('attempts', function ($subQuery) use ($user) {
                    $subQuery->where('student_id', $user->id);
                });
        })
            ->with('doctor') // Only eager load the doctor relationship
            ->get();

        return ExamResource::collection($exams);
    }

    public function show(Exam $exam)
    {
        // Authorization: Ensure the authenticated user can access this exam
        Gate::authorize('view', $exam); // Or use a Policy

        return new ExamResource($exam);
    }
    public function permissions(Exam $exam)
    {
        $students = User::where('role', 'student')->get();
        return view('exams.permissions', ['exam' => $exam, 'students' => $students]);
    }

    public function storePermission(Request $request, Exam $exam)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'allowed' => 'required|boolean',
        ]);

        $exam->permissions()->updateOrCreate(
            ['student_id' => $request->student_id],
            ['allowed' => $request->allowed]
        );

        return redirect()->route('exams.permissions', $exam)->with('success', 'Exam permission updated!');
    }

    public function destroyPermission(Exam $exam, ExamPermission $permission)
    {
        // Authorization: Make sure only the exam's creator can manage permissions.
        if (Auth::user()->id !== $exam->doctor_id) {
            abort(403, 'Unauthorized');
        }

        $permission->delete();

        return redirect()->route('exams.permissions', $exam)->with('success', 'Exam permission removed!');
    }
}

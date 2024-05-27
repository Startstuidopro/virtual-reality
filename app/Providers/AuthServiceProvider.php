<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use APP\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Policies\ExamPolicy;
use App\Policies\QuestionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Exam::class => ExamPolicy::class,
    Question::class => QuestionPolicy::class,
    // ExamAttempt::class => ExamAttemptPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('view-exam', function ($user, $exam) {
            // Logic to determine if the user can view the exam
            return $user->role === 'admin' ||
                $exam->doctor_id === $user->id ||
                $exam->permissions()->where('student_id', $user->id)->where('allowed', true)->exists();
        });

        //
    }
}
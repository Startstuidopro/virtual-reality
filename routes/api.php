<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\ExamAttemptController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes (using Sanctum)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Student Profile
    Route::get('/me', [StudentController::class, 'show']);
    Route::put('/me', [StudentController::class, 'update']);
    Route::get('/attempts/{attempt}', [ExamAttemptController::class, 'show'])->name('api.attempts.show');
    Route::get('/attempts', [ExamAttemptController::class, 'index'])->name('api.attempts.index');
    Route::get('/exams/{exam}/permissions', [ExamController::class, 'permissions'])->name('exams.permissions');
    Route::post('/exams/{exam}/permissions', [ExamController::class, 'storePermission'])->name('exams.permissions.store');
    Route::delete('/exams/{exam}/permissions/{permission}', [ExamController::class, 'destroyPermission'])->name('exams.permissions.destroy');

    // Exams
    Route::apiResource('exams', ExamController::class)->only(['index', 'show']);

    // Exam Attempts
    Route::prefix('exams/{exam}/attempts')
        ->group(function () {
            Route::post('/', [ExamAttemptController::class, 'start'])->name('api.exams.attempts.start');
            Route::put('/{attempt}', [ExamAttemptController::class, 'submit'])->name('api.exams.attempts.submit');
            // ... other attempt routes ...
        });
});

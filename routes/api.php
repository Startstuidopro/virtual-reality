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
Route::middleware('auth:sanctum')->group(function() {
    // Student Profile 
    Route::get('/me', [StudentController::class, 'show']); 
    Route::put('/me', [StudentController::class, 'update']);

    // Exams 
    Route::apiResource('exams', ExamController::class)->only(['index', 'show']); 

    // Exam Attempts 
    Route::prefix('exams/{exam}/attempts')
         ->group(function () {
            Route::post('/', [ExamAttemptController::class, 'start'])->name('exams.attempts.start');
            Route::get('/{attempt}', [ExamAttemptController::class, 'show'])->name('exams.attempts.show');
            Route::put('/{attempt}', [ExamAttemptController::class, 'submit'])->name('exams.attempts.submit');
        }); 
}); 
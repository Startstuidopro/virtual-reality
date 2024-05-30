<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamAttemptController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(); 

// User Routes 
Route::middleware(['auth'])->group(function () { // Protect all user-related routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Exam Routes 
Route::middleware(['auth'])->group(function() {
    Route::resource('exams', ExamController::class);
});
Route::prefix('exams/{exam}/attempts')
        ->group(function () {
            Route::get('/', [ExamAttemptController::class, 'index'])->name('exams.attempts.index');
            Route::get('/{attempt}', [ExamAttemptController::class, 'show'])->name('exams.attempts.show');
        });
// Question Routes (Nested within Exams)
Route::middleware(['auth'])->prefix('exams/{exam}')
     ->group(function () {
        Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
        Route::get('/questions/create/ai', [QuestionController::class, 'createWithAI'])->name('questions.create.ai');
        Route::post('/questions/ai', [QuestionController::class, 'storeAI'])->name('questions.store.ai');
     });

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
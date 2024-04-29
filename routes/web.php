<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
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

Route::get('question/index', [QuestionController::class, 'index'])->name('question.index');
Route::get('question/craete', [QuestionController::class, 'create'])->name('questions.create');
Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');
Route::get('question/edit/{id}', [QuestionController::class, 'edit'])->name('question.edit');
Route::post('question/update/{id}', [QuestionController::class, 'update'])->name('question.update');
Route::get('question/delete/{id}', [QuestionController::class, 'destroy'])->name('question.destroy');





Route::get('/', function () {
    return view('welcome');
});
Route::get('question/index', [QuestionController::class, 'index'])->name('question.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

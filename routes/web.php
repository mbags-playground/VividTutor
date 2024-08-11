<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChatBotController;

Route::get('/', function () {
    return view('welcome');
})->name("home.welcome");


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CourseController::class, 'dashboard'])->name('dashboard');
    Route::post('/generate-course', [CourseController::class, 'generateCourse'])->name('generate.chapter');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/chapters/{id}', [ChapterController::class, 'show'])->name('chapters.show');
    Route::post('/chapters/{id}/complete', [ChapterController::class, 'completeChapter'])->name('chapters.complete');
});

Route::post('/chapters/{id}/chat', [ChatBotController::class, 'send'])->name('chat.send');

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\languageController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('lang/{locale}', [languageController::class, 'switchLocale'])->name('lang.switch');




Route::middleware('auth')->group(function () {
    Route::resource('Adminteacher', TeacherController::class);
    Route::patch('teachers/{teacher}/photo', [TeacherController::class, 'updatePhoto'])->name('teachers.update-photo');
    Route::patch('teachers/{teacher}/toggle-status', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle-status');
    Route::post('teachers/{teacher}/assign-subject', [TeacherController::class, 'assignSubject'])->name('teachers.assign-subject');
    Route::delete('teachers/{teacher}/remove-subject', [TeacherController::class, 'removeSubject'])->name('teachers.remove-subject');

    Route::prefix('students')->group(function () {
        // Basic CRUD Routes
        Route::get('/', [StudentController::class, 'index'])
            ->name('Adminstudent.index');
            
        Route::get('/create', [StudentController::class, 'create'])
            ->name('Adminstudent.create');
            
        Route::post('/', [StudentController::class, 'store'])
            ->name('Adminstudent.store');
            
        Route::get('/{student}', [StudentController::class, 'show'])
            ->name('Adminstudent.show');
            
        Route::get('/{student}/edit', [StudentController::class, 'edit'])
            ->name('Adminstudent.edit');
            
        Route::put('/{student}', [StudentController::class, 'update'])
            ->name('Adminstudent.update');
            
        Route::delete('/{student}', [StudentController::class, 'destroy'])
            ->name('Adminstudent.destroy');

        // Additional Student Routes
        Route::patch('/{student}/toggle-status', [StudentController::class, 'toggleStatus'])
            ->name('Adminstudent.toggle-status');
            
        Route::patch('/{student}/update-photo', [StudentController::class, 'updatePhoto'])
            ->name('Adminstudent.update-photo');
            
        Route::post('/{student}/change-level', [StudentController::class, 'changeLevel'])
            ->name('Adminstudent.change-level');
    });
});


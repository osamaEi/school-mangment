<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\languageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectFileController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Teacher\TeacherDashboardController;

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

//Route::get('/dashboard', function () {
   // return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/auth.php';

Route::get('lang/{locale}', [languageController::class, 'switchLocale'])->name('lang.switch');




Route::middleware(['auth','roles:admin'])->group(function () {

    Route::resource('Adminlevel', LevelController::class);
    Route::resource('Adminsubject', SubjectController::class);
    Route::resource('Adminsubject-file', SubjectFileController::class);


    Route::resource('Adminteacher', TeacherController::class);
    Route::patch('teachers/{teacher}/photo', [TeacherController::class, 'updatePhoto'])->name('teachers.update-photo');
    Route::patch('teachers/{teacher}/toggle-status', [TeacherController::class, 'toggleStatus'])->name('teachers.toggle-status');
    Route::post('teachers/{teacher}/assign-subject', [TeacherController::class, 'assignSubject'])->name('teachers.assign-subject');
    Route::delete('teachers/{teacher}/remove-subject', [TeacherController::class, 'removeSubject'])->name('teachers.remove-subject');
      

    Route::prefix('students')->group(function () {
        
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

        Route::patch('/{student}/toggle-status', [StudentController::class, 'toggleStatus'])
            ->name('Adminstudent.toggle-status');
            
        Route::patch('/{student}/update-photo', [StudentController::class, 'updatePhoto'])
            ->name('Adminstudent.update-photo');
            
        Route::post('/{student}/change-level', [StudentController::class, 'changeLevel'])
            ->name('Adminstudent.change-level');
    });

    Route::get('subject-files/{file}/download', [SubjectFileController::class, 'download'])
    ->name('admin.subject.file.download');
    
Route::delete('admin/subject-files/{file}', [SubjectFileController::class, 'destroy'])
    ->name('admin.subject.file.destroy');

    Route::get('/admin/dashboard',[DashboardController::class,'adminDashboard'])->name('admin.dashboard');

});


Route::middleware(['auth'])->group(function () {

Route::get('/profile',[ProfileController::class,'Profile'])->name('profile.view');
Route::get('/ChangePassword',[ProfileController::class,'ChangePassword'])->name('profile.ChangePassword');

Route::post('/profile',[ProfileController::class,'ProfileStore'])->name('profile.store');
Route::post('/PasswordUpdate',[ProfileController::class,'PasswordUpdate'])->name('profile.PasswordUpdate');


Route::get('student/file/{file}/download', [StudentDashboardController::class, 'downloadFile'])
->name('student.download.file');

});
Route::middleware(['auth','roles:teacher'])->group(function () {

    Route::get('/teacher/dashboard',[TeacherDashboardController::class,'index'])->name('teacher.dashboard');

    Route::get('/teacher/students',[TeacherDashboardController::class,'showStudents'])->name('teacher.showStudents');
    Route::get('teacher/subjects/{id}', [TeacherDashboardController::class, 'showSubject'])->name('teacher.subject.show');
    Route::post('teacher/marks/{student}/store', [TeacherDashboardController::class, 'storeMark'])->name('teacher.marks.store');
    
}); 

Route::middleware(['auth','roles:student'])->group(function () {

    Route::get('/student/dashboard',[StudentDashboardController::class,'index'])->name('student.dashboard');


    // routes/web.php


    
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AnnouncementController;

// Show the login form (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Handle login request (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Optionally, you can keep your home route pointing to the login form too:
Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');

Route::get('/enroll', function () {
    return view('enrollment_form');
})->name('enrollment_form');

Route::get('/strand_assessment', function () {
    return view('strand_assessment');
})->name('strand.assessment');

Route::get('/result', function () {
    return view('assessment_result');
})->name('assessment.result');

Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');

Route::get('/enrollment_success', function () {
    return view('enrollment_successful');
})->name('enrollment.success');

// Protected routes (Only logged-in users can access)
Route::middleware('auth')->group(function () {
    //Route::get('/student/dashboard', [AnnouncementController::class, 'index'])->name('student.dashboard');
    Route::get('/student/dashboard', function () {
        return view('student_dash');
    })->name('student.dashboard');

    Route::get('/grades', [GradeController::class, 'index'])->name('grades');

    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects');

    Route::get('/documents', function () {
        return view('my_docs');
    })->name('documents');

    // Route to handle online upload (ensure this is protected if needed)
    Route::post('/documents/upload', [DocumentController::class, 'uploadOnline'])->name('documents.upload');

    // Route to view a specific document (pass the document id)
    Route::get('/documents/view/{id}', [DocumentController::class, 'viewDocument'])->name('documents.view');

    Route::get('/faculty/dashboard', function () {
        return view('faculty_dashboard');
    })->name('faculty.dashboard');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function(){
    Route::get('/admin/dashboard', [ChartController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', function () {
        return view('admin_users');
    })->name('admin.users');

    Route::get('/admin/instructors', function () {
        return view('admin_instructors');
    })->name('admin.instructors');

    Route::get('/admin/subjects', function () {
        return view('admin_subjects');
    })->name('admin.subjects');

    Route::get('/admin/classes', function () {
        return view('admin_classes');
    })->name('admin.classes');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware('auth')->group(function() {
    Route::get('/instructor/dashboard', function () {
        return view('instructor_dashboard');
    })->name('instructor.dashboard');

    Route::get('/instructor/classes', function () {
        return view('instructor_class_schedmore');
    })->name('instructor.schedmore');

    Route::get('/instructor/schedule', function () {
        return view('instructor_class_schedule');
    })->name('instructor.schedule');

    Route::get('/instructor/students', function () {
        return view('instructor_class_student');
    })->name('instructor.student');

    Route::get('/instructor/attendance', function () {
        return view('instructor_attendance');
    })->name('instructor.attendance');

    Route::get('/instructor/reports', function () {
        return view('instructor_report');
    })->name('instructor.report');

    Route::get('/instructor/announcement', function () {
        return view('instructor_announcement');
    })->name('instructor.announcement');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

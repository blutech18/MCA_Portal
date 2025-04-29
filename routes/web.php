<?php

use App\Models\User;
use App\Models\Student;
use App\Models\StudentSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\StudentSubjectController;
use App\Http\Controllers\AdminInstructorController;
use App\Http\Controllers\AdminNewEnrolleeController;
use App\Http\Controllers\StrandAssessmentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\InstructorStudentController;
use App\Http\Controllers\StudentReportCardController;
use App\Http\Controllers\InstructorScheduleController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\InstructorAttendanceController;
use App\Http\Controllers\InstructorAnnouncementController;
use App\Http\Controllers\InstructorStudentGradeController;

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

Route::get('/result', [StrandAssessmentController::class,'showResult'])->name('assessment.result');

Route::post('/enroll', [EnrollmentController::class, 'store'])->name('enrollment.store');

Route::get('/enrollment_success', function () {
    return view('enrollment_successful');
})->name('enrollment.success');

// Protected routes (Only logged-in users can access)
Route::middleware('auth')->group(function () {
    //Route::get('/student/dashboard', [AnnouncementController::class, 'index'])->name('student.dashboard');
    Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])->name('student.dashboard');

    Route::get('/student/grades', [StudentReportCardController::class, 'reportCard'])->name('student.grades');

    Route::get('/student/subjects', [StudentSubjectController::class, 'subjects'])->name('student.subjects');
    
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

    Route::get('/admin/users', [UserController::class,'index'])->name('admin.users');
    Route::post('/users',       [UserController::class,'store'])->name('users.store');

    Route::get('/admin/instructors', [AdminInstructorController::class, 'index'])
     ->name('admin.instructors');
    Route::post('/admin/instructors', [AdminInstructorController::class, 'store'])
    ->name('admin_instructors.store');
    Route::get('/check-username/{username}', [AdminInstructorController::class, 'checkUsername']);
    Route::get('/admin/instructors/search', [AdminInstructorController::class, 'search']);
    Route::post('/admin/instructors/schedules', [AdminInstructorController::class, 'storeSchedule'])->name('instructors.schedule.store');
    Route::post('/admin/instructors/schedules/{schedule}/update', [AdminInstructorController::class, 'updateSchedule']);
    Route::delete('/admin/instructors/schedules/{schedule}', [AdminInstructorController::class, 'deleteSchedule']);
    Route::post(
        '/admin/instructors/{instructor}/classes',
        [App\Http\Controllers\AdminInstructorController::class, 'assignClasses']
      )->name('admin.instructors.assignClasses');
      // Route (web.php)
    Route::post('/instructors/assign-classes', [AdminInstructorController::class, 'assignClasses'])->name('instructors.assign.classes');


    Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('admin.subjects');
    Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
    
    
    Route::get('/admin/classes',     [StudentController::class, 'create'])             ->name('admin.classes');
    Route::post('/admin/classes/student',[StudentController::class, 'store'])           ->name('admin_classes.student');
    Route::get('/students',          [StudentController::class, 'index'])              ->name('students.index');
    Route::get('/api/sections',      [StudentController::class, 'getFilteredSections']);
    Route::get('/check-username/{username}', [StudentController::class, 'checkUsername']);


    Route::get('/admin/get-students/{grade}/{strand}/{section}', [SectionController::class, 'getStudents']);
    Route::post('/admin/classes/section/store', [StudentController::class, 'storeSection'])->name('admin_classes.section.store');


    Route::resource('admin/courses', CourseController::class)->names([
        'index' => 'admin.courses.index',
        'create' => 'admin.courses.create',
        'store' => 'admin.courses.store',
        'edit' => 'admin.courses.edit',
        'update' => 'admin.courses.update',
        'destroy' => 'admin.courses.destroy',
    ]);

    Route::get('/admin/enrollees', [AdminNewEnrolleeController::class,'index'])
     ->name('admin.enrollees');

    Route::get('/admin/enrollees/{enrollee}', [AdminNewEnrolleeController::class,'show'])
        ->name('admin.enrollees.show');

    Route::delete('/admin/enrollees/{enrollee}', [AdminNewEnrolleeController::class,'destroy'])
        ->name('admin.enrollees.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware('auth')->group(function() {
    Route::get('/instructor/dashboard', [InstructorDashboardController::class,'index'])->name('instructor.dashboard');

    Route::get('/instructor/schedule', [InstructorScheduleController::class,'schedMore'])->name('instructor.schedule');

    Route::get('/instructor/student', [InstructorStudentController::class,'index'])->name('instructor.student');
    
    Route::get('/instructor/attendance', [InstructorAttendanceController::class, 'show'])->name('instructor.attendance');
    Route::post('/instructor/attendance/mark', [InstructorAttendanceController::class, 'mark'])->name('instructor.attendance.mark');
        
    Route::get('/instructor/reports',[InstructorStudentGradeController::class, 'gradeSheet'])->name('instructor.report');
    Route::post('/instructor/reports/grade',[InstructorStudentGradeController::class, 'saveGrade'])->name('instructor.grade.save');

    Route::get('/instructor/announcement',[InstructorAnnouncementController::class, 'index'])->name('instructor.announcement');
    Route::post('/instructor/announcement',[InstructorAnnouncementController::class, 'store'])->name('instructor.announcement.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

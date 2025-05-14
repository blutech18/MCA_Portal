<?php

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentSection;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\NewEnrollmentController;
use App\Http\Controllers\OldEnrollmentController;
use App\Http\Controllers\StudentSubjectController;
use App\Http\Controllers\AdminInstructorController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\AdminNewEnrolleeController;
use App\Http\Controllers\AdminOldEnrolleeController;
use App\Http\Controllers\StrandAssessmentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\InstructorStudentController;
use App\Http\Controllers\StudentReportCardController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\InstructorScheduleController;
use App\Http\Controllers\CoreValueEvaluationController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\InstructorAttendanceController;
use App\Http\Controllers\InstructorAnnouncementController;
use App\Http\Controllers\InstructorStudentGradeController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');

Route::get('/forgot-password', function () {
    return view('auth.passwords.email'); // Create this view
})->name('password.request');

// Handle sending reset email (you can customize the controller as needed)
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Show the password reset form (after user clicks the link in the email)
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

// Handle the actual password reset form submission
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/reset-success', function () {
    return view('auth.passwords.success');
})->name('password.reset.success');

Route::prefix('enroll')->name('enroll.')->group(function(){

    // Selection page
    Route::get('select', fn() => view('enrollment_form_select'))
         ->name('select');

    // NEW STUDENT routes
    Route::prefix('new')->name('new.')->group(function(){
        Route::get('step1', [NewEnrollmentController::class,'showStep1'])
             ->name('step1');
        Route::post('step1', [NewEnrollmentController::class,'postStep1'])
             ->name('step1.post');

        Route::get('step2', [NewEnrollmentController::class,'showStep2'])
             ->name('step2');
        Route::post('step2', [NewEnrollmentController::class,'postStep2'])
             ->name('step2.post');

        Route::get('step3', [NewEnrollmentController::class,'showStep3'])
             ->name('step3');
        Route::post('step3', [NewEnrollmentController::class,'postStep3'])
             ->name('step3.post');
             
        Route::get('step4', [NewEnrollmentController::class,'showStep4'])
             ->name('step4');
    });

    // OLD STUDENT routes
    Route::prefix('old')->name('old.')->group(function(){
        Route::get('step1', [OldEnrollmentController::class,'showStep1'])
             ->name('step1');
        Route::post('step1', [OldEnrollmentController::class,'postStep1'])
             ->name('step1.post');

        Route::get('step2', [OldEnrollmentController::class,'showStep2'])
             ->name('step2');
        Route::post('step2', [OldEnrollmentController::class,'postStep2'])
             ->name('step2.post');

        Route::get('step3', [OldEnrollmentController::class,'showStep3'])
             ->name('step3');

        Route::get('step4', [OldEnrollmentController::class,'showStep4'])
             ->name('step4');

    });
});

Route::get('/strand_assessment', function () {return view('strand_assessment');})->name('strand.assessment');
Route::get('/result', [StrandAssessmentController::class,'showResult'])->name('assessment.result');

Route::get('/enrollment_success', function () {return view('enrollment_successful');})->name('enrollment.success');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected routes (Only logged-in users can access)
Route::prefix('student')
     ->middleware(['auth', CheckRole::class . ':student'])
     ->group(function(){
    //Route::get('/student/dashboard', [AnnouncementController::class, 'index'])->name('student.dashboard');
    Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard'])->name('student.dashboard');

    Route::get('/student/grades', [StudentReportCardController::class, 'reportCard'])->name('student.grades');
     Route::get('/student/evaluations', [CoreValueEvaluationController::class,'show'])
     ->name('student.evaluations.show');

    Route::get('/student/subjects', [StudentSubjectController::class, 'subjects'])->name('student.subjects');
    
    Route::get('/student/documents', [StudentDocumentController::class, 'index'])
     ->name('student.documents');

    // Route to handle online upload (ensure this is protected if needed)
    Route::post('/documents/upload', [DocumentController::class, 'uploadOnline'])->name('documents.upload');

    // Route to view a specific document (pass the document id)
    Route::get('/documents/view/{id}', [DocumentController::class, 'viewDocument'])->name('documents.view');

    Route::get('/faculty/dashboard', function () {
        return view('faculty_dashboard');
    })->name('faculty.dashboard');

});

Route::prefix('admin')
     ->middleware(['auth', CheckRole::class . ':admin'])
     ->group(function(){
    Route::get('dashboard', [ChartController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/users', [UserController::class,'index'])->name('admin.users');
    Route::post('admin/users',       [UserController::class,'store'])->name('users.store');

    Route::get('instructors', [AdminInstructorController::class, 'index'])
    ->name('admin.instructors');
    Route::post('instructors', [AdminInstructorController::class, 'store'])
        ->name('admin_instructors.store');
    Route::put('instructors/{instructor}', [AdminInstructorController::class, 'update'])
        ->name('admin.instructors.update');
              
    Route::get('/check-username/{username}', [AdminInstructorController::class, 'checkUsername']);
    Route::get('instructors/search', [AdminInstructorController::class, 'search']);

    Route::post('instructors/schedules', [AdminInstructorController::class, 'storeSchedule'])->name('instructors.schedule.store');
    Route::post('instructors/schedules/{schedule}/update', [AdminInstructorController::class, 'updateSchedule']);
    Route::delete('instructors/schedules/{schedule}', [AdminInstructorController::class, 'deleteSchedule'])
     ->name('instructors.schedule.delete');

    Route::post('/instructors/{instructor}/classes',[App\Http\Controllers\AdminInstructorController::class, 'assignClasses'])->name('admin.instructors.assignClasses');
    Route::post('/instructors/assign-classes', [AdminInstructorController::class, 'assignClasses'])->name('instructors.assign.classes');


    Route::get('subjects', [SubjectController::class, 'index'])->name('admin.subjects');
    Route::post('subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])
     ->name('admin.subjects.destroy');
    
    Route::get('/admin/classes',     [StudentController::class, 'create'])             ->name('admin.classes');
    Route::post('/admin/classes/student',[StudentController::class, 'store'])           ->name('admin_classes.student');
    Route::get('/students',          [StudentController::class, 'index'])              ->name('students.index');
    Route::get('/api/sections', [StudentController::class, 'getFilteredSections'])
     ->name('api.sections');
     Route::get('api/enrollee/{appNum}', [StudentController::class,'getEnrolleeByAppNum'])
     ->name('admin.api.enrollee');
     Route::post('students/{id}/approve', [StudentController::class, 'approveStudent'])
    ->name('admin.approveStudent');
    Route::post('/admin/students/reset-enrollment', [StudentController::class, 'resetEnrollment'])
    ->name('admin.students.resetEnrollment');


    Route::get('/admin/get-students/{grade}/{strand}/{section}', [SectionController::class, 'getStudents']);
    Route::post('/admin/classes/section/store', [StudentController::class, 'storeSection'])->name('admin_classes.section.store');


    Route::resource('/admin/courses', CourseController::class)
    ->names([
       'index'   => 'admin.courses.index',
       'store'   => 'admin.courses.store',
       'create'  => 'admin.courses.create',
       'edit'    => 'admin.courses.edit',
       'update'  => 'admin.courses.update',
       'destroy' => 'admin.courses.destroy',
    ]);

    Route::get('api/new-enrollee-modal/{id}', [AdminNewEnrolleeController::class,'newModal'])
     ->name('admin.enrollee.new.modal');

     Route::get('api/old-enrollee-modal/{id}', [AdminNewEnrolleeController::class,'oldModal'])
          ->name('admin.enrollee.old.modal');

    Route::get('/admin/enrollees', [AdminNewEnrolleeController::class,'index'])
     ->name('admin.enrollees');

    Route::get('enrollees/{enrollee}', [AdminNewEnrolleeController::class,'show'])
        ->name('admin.enrollees.show');

    Route::delete('/admin/enrollees/{enrollee}', [AdminNewEnrolleeController::class,'destroy'])
        ->name('admin.enrollees.destroy');

     Route::delete('/admin/old-enrollees/{enrollee}', [AdminNewEnrolleeController::class, 'destroyOld'])
    ->name('admin.old.enrollees.destroy');

    Route::post('/admin/old‑enrollees/{id}/approve', [
     AdminNewEnrolleeController::class,
     'approveOldEnrollee',
     ])->name('admin.old.enrollees.approve');


});

Route::prefix('instructor')
     ->middleware(['auth', CheckRole::class . ':instructor'])
     ->group(function(){
    Route::get('/instructor/dashboard', [InstructorDashboardController::class,'index'])->name('instructor.dashboard');

    Route::get('/instructor/schedule', [InstructorScheduleController::class,'schedMore'])->name('instructor.schedule');

    Route::get('/instructor/student', [InstructorStudentController::class,'index'])->name('instructor.student');
    
    Route::get('/instructor/attendance', [InstructorAttendanceController::class, 'show'])->name('instructor.attendance');
    Route::post('/instructor/attendance/mark', [InstructorAttendanceController::class, 'mark'])->name('instructor.attendance.mark');
        
    Route::get('/instructor/reports',[InstructorStudentGradeController::class, 'gradeSheet'])->name('instructor.report');
    Route::post('/instructor/reports/grade',[InstructorStudentGradeController::class, 'saveGrade'])->name('instructor.grade.save');
 
    Route::post(
     '/instructor/reports/evaluations',
     [InstructorStudentGradeController::class,'saveEvaluations']
     )->name('instructor.evaluations.save');

    Route::get('/instructor/announcement',[InstructorAnnouncementController::class, 'index'])->name('instructor.announcement');
    Route::post('/instructor/announcement',[InstructorAnnouncementController::class, 'store'])->name('instructor.announcement.store');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

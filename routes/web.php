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
use App\Http\Controllers\ReportController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use App\Models\Strands;

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

// Enrollment confirmation report (PDF)
Route::get('/enroll/confirmation/{type}/{id}/report', [ReportController::class, 'enrollmentReport'])
    ->name('enroll.confirmation.report');

Route::prefix('enroll')->name('enroll.')->group(function(){
    
    // Main enroll route - redirects to selection page
    Route::get('/', function () {
        return redirect()->route('enroll.select');
    })->name('index');

    // Selection page
    Route::get('select', fn() => view('enrollment_form_select'))
         ->name('select');

    // NEW STUDENT routes
    Route::prefix('new')->name('new.')->group(function(){
        Route::get('step1', [NewEnrollmentController::class,'showStep1'])
             ->name('step1');
        Route::post('step1', [NewEnrollmentController::class,'postStep1'])
             ->name('step1.post');
        // Public API for strand availability used by Step 1
        Route::get('strand-availability', function () {
            $codeToName = [
                'ABM' => 'ABM',
                'GAS' => 'GAS',
                'STEM' => 'STEM',
                'HUMSS' => 'HUMSS',
                'ICT' => 'TVL-ICT',
                'HE' => 'TVL-HE',
            ];

            $strands = Strands::whereIn('name', array_values($codeToName))->get()->keyBy('name');

            $result = [];
            foreach ($codeToName as $code => $name) {
                $s = $strands->get($name);
                if ($s) {
                    $capacity = (int) ($s->capacity ?? 0);
                    $enrolled = (int) ($s->enrolled_count ?? 0);
                    $available = max($capacity - $enrolled, 0);
                    $result[$code] = [
                        'name' => $name,
                        'capacity' => $capacity,
                        'enrolled' => $enrolled,
                        'available' => $available,
                        'is_full' => $capacity > 0 ? $enrolled >= $capacity : false,
                    ];
                } else {
                    $result[$code] = [
                        'name' => $name,
                        'capacity' => 0,
                        'enrolled' => 0,
                        'available' => 0,
                        'is_full' => false,
                    ];
                }
            }

            return response()->json($result);
        })->name('strand-availability');
        Route::post('check-email', [NewEnrollmentController::class,'checkEmailAvailability'])
             ->name('check-email');

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
        Route::post('step3', [OldEnrollmentController::class,'postStep3'])
             ->name('step3.post');

        Route::get('step4', [OldEnrollmentController::class,'showStep4'])
             ->name('step4');

        // AJAX route for LRN lookup
        Route::post('lookup-lrn', [OldEnrollmentController::class,'lookupStudentByLRN'])
             ->name('lookup.lrn');

    });
});

Route::get('/strand_assessment', function () {return view('strand_assessment');})->name('strand.assessment');
Route::post('/strand_assessment/submit', [StrandAssessmentController::class, 'store'])->name('assessment.submit');
Route::post('/strand_assessment/check', [StrandAssessmentController::class, 'checkAssessment'])->name('assessment.check');
Route::post('/strand_assessment/set-email', [StrandAssessmentController::class, 'setAssessmentEmail'])->name('assessment.set-email');
Route::get('/result', [StrandAssessmentController::class,'showResult'])->name('assessment.result');

Route::get('/enrollment_success', function () {return view('enrollment_successful');})->name('enrollment.success');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected routes (Only logged-in users can access)
Route::prefix('student')
     ->middleware(['auth', CheckRole::class . ':student'])
     ->group(function(){
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('student.dashboard');

    // Grades
    Route::get('/grades', [StudentReportCardController::class, 'reportCard'])->name('student.grades');
    
    // Attendance
    // Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance');

    // Core value evaluations
    Route::get('/evaluations', [CoreValueEvaluationController::class,'show'])->name('student.evaluations.show');

    // Subjects
    Route::get('/subjects', [StudentSubjectController::class, 'subjects'])->name('student.subjects');
    
    // Documents
    Route::get('/documents', [StudentDocumentController::class, 'index'])->name('student.documents');
    Route::get('/documents/serve/{path}', [StudentDocumentController::class, 'serveDocument'])
        ->where('path', '.*')
        ->name('student.documents.serve');
    Route::post('/documents/upload', [DocumentController::class, 'uploadOnline'])->name('documents.upload');
    Route::get('/documents/view/{id}', [DocumentController::class, 'viewDocument'])->name('documents.view');

    // Faculty dashboard (if needed under student namespace)
    Route::get('/faculty/dashboard', function () {
        return view('faculty_dashboard');
    })->name('faculty.dashboard');

});

Route::prefix('admin')
     ->middleware(['auth', CheckRole::class . ':admin'])
     ->group(function(){
    Route::get('dashboard', [ChartController::class, 'index'])->name('admin.dashboard');
    
    // Admin document serving route (for viewing enrollee documents)
    Route::get('/documents/serve/{path}', [App\Http\Controllers\AdminDocumentController::class, 'serveDocument'])
        ->where('path', '.*')
        ->name('admin.documents.serve');
    
    // Admin document serving route by ID (more reliable)
    Route::get('/documents/serve-by-id/{id}', [App\Http\Controllers\AdminDocumentController::class, 'serveDocumentById'])
        ->name('admin.documents.serve-by-id');
    // Admin document re-upload
    Route::post('/documents/reupload', [App\Http\Controllers\AdminDocumentController::class, 'reupload'])
        ->name('admin.documents.reupload');
    
    // Redirect old courses routes to subjects
    Route::get('admin/courses', function () {
        return redirect()->route('admin.subjects');
    });
    Route::get('admin/courses/{any}', function () {
        return redirect()->route('admin.subjects');
    })->where('any', '.*');
    
    // Also handle direct courses routes (without admin prefix)
    Route::get('courses', function () {
        return redirect()->route('admin.subjects');
    });
    Route::get('courses/{any}', function () {
        return redirect()->route('admin.subjects');
    })->where('any', '.*');

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
    Route::get('instructors/{instructor}/schedules', [AdminInstructorController::class, 'getInstructorSchedules'])->name('instructors.schedules.get');
    Route::post('instructors/schedules/{schedule}/update', [AdminInstructorController::class, 'updateSchedule']);
    Route::delete('instructors/schedules/{schedule}', [AdminInstructorController::class, 'deleteSchedule'])
     ->name('instructors.schedule.delete');

    Route::post('/instructors/{instructor}/classes',[App\Http\Controllers\AdminInstructorController::class, 'assignClasses'])->name('admin.instructors.assignClasses');
    Route::post('/instructors/assign-classes', [AdminInstructorController::class, 'assignClasses'])->name('instructors.assign.classes');
    Route::get('/api/admin/available-classes', [AdminInstructorController::class, 'getAvailableClasses'])->name('api.admin.available-classes');
    Route::get('instructors/{instructorId}/data', [AdminInstructorController::class, 'getInstructorData'])->name('admin.instructors.data');


    Route::get('subjects', [SubjectController::class, 'index'])->name('admin.subjects');
    Route::post('subjects', [SubjectController::class, 'store'])
        ->middleware('throttle:10,1') // Allow 10 requests per minute
        ->name('admin.subjects.store');
    Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])
        ->middleware('throttle:5,1') // Allow 5 deletions per minute
        ->name('admin.subjects.destroy');
    Route::post('subjects/reset-default', [SubjectController::class, 'resetDefaultSubjects'])
        ->middleware('throttle:3,1') // Allow 3 resets per minute
        ->name('admin.subjects.reset-default');
    
    Route::get('/admin/classes',     [StudentController::class, 'create'])             ->name('admin.classes');
    Route::post('/admin/classes/student',[StudentController::class, 'store'])           ->name('admin_classes.student');
    Route::get('/students',          [StudentController::class, 'index'])              ->name('students.index');
    Route::get('/api/sections', [StudentController::class, 'getFilteredSections'])
     ->name('api.sections');
     Route::get('api/enrollee/{appNum}', [StudentController::class,'getEnrolleeByAppNum'])
     ->name('admin.api.enrollee');
     Route::post('students/{id}/approve', [StudentController::class, 'approveStudent'])
    ->name('admin.approveStudent');
    Route::post('students/{id}/assign-default-subjects', [StudentController::class, 'assignDefaultSubjects'])
    ->name('admin.assignDefaultSubjects');
    Route::put('students/{id}/update', [StudentController::class, 'update'])
    ->name('admin.students.update');
    Route::post('sections/{id}/assign-default-subjects', [StudentController::class, 'assignDefaultSubjectsToSection'])
    ->name('admin.assignDefaultSubjectsToSection');
    Route::post('/admin/students/reset-enrollment', [StudentController::class, 'resetEnrollment'])
    ->name('admin.students.resetEnrollment');

    // Enrollment Fee Management Routes
    Route::get('/admin/fees', [App\Http\Controllers\AdminFeeController::class, 'index'])->name('admin.fees');
    Route::post('/admin/fees/update', [App\Http\Controllers\AdminFeeController::class, 'updateFee'])->name('admin.fees.update');
    Route::get('/admin/fees/history', [App\Http\Controllers\AdminFeeController::class, 'history'])->name('admin.fees.history');
    
    // API Routes for getting current fees (public access)
    Route::get('/api/enrollment-fees', [App\Http\Controllers\AdminFeeController::class, 'getCurrentFees'])->name('api.enrollment-fees');


    Route::get('/admin/get-students/{grade}/{strand}/{section}', [SectionController::class, 'getStudents']);
    Route::post('/admin/classes/section/store', [StudentController::class, 'storeSection'])->name('admin_classes.section.store');
    Route::get('/admin/api/section-capacity', [StudentController::class, 'getSectionCapacity'])->name('admin.section.capacity');



    Route::get('api/new-enrollee-modal/{id}', [AdminNewEnrolleeController::class,'newModal'])
     ->name('admin.enrollee.new.modal');
    Route::post('api/enrollee/{type}/{id}/payment-status', [AdminNewEnrolleeController::class,'updatePaymentStatus'])
      ->name('admin.enrollee.payment_status');

     Route::get('api/old-enrollee-modal/{id}', [AdminNewEnrolleeController::class,'oldModal'])
          ->name('admin.enrollee.old.modal');

    Route::get('enrollees', [AdminNewEnrolleeController::class,'index'])
     ->name('admin.enrollees');
     
    Route::get('declined-enrollees', [AdminNewEnrolleeController::class,'declined'])
     ->name('admin.declined.enrollees');
    
    // Archive Module Routes
    Route::get('archive', [App\Http\Controllers\ArchiveController::class, 'index'])->name('admin.archive');
    Route::get('archive/year/{year}', [App\Http\Controllers\ArchiveController::class, 'getStudentsByYear'])->name('admin.archive.year');
    Route::get('archive/student/{id}', [App\Http\Controllers\ArchiveController::class, 'getStudentDetails'])->name('admin.archive.student.details');
    Route::post('archive/current-year', [App\Http\Controllers\ArchiveController::class, 'archiveCurrentYear'])->name('admin.archive.current');
    Route::post('archive/restore/{id}', [App\Http\Controllers\ArchiveController::class, 'restoreStudent'])->name('admin.archive.restore');
    Route::get('archive/export/{year}', [App\Http\Controllers\ArchiveController::class, 'exportYearData'])->name('admin.archive.export');
    Route::get('archive/comparison', [App\Http\Controllers\ArchiveController::class, 'getYearComparison'])->name('admin.archive.comparison');
    Route::get('archive/search', [App\Http\Controllers\ArchiveController::class, 'searchArchived'])->name('admin.archive.search');
    
    // Academic Year Management Routes
    Route::get('academic-years', [App\Http\Controllers\AcademicYearController::class, 'index'])->name('admin.academic-years');
    Route::post('academic-years', [App\Http\Controllers\AcademicYearController::class, 'store'])->name('admin.academic-years.store');
    Route::get('academic-years/{id}', [App\Http\Controllers\AcademicYearController::class, 'show'])->name('admin.academic-years.show');
    Route::put('academic-years/{id}', [App\Http\Controllers\AcademicYearController::class, 'update'])->name('admin.academic-years.update');
    Route::delete('academic-years/{id}', [App\Http\Controllers\AcademicYearController::class, 'destroy'])->name('admin.academic-years.destroy');
    Route::put('academic-years/{id}/set-current', [App\Http\Controllers\AcademicYearController::class, 'setCurrent'])->name('admin.academic-years.set-current');

    Route::get('enrollees/{enrollee}', [AdminNewEnrolleeController::class,'show'])
        ->name('admin.enrollees.show');

    Route::delete('enrollees/{enrollee}', [AdminNewEnrolleeController::class,'destroy'])
        ->name('admin.enrollees.destroy');

     Route::delete('old-enrollees/{enrollee}', [AdminNewEnrolleeController::class, 'destroyOld'])
    ->name('admin.old.enrollees.destroy');

    // Accept/Decline routes for new enrollees
    Route::post('enrollees/{enrollee}/accept', [AdminNewEnrolleeController::class, 'acceptNew'])
        ->name('admin.enrollees.accept');
    Route::post('enrollees/{enrollee}/decline', [AdminNewEnrolleeController::class, 'declineNew'])
        ->name('admin.enrollees.decline');
    
    // Credential distribution routes for new enrollees
    Route::get('enrollees/{enrollee}/credentials/pdf', [AdminNewEnrolleeController::class, 'generateCredentialsPDF'])
        ->name('admin.enrollees.credentials.pdf');
    Route::post('enrollees/{enrollee}/credentials/email', [AdminNewEnrolleeController::class, 'sendCredentialsEmail'])
        ->name('admin.enrollees.credentials.email');

    // Accept/Decline routes for old enrollees
    Route::post('old-enrollees/{enrollee}/accept', [AdminNewEnrolleeController::class, 'acceptOld'])
        ->name('admin.old.enrollees.accept');
    Route::post('old-enrollees/{enrollee}/decline', [AdminNewEnrolleeController::class, 'declineOld'])
        ->name('admin.old.enrollees.decline');
    
    // Payment verification routes for old enrollees
    Route::get('old-enrollees/{enrollee}/payment', [AdminNewEnrolleeController::class, 'viewPayment'])
        ->name('admin.old.enrollees.payment');
    Route::post('old-enrollees/{enrollee}/verify-payment', [AdminNewEnrolleeController::class, 'verifyPayment'])
        ->name('admin.old.enrollees.verify-payment');

    Route::post('old‑enrollees/{id}/approve', [
     AdminNewEnrolleeController::class,
     'approveOldEnrollee',
     ])->name('admin.old.enrollees.approve');

    // Section Management Routes
    Route::prefix('sections')->name('sections.')->group(function() {
        Route::get('/', [App\Http\Controllers\SectionManagementController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\SectionManagementController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\SectionManagementController::class, 'show'])->name('show');
        Route::put('/{id}', [App\Http\Controllers\SectionManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\SectionManagementController::class, 'destroy'])->name('destroy');
        Route::post('/sync-counts', [App\Http\Controllers\SectionManagementController::class, 'syncAllCounts'])->name('sync-counts');
        Route::get('/report/capacity', [App\Http\Controllers\SectionManagementController::class, 'getCapacityReport'])->name('report.capacity');
        Route::post('/transfer-student', [App\Http\Controllers\SectionManagementController::class, 'transferStudent'])->name('transfer-student');
    });

});

Route::prefix('instructor')
     ->middleware(['auth', CheckRole::class . ':instructor'])
     ->group(function(){
    Route::get('/dashboard', [InstructorDashboardController::class,'index'])->name('instructor.dashboard');

    Route::get('/schedule', [InstructorScheduleController::class,'schedMore'])->name('instructor.schedule');

    Route::get('/student', [InstructorStudentController::class,'index'])->name('instructor.student');
    Route::get('/student/{studentId}', [InstructorStudentController::class,'show'])->name('instructor.student.show');
    Route::get('/api/student/{studentId}/subjects', [InstructorStudentController::class,'getStudentSubjects'])->name('instructor.student.subjects');
    
    Route::get('/attendance', [InstructorAttendanceController::class, 'show'])->name('instructor.attendance');
    Route::get('/attendance/mark', [InstructorAttendanceController::class, 'markForm'])->name('instructor.attendance.mark.form');
    Route::post('/attendance/mark', [InstructorAttendanceController::class, 'mark'])->name('instructor.attendance.mark');
    Route::post('/attendance/bulk-mark', [InstructorAttendanceController::class, 'bulkMark'])->name('instructor.attendance.bulk.mark');
        
    Route::get('/reports',[InstructorStudentGradeController::class, 'gradeSheet'])->name('instructor.report');
    Route::get('/grade-input',[InstructorStudentGradeController::class, 'gradeInput'])->name('instructor.grade.input');
    Route::post('/reports/grade',[InstructorStudentGradeController::class, 'saveGrade'])->name('instructor.grade.save');
 
    Route::post(
     '/reports/evaluations',
     [InstructorStudentGradeController::class,'saveEvaluations']
     )->name('instructor.evaluations.save');

    Route::get('/announcement',[InstructorAnnouncementController::class, 'index'])->name('instructor.announcement');
    Route::post('/announcement',[InstructorAnnouncementController::class, 'store'])->name('instructor.announcement.store');

});

// API Routes for real-time grade fetching
Route::prefix('api')
    ->middleware(['auth'])
    ->group(function(){
        Route::get('/student/grades', [InstructorStudentGradeController::class, 'getStudentGrades'])->name('api.student.grades');
        // Route::get('/student/attendance', [StudentAttendanceController::class, 'getAttendance'])->name('api.student.attendance');
    });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

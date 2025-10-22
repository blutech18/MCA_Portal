@extends('layouts.admin_base')

@section('title', 'Admin - Classes')
@section('header', 'Manage Sections')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/style_admin_classes.css') }}">
  <link rel="stylesheet" href="{{ asset('css/add-student-modal.css') }}">
  <style>
    /* Alert Notification Styles */
    .alert {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      z-index: 9999;
      font-weight: 500;
      font-size: 14px;
      max-width: 400px;
      animation: slideInRight 0.3s ease-out;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    /* Animation for notification */
    @keyframes slideInRight {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideOutRight {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(100%);
        opacity: 0;
      }
    }

    /* Strand field styling for SHS */
    #strand-group {
      transition: all 0.3s ease;
    }

    #strand-group.show-required label::after {
      content: " *";
      color: #dc3545;
      font-weight: bold;
    }

    #section-strand.error {
      border-color: #dc3545;
      box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
    }

    /* Close button for alert */
    .alert-close {
      position: absolute;
      top: 5px;
      right: 10px;
      background: none;
      border: none;
      font-size: 18px;
      cursor: pointer;
      color: inherit;
      opacity: 0.7;
    }

    .alert-close:hover {
      opacity: 1;
    }

    /* Edit Modal Styling */
    .overlay-edit {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-footer {
      padding: 20px;
      border-top: 1px solid #e5e7eb;
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      background-color: #f9fafb;
      border-radius: 0 0 8px 8px;
    }

    .btn-primary {
      background: #2563eb;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .btn-primary:hover {
      background: #1d4ed8;
    }

    .btn-secondary {
      background: #6b7280;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .btn-secondary:hover {
      background: #4b5563;
    }
  </style>
@endpush

@push('head')
  <style>
    .classes-page {
      padding: 20px;
    }
    
    /* Page Header */
    .page-header {
      padding: 0 0 20px 0;
      margin-bottom: 0;
    }
    
    .page-header h2 {
      margin: 0;
      color: #1f2937;
      font-size: 24px;
      font-weight: 600;
    }
    
    .add-student-btn, .add-section-btn {
      background: #3b82f6;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    
    .add-student-btn:hover, .add-section-btn:hover {
      background: #2563eb;
    }
    
    /* Controls Section */
    .controls-section {
      background: #f9fafb;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
    }
    
    .school-year-info {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
      padding-bottom: 16px;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .school-year-info h3 {
      margin: 0;
      color: #1f2937;
      font-size: 16px;
      font-weight: 600;
    }
    
    .action-buttons {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .filter-controls {
      display: flex;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    
    .grade-filter, .search-control {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .grade-filter label {
      font-weight: 500;
      color: #374151;
    }
    
    .grade-filter select, .search-control input {
      padding: 8px 12px;
      border: 1px solid #d1d5db;
      border-radius: 4px;
      font-size: 14px;
    }
    
    
    /* Section Cards Styling */
    .strand-box {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 16px 20px;
      margin-bottom: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .strand-box h2 {
      color: #1f2937;
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 8px 0;
    }
    
    .strand-box h3 {
      color: #6b7280;
      font-size: 16px;
      font-weight: 500;
      margin: 0 0 16px 0;
    }
    
    /* Table Styling */
    .strand-box table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 16px;
    }
    
    .strand-box table thead th {
      background-color: #f9fafb;
      color: #000000;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 2px solid #e5e7eb;
      font-size: 14px;
    }
    
    .strand-box table tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #e5e7eb;
      font-size: 14px;
    }
    
    .strand-box table tbody tr:hover {
      background-color: #f9fafb;
    }
    
    /* Button Styling */
    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    
    .btn-success {
      background: #10b981;
      color: white;
    }
    
    .btn-success:hover {
      background: #059669;
    }
    
    .btn-warning {
      background: #f59e0b;
      color: white;
    }
    
    .btn-warning:hover {
      background: #d97706;
    }
    
    .edit-btn {
      background: #6b7280;
      color: white;
    }
    
    .edit-btn:hover {
      background: #4b5563;
    }
    
    /* Status Styling */
    .text-green-600 {
      color: #059669;
    }
    
    .text-red-600 {
      color: #dc2626;
    }
    
    .text-gray-600 {
      color: #6b7280;
    }
    
    
    .btn-danger {
      background: #dc2626;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }
    
    .btn-danger:hover {
      background: #b91c1c;
    }
    
    /* Logout Modal Styling - Consistent with admin subjects */
    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }

    .confirm-btn, .cancel-btn {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin: 10px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .confirm-btn {
      background: red;
      color: white;
    }

    .cancel-btn {
      background: gray;
      color: white;
    }
  </style>
@endpush

@section('content')
  <div class="classes-page">
          <!-- Success/Error Notifications -->
          @if(session('success'))
              <div class="alert alert-success" id="success-alert">
                  <button class="alert-close" onclick="closeAlert('success-alert')">&times;</button>
                  <strong>Success!</strong> {!! htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8') !!}
              </div>
          @endif

          @if(session('error'))
              <div class="alert alert-error" id="error-alert">
                  <button class="alert-close" onclick="closeAlert('error-alert')">&times;</button>
                  <strong>Error!</strong> {!! htmlspecialchars(session('error'), ENT_QUOTES, 'UTF-8') !!}
              </div>
          @endif

          <!-- Student Credentials Modal -->
          @if(request()->has('new_username') && request()->has('new_password'))
          <div id="credentials-modal" class="overlay" style="display: flex;">
              <div class="add-student-modal" style="max-width: 600px;">
                  <div class="modal-header">
                      <div class="header-content">
                          <div class="icon">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                                  <path d="M2 17l10 5 10-5M2 12l10 5 10-5"></path>
                              </svg>
                          </div>
                          <div class="header-text">
                              <h2>🎉 Student Account Created Successfully!</h2>
                              <p>Save these credentials - they won't be shown again</p>
                          </div>
                      </div>
                      <button type="button" class="close-btn" onclick="closeCredentialsModal()">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <line x1="18" y1="6" x2="6" y2="18"></line>
                              <line x1="6" y1="6" x2="18" y2="18"></line>
                          </svg>
                      </button>
                  </div>
                  <div class="modal-body" style="padding: 30px;">
                      <div style="background: #f8f9fa; border-left: 4px solid #28a745; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                          <h3 style="margin-top: 0; color: #28a745;">
                              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                              </svg>
                              Login Credentials
                          </h3>
                          <div style="background: white; padding: 15px; border-radius: 6px; margin: 15px 0;">
                              <div style="margin-bottom: 15px;">
                                  <label style="display: block; font-weight: 600; color: #495057; margin-bottom: 5px;">Username:</label>
                                  <div style="display: flex; align-items: center; gap: 10px;">
                                      <code id="username-display" style="flex: 1; background: #e9ecef; padding: 10px; border-radius: 4px; font-size: 16px; font-weight: bold; color: #212529;">{{ request('new_username') }}</code>
                                      <button onclick="copyToClipboard('username-display')" style="padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; white-space: nowrap;">
                                          📋 Copy
                                      </button>
                                  </div>
                              </div>
                              <div>
                                  <label style="display: block; font-weight: 600; color: #495057; margin-bottom: 5px;">Password:</label>
                                  <div style="display: flex; align-items: center; gap: 10px;">
                                      <code id="password-display" style="flex: 1; background: #e9ecef; padding: 10px; border-radius: 4px; font-size: 16px; font-weight: bold; color: #212529;">{{ request('new_password') }}</code>
                                      <button onclick="copyToClipboard('password-display')" style="padding: 8px 12px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; white-space: nowrap;">
                                          📋 Copy
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 8px;">
                          <h4 style="margin-top: 0; color: #856404;">
                              ⚠️ Important Instructions
                          </h4>
                          <ul style="margin: 10px 0; padding-left: 20px; color: #856404;">
                              <li><strong>Save these credentials immediately</strong> - they will not be displayed again</li>
                              <li>Distribute these credentials <strong>physically</strong> to the student</li>
                              <li>Advise the student to <strong>change their password</strong> after first login</li>
                              <li>Username format: <code>lastname.IDnumber</code></li>
                              <li>Password format: <code>lastnamebirthyear</code></li>
                          </ul>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary" onclick="printCredentials()">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                              <polyline points="6 9 6 2 18 2 18 9"></polyline>
                              <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                              <rect x="6" y="14" width="12" height="8"></rect>
                          </svg>
                          Print Credentials
                      </button>
                      <button type="button" class="btn btn-secondary" onclick="closeCredentialsModal()">I've Saved the Credentials</button>
                  </div>
              </div>
          </div>
          @endif

    <!-- Page Header -->
    <div class="page-header">
    </div>

    <!-- Controls Section -->
    <div class="controls-section">
      <div class="school-year-info">
                @php
          $now = now();
                  if ($now->month >= 1 && $now->month <= 5) {
                      $startYear = $now->year - 1;
                      $endYear = $now->year;
                  } else {
                      $startYear = $now->year;
                      $endYear = $now->year + 1;
                  }
                  $schoolYear = "$startYear-$endYear";
                @endphp
        <h3>School Year: {{$schoolYear}}</h3>
        <div class="action-buttons">
          <button class="add-student-btn">+ Add Student</button>
          <button class="add-section-btn">+ Add Section</button>
          <button type="button" class="btn btn-danger" onclick="showResetConfirmation()">Reset All to Not Enrolled</button>
          <form id="reset-form" action="{{ route('admin.students.resetEnrollment') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </div>

      <div class="filter-controls">
        <div class="grade-filter">
                <label for="sort">Display Grade:</label>
                <select id="sort" name="sort">
                  <option value="">-- Select Grade --</option>
                  <option value="7">Grade 7</option>
                  <option value="8">Grade 8</option>
                  <option value="9">Grade 9</option>
                  <option value="10">Grade 10</option>
                  <option value="11">Grade 11</option>
                  <option value="12">Grade 12</option>
                </select>
              </div>

        <div class="search-control">
                <input type="text" id="search" placeholder="Search student">
        </div>
              </div>
            </div>
            
    <!-- Sections -->
              @foreach($student_section as $section)
                <div
                  class="strand-box"
                  data-grade="{{ $section->gradeLevel && $section->gradeLevel->name ? $section->gradeLevel->name : 'Unknown' }}"
                >
                  @if(is_null($section->strand_id))
                    <h2>{{ $section->gradeLevel && $section->gradeLevel->name ? $section->gradeLevel->name : 'Unknown Grade' }}</h2>
                    <h3>Section {{ $section->section_name }}</h3>
                  @else
                    <h2>{{ $section->gradeLevel && $section->gradeLevel->name ? $section->gradeLevel->name : 'Unknown Grade' }}</h2>
                    <h3>
                      {{ $section->strand && $section->strand->name ? $section->strand->name : 'Unknown Strand' }} – Section {{ $section->section_name }}
                    </h3>
                  @endif
                  
                  @php
                    // Count students with missing subjects in this section
                    $sectionStudents = $students->filter(fn($stu) =>
                      $stu->section_id == $section->id
                      && (is_null($section->strand_id)
                          ? is_null($stu->strand_id)
                          : $stu->strand_id == $section->strand_id
                        )
                    );
                    
                    $studentsWithMissingSubjects = 0;
                    foreach($sectionStudents as $stu) {
                      $studentSubjects = \App\Models\Grade::where('student_id', $stu->student_id)
                        ->with('subjectModel')
                        ->get()
                        ->pluck('subjectModel.name')
                        ->filter()
                        ->values();
                      
                      $defaultSubjects = \App\Models\Subject::where('is_default', true)
                        ->pluck('name')
                        ->values();
                      
                      if (!$defaultSubjects->diff($studentSubjects)->isEmpty()) {
                        $studentsWithMissingSubjects++;
                      }
                    }
                  @endphp
                  
                  @if($studentsWithMissingSubjects > 0)
                    <div style="margin-bottom: 10px;">
                      <form action="{{ route('admin.assignDefaultSubjectsToSection', $section->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-warning" style="background-color: #ffc107; color: black; padding: 8px 15px; font-size: 14px;" onclick="return confirm('Assign default subjects to all {{ $studentsWithMissingSubjects }} students in this section?')">
                          📚 Assign Subjects to All ({{ $studentsWithMissingSubjects }} students)
                        </button>
                      </form>
                    </div>
                  @endif
            
                  <table>
                    <thead>
                      <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Subjects</th>
                        <th>Date Enrolled</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $sectionStudents = $students->filter(fn($stu) =>
                          $stu->section_id == $section->id
                          && (is_null($section->strand_id)
                              ? is_null($stu->strand_id)
                              : $stu->strand_id == $section->strand_id
                            )
                        );
                      @endphp
            
                      @forelse($sectionStudents as $stu)
                        @php
                          // Get student's subjects from grades table
                          $studentSubjects = \App\Models\Grade::where('student_id', $stu->student_id)
                            ->with('subjectModel')
                            ->get()
                            ->pluck('subjectModel.name')
                            ->filter()
                            ->sort()
                            ->values();
                          
                          // Get default subjects for comparison
                          $defaultSubjects = \App\Models\Subject::where('is_default', true)
                            ->pluck('name')
                            ->sort()
                            ->values();
                          
                          $hasAllSubjects = $defaultSubjects->diff($studentSubjects)->isEmpty();
                          $missingSubjects = $defaultSubjects->diff($studentSubjects);
                        @endphp
                        <tr>
                          <td>{{ optional($stu->studentId)->student_number ?? '—' }}</td>
                          <td>{{ $stu->display_name }}</td>
                          <td>{{ $stu->email }}</td>
                          <td>
                            @if($stu->is_enrolled)
                              <span class="text-green-600 font-semibold">Enrolled</span>
                            @else
                              <span class="text-red-600 font-semibold">Not Enrolled</span>
                            @endif
                          </td>
                          <td>
                            @if($hasAllSubjects)
                              <span class="text-green-600 font-semibold">✅ Complete</span>
                              <br><small class="text-gray-600">{{ $studentSubjects->count() }} subjects</small>
                            @else
                              <span class="text-red-600 font-semibold">❌ Missing</span>
                              <br><small class="text-red-600">Missing: {{ $missingSubjects->implode(', ') }}</small>
                            @endif
                          </td>
                          <td>{{ $stu->created_at->toDateString() }}</td>
                          <td>
                            @if(! $stu->is_enrolled)
                              <form action="{{ route('admin.approveStudent', $stu->student_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                              </form>
                            @else
                              <div style="display: flex; gap: 5px;">
                                <button class="btn edit-btn" onclick="editStudent('{{ $stu->student_id }}', '{{ $stu->display_name }}', '{{ $stu->email }}', '{{ $stu->first_name }}', '{{ $stu->middle_name }}', '{{ $stu->last_name }}', '{{ $stu->contact_number }}', '{{ $stu->address }}', '{{ $stu->lrn }}')">Edit</button>
                                @if(!$hasAllSubjects)
                                  <form action="{{ route('admin.assignDefaultSubjects', $stu->student_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" style="background-color: #ffc107; color: black; padding: 5px 10px; font-size: 12px;">Assign Subjects</button>
                                  </form>
                                @endif
                              </div>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="7">No students found for this section.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              @endforeach
            
    <!-- Add Student Modal -->
            <form action="{{ route('admin_classes.student') }}" method="POST" enctype="multipart/form-data" id="add-student-form">
                @csrf

                @php $en = $enrollee ?? null; @endphp
                <div class="overlay" style="display: none;">
                    <div class="add-student-modal">
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <div class="header-content">
                          <div class="icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                              <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                          </div>
                          <div class="header-text">
                            <h2>Add New Student</h2>
                            <p>Register a new student in the system</p>
                          </div>
                        </div>
                        <button type="button" class="close-btn" onclick="closeStudentModal()">
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                          </svg>
                        </button>
                      </div>

                      <!-- Modal Body -->
                      <div class="modal-body">
                        @if (isset($errors) && $errors->any())
                          <div class="alert alert-danger">
                            <div class="alert-icon">
                              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                              </svg>
                            </div>
                            <div class="alert-content">
                              <h4>Please correct the following errors:</h4>
                              <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                              </ul>
                            </div>
                          </div>
                        @endif

                        <div class="student-form" id="student-form">
                          <div class="form-sections">
                            <!-- Section 1: Profile Picture -->
                            <div class="form-section profile-section">
                              <div class="section-header">
                                <h3>
                                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                  </svg>
                                  Profile Picture
                                </h3>
                              </div>
                              <div class="profile-upload">
                                <div class="photo-container">
                                  <img 
                                    id="student-photo"
                                    src="{{ asset('images/student_user.png') }}"
                                    alt="Student Profile Picture"
                                  >
                                  <div class="photo-overlay">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                      <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                      <circle cx="12" cy="13" r="4"></circle>
                                    </svg>
                                  </div>
                                </div>
                                <input type="file" id="picture-input" name="picture" accept="image/*" style="display: none;">
                                <button type="button" class="btn-upload" onclick="document.getElementById('picture-input').click()">
                                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                    <circle cx="12" cy="13" r="3"></circle>
                                  </svg>
                                  Upload Photo
                                </button>
                              </div>
                            </div>

                            <!-- Section 2: Personal Information -->
                            <div class="form-section personal-section">
                              <div class="section-header">
                                <h3>
                                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="m22 21-3-3m0 0a2 2 0 1 1-2.83-2.83 2 2 0 0 1 2.83 2.83Z"></path>
                                  </svg>
                                  Personal Information
                                </h3>
                              </div>
                              <div class="form-grid">
                                <div class="form-group">
                                  <label for="student_school_id" class="required">Student ID</label>
                                  <input
                                    type="text"
                                    id="student_school_id"
                                    name="student_school_id"
                                    value="{{ old('student_school_id', optional($en)->application_number) }}"
                                    placeholder="Auto-generated on submission"
                                    autocomplete="off"
                                    readonly
                                  >
                                  <small class="form-help">ID will be auto-generated on submission</small>
                                </div>

                                <div class="form-group">
                                  <label for="fname" class="required">First Name</label>
                                  <input
                                    type="text"
                                    id="fname"
                                    name="fname"
                                    value="{{ old('fname', optional($en)->given_name) }}"
                                    placeholder="Enter first name"
                                    required
                                  >
                                </div>

                                <div class="form-group">
                                  <label for="mname">Middle Name</label>
                                  <input 
                                    type="text" 
                                    id="mname" 
                                    name="mname"
                                    value="{{ old('mname', optional($en)->middle_name) }}"
                                    placeholder="Enter middle name (optional)"
                                    autocomplete="mname"
                                  >
                                </div>

                                <div class="form-group">
                                  <label for="lname" class="required">Last Name</label>
                                  <input 
                                    type="text" 
                                    id="lname" 
                                    name="lname"
                                    value="{{ old('lname', optional($en)->surname) }}"
                                    placeholder="Enter last name"
                                    required
                                  >
                                </div>

                                <div class="form-group">
                                  <label for="suffix">Suffix</label>
                                  <select id="suffix" name="suffix">
                                    <option value="">None</option>
                                    <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                    <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                    <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                                    <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                                    <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label class="required">Gender</label>
                                  <div class="radio-group">
                                    <label class="radio-label">
                                      <input type="radio" name="gender" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }} required>
                                      <span class="radio-custom"></span>
                                      Male
                                    </label>
                                    <label class="radio-label">
                                      <input type="radio" name="gender" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }} required>
                                      <span class="radio-custom"></span>
                                      Female
                                    </label>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="dob" class="required">Date of Birth</label>
                                  <input 
                                    type="date" 
                                    id="dob" 
                                    name="dob" 
                                    value="{{ old('dob', optional($en)->dob) }}"
                                    required
                                  >
                                </div>
                              </div>
                            </div>
                            <!-- Section 3: Contact Information -->
                            <div class="form-section contact-section">
                              <div class="section-header">
                                <h3>
                                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                  </svg>
                                  Contact Information
                                </h3>
                              </div>
                              <div class="form-grid">
                                <div class="form-group">
                                  <label for="email" class="required">Email Address</label>
                                  <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', optional($en)->email) }}" 
                                    placeholder="student@example.com"
                                    required
                                  >
                                </div>

                                <div class="form-group">
                                  <label for="contact">Contact Number</label>
                                  <input 
                                    type="tel" 
                                    id="contact" 
                                    name="contact" 
                                    value="{{ old('contact', optional($en)->contact_no) }}"
                                    placeholder="+63 912 345 6789"
                                    pattern="[0-9+\s\-\(\)]{10,15}"
                                  >
                                </div>

                                <div class="form-group full-width">
                                  <label for="address">Address</label>
                                  <textarea 
                                    id="address" 
                                    name="address" 
                                    rows="3"
                                    placeholder="Enter complete address"
                                  >{{ old('address', optional($en)->address) }}</textarea>
                                </div>
                              </div>
                            </div>
                            <!-- Section 4: Academic Information -->
                            <div class="form-section academic-section">
                              <div class="section-header">
                                <h3>
                                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                  </svg>
                                  Academic Information
                                </h3>
                              </div>
                              <div class="form-grid">
                                <div class="form-group">
                                  <label class="required">Grade Level</label>
                                  <div class="grade-level-grid">
                                    @foreach($gradeLevels as $g)
                                      <label class="grade-option">
                                        <input 
                                          type="radio" 
                                          name="grade_level_id" 
                                          value="{{ $g->grade_level_id }}"
                                          data-grade="{{ $g->name }}"
                                          {{ old('grade_level_id') == $g->grade_level_id ? 'checked' : '' }}
                                          required
                                        >
                                        <span class="grade-label">
                                          <span class="grade-number">{{ $g->name }}</span>
                                          <span class="grade-type">
                                            @if($g->name >= 7 && $g->name <= 10)
                                              Junior High
                                            @elseif($g->name >= 11 && $g->name <= 12)
                                              Senior High
                                            @endif
                                          </span>
                                        </span>
                                      </label>
                                    @endforeach
                                  </div>
                                </div>

                                <div class="form-group" id="strand-group" style="display: none;">
                                  <label for="strand">Strand (Senior High Only) <span style="color: #dc3545;">*</span></label>
                                  <select id="strand" name="strand_id">
                                    <option value="">-- Select Strand --</option>
                                    @foreach($allStrands as $s)
                                      <option value="{{ $s->id }}" {{ old('strand_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                    @endforeach
                                  </select>
                                  <small class="form-help">Required for Senior High School (Grade 11-12)</small>
                                </div>

                                <div class="form-group">
                                  <label for="section">Section (Optional)</label>
                                  <select id="section" name="section_id">
                                    <option value="">-- Auto-assign (Recommended) --</option>
                                  </select>
                                  <small class="form-help">Leave blank for auto-assignment. System will create section if needed.</small>
                                </div>

                                <div class="form-group">
                                  <label for="status">Enrollment Status</label>
                                  <select id="status" name="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach($student_status as $status)
                                      <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label for="date_enrolled" class="required">Date Enrolled</label>
                                  <input 
                                    type="date" 
                                    id="date_enrolled" 
                                    name="date_enrolled" 
                                    value="{{ old('date_enrolled', date('Y-m-d')) }}"
                                    required
                                  >
                                </div>

                                <div class="form-group" id="semester-group" style="display: none;">
                                  <label for="semester">Semester (Senior High Only)</label>
                                  <select id="semester" name="semester">
                                    <option value="">-- Select Semester --</option>
                                    <option value="1st" {{ old('semester') == '1st' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2nd" {{ old('semester') == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                                  </select>
                                  <small class="form-help">Optional for Senior High School</small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Modal Footer -->
                      <div class="modal-footer">
                        <div class="footer-info">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m9 12 2 2 4-4"></path>
                          </svg>
                          <span>Student credentials will be auto-generated upon submission</span>
                        </div>
                        <div class="footer-actions">
                          <button type="button" class="btn btn-secondary" onclick="closeStudentModal()">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <line x1="18" y1="6" x2="6" y2="18"></line>
                              <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Cancel
                          </button>
                          <button type="submit" class="btn btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                              <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Add Student
                          </button>
                        </div>
                      </div>
                    </div>
                </div>
            </form>

    <!-- Edit Student Modal -->
    <div class="overlay-edit" style="display: none;">
        <div class="add-student-modal">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="header-content">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </div>
                    <div class="header-text">
                        <h2>Edit Student</h2>
                        <p>Update student information</p>
                    </div>
                </div>
                <button type="button" class="close-btn" onclick="closeEditModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="" method="POST" id="edit-student-form">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hidden student ID -->
                    <input type="hidden" id="edit-student-id" name="student_id">
                    
                    <div class="form-section">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="edit-fname" class="required">First Name</label>
                                <input type="text" id="edit-fname" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-mname">Middle Name</label>
                                <input type="text" id="edit-mname" name="middle_name">
                            </div>
                            <div class="form-group">
                                <label for="edit-lname" class="required">Last Name</label>
                                <input type="text" id="edit-lname" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-lrn">LRN</label>
                                <input type="text" id="edit-lrn" name="lrn">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="edit-email" class="required">Email Address</label>
                                <input type="email" id="edit-email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-contact">Contact Number</label>
                                <input type="tel" id="edit-contact" name="contact_number">
                            </div>
                            <div class="form-group full-width">
                                <label for="edit-address">Address</label>
                                <textarea id="edit-address" name="address" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Update Student</button>
            </div>
        </div>
    </div>

    <!-- Add Section Modal -->
            <div class="overlay-section" style="display: none;">
              <div class="add-section-form">
                <h3>Add Section</h3>
                <form action="{{ route('admin_classes.section.store') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="grade_level">Grade Level:</label>
                    <select id="section-grade-level" name="grade_level_id" required>
                      <option value="">-- Select Grade Level --</option>
                      @foreach($gradeLevels as $g)
                        @if($g->grade_level_id <= 10)
                          <option value="{{ $g->grade_level_id }}" data-name="{{ $g->name }}">{{ $g->name }}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
            
                  <div class="form-group">
                    <label for="section_name">Section Name:</label>
                    <input type="text" name="section_name" placeholder="e.g., Section A, Section B" required>
                    <small class="form-text text-muted">
                      Only Junior High School (Grades 7-10) sections can be created manually. Senior High School sections are automatically created for each strand.
                    </small>
                  </div>
            
                  <button type="submit" class="add-to-section-btn">Add Section</button>
                </form>
            </div>
        </div>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal" style="display: none;">
          <div class="modal-content">
              <p>Are you sure you want to log out?</p>
              <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
              <button class="cancel-btn" onclick="closeModal()">No</button>
          </div>
        </div>
        
    <!-- Reset Confirmation Modal -->
    <div id="reset-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p>Are you sure you want to reset all student enrollment statuses?</p>
        <button class="confirm-btn" onclick="confirmReset()">Yes, Reset</button>
        <button class="cancel-btn" onclick="closeResetModal()">No</button>
    </div>
      </div>
  </div>
@endsection


@push('scripts')
    <script>
      window.enrolleeApiBase = "{{ url('admin/api/enrollee') }}";
      
      // Auto-hide notifications after 5 seconds
      document.addEventListener('DOMContentLoaded', function() {
          const successAlert = document.getElementById('success-alert');
          const errorAlert = document.getElementById('error-alert');
          
          if (successAlert) {
              setTimeout(function() {
                  closeAlert('success-alert');
              }, 5000); // Hide after 5 seconds
          }
          
          if (errorAlert) {
              setTimeout(function() {
                  closeAlert('error-alert');
              }, 7000); // Hide error alerts after 7 seconds (longer for errors)
          }
      });

      // Function to close alert notification
      function closeAlert(alertId) {
          const alert = document.getElementById(alertId);
          if (alert) {
              alert.style.animation = 'slideOutRight 0.3s ease-in';
              setTimeout(function() {
                  alert.remove();
              }, 300);
          }
      }

      // Credentials Modal Functions
      function closeCredentialsModal() {
          const modal = document.getElementById('credentials-modal');
          if (modal) {
              modal.style.display = 'none';
              // Remove query parameters from URL
              const url = new URL(window.location);
              url.searchParams.delete('new_username');
              url.searchParams.delete('new_password');
              window.history.replaceState({}, document.title, url.pathname);
          }
      }

      function copyToClipboard(elementId) {
          const element = document.getElementById(elementId);
          if (element) {
              const text = element.textContent;
              navigator.clipboard.writeText(text).then(() => {
                  // Show temporary success message
                  const button = event.target.closest('button');
                  const originalText = button.innerHTML;
                  button.innerHTML = '✓ Copied!';
                  button.style.background = '#28a745';
                  setTimeout(() => {
                      button.innerHTML = originalText;
                      button.style.background = '#007bff';
                  }, 2000);
              }).catch(err => {
                  alert('Failed to copy: ' + err);
              });
          }
      }

      function printCredentials() {
          const username = document.getElementById('username-display').textContent;
          const password = document.getElementById('password-display').textContent;
          
          const printWindow = window.open('', '', 'height=600,width=800');
          printWindow.document.write('<html><head><title>Student Login Credentials</title>');
          printWindow.document.write('<style>');
          printWindow.document.write('body { font-family: Arial, sans-serif; padding: 40px; }');
          printWindow.document.write('h1 { color: #7a222b; border-bottom: 3px solid #7a222b; padding-bottom: 10px; }');
          printWindow.document.write('.credential-box { background: #f8f9fa; border: 2px solid #dee2e6; padding: 20px; margin: 20px 0; border-radius: 8px; }');
          printWindow.document.write('.credential-label { font-weight: bold; color: #495057; margin-bottom: 5px; }');
          printWindow.document.write('.credential-value { font-size: 18px; font-family: monospace; background: white; padding: 10px; border-radius: 4px; margin-bottom: 15px; }');
          printWindow.document.write('.warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin-top: 20px; }');
          printWindow.document.write('</style>');
          printWindow.document.write('</head><body>');
          printWindow.document.write('<h1>MCA Montessori School - Student Login Credentials</h1>');
          printWindow.document.write('<div class="credential-box">');
          printWindow.document.write('<div class="credential-label">Username:</div>');
          printWindow.document.write('<div class="credential-value">' + username + '</div>');
          printWindow.document.write('<div class="credential-label">Password:</div>');
          printWindow.document.write('<div class="credential-value">' + password + '</div>');
          printWindow.document.write('</div>');
          printWindow.document.write('<div class="warning">');
          printWindow.document.write('<strong>⚠️ Important:</strong><br>');
          printWindow.document.write('• Keep these credentials secure<br>');
          printWindow.document.write('• Change password after first login<br>');
          printWindow.document.write('• Do not share with unauthorized persons');
          printWindow.document.write('</div>');
          printWindow.document.write('<p style="margin-top: 30px; color: #666; font-size: 12px;">Generated on: ' + new Date().toLocaleString() + '</p>');
          printWindow.document.write('</body></html>');
          printWindow.document.close();
          printWindow.print();
      }
    </script>

    <!-- Essential functionality for Add Student and Add Section buttons -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Add Student button functionality
        const addStudentBtn = document.querySelector(".add-student-btn");
        const overlay = document.querySelector(".overlay");
        
        if (addStudentBtn && overlay) {
          addStudentBtn.addEventListener("click", () => {
            overlay.style.display = "flex";
            // Reset form when opening
            const form = document.getElementById('add-student-form');
            if (form) form.reset();
            // Reset photo to default
            const photo = document.getElementById('student-photo');
            if (photo) photo.src = '/images/student_user.png';
            console.log("Add Student modal opened");
          });

          overlay.addEventListener("click", event => {
            if (event.target === overlay) {
              overlay.style.display = "none";
            }
          });
        }

        // Add Section button functionality
        const addSectionBtn = document.querySelector(".add-section-btn");
        const overlaySection = document.querySelector(".overlay-section");
        
        if (addSectionBtn && overlaySection) {
          addSectionBtn.addEventListener("click", () => {
            overlaySection.style.display = "flex";
            console.log("Add Section modal opened");
          });

          overlaySection.addEventListener("click", e => {
            if (e.target === overlaySection) {
              overlaySection.style.display = "none";
            }
          });
        }

        // Handle image preview when file is selected
        const appIdInput = document.getElementById('student_school_id');
        const photoImg = document.getElementById('student-photo');
        const pictureInput = document.getElementById('picture-input');
        if (pictureInput && photoImg) {
          pictureInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
              const reader = new FileReader();
              reader.onload = (event) => {
                photoImg.src = event.target.result;
              };
              reader.readAsDataURL(file);
            }
          });
        }

        // Keyboard support for closing modals
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape') {
            if (overlay && overlay.style.display === 'flex') {
              overlay.style.display = 'none';
            }
            if (overlaySection && overlaySection.style.display === 'flex') {
              overlaySection.style.display = 'none';
            }
          }
        });
      });

      // Edit Student Functions
      function editStudent(studentId, displayName, email, firstName, middleName, lastName, contactNumber, address, lrn) {
        console.log('Editing student:', { studentId, displayName, email, firstName, middleName, lastName, contactNumber, address, lrn });
        
        // Populate the edit form
        document.getElementById('edit-student-id').value = studentId;
        document.getElementById('edit-fname').value = firstName || '';
        document.getElementById('edit-mname').value = middleName || '';
        document.getElementById('edit-lname').value = lastName || '';
        document.getElementById('edit-lrn').value = lrn || '';
        document.getElementById('edit-email').value = email || '';
        document.getElementById('edit-contact').value = contactNumber || '';
        document.getElementById('edit-address').value = address || '';
        
        // Set form action URL
        const form = document.getElementById('edit-student-form');
        form.action = `/admin/students/${studentId}/update`;
        
        // Show the edit modal
        document.querySelector('.overlay-edit').style.display = 'flex';
      }

      function closeEditModal() {
        document.querySelector('.overlay-edit').style.display = 'none';
        // Reset form when closing
        const form = document.getElementById('edit-student-form');
        if (form) form.reset();
      }

      function submitEditForm() {
        const form = document.getElementById('edit-student-form');
        if (form) {
          form.submit();
        }
      }

      // Close edit modal when clicking overlay
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('overlay-edit')) {
          closeEditModal();
        }
      });
    </script>

    @if (isset($errors) && $errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show the add student modal if there are validation errors
                document.querySelector('.overlay').style.display = 'flex';
            });
        </script>
    @endif

    <script>
      function toggleSubMenu(event) {
          event.preventDefault();
          const submenu = event.target.nextElementSibling;
          submenu.classList.toggle('hidden');
        }

      // Show manual student addition form
      function showInsertModal() {
        document.querySelector('.overlay').style.display = 'flex';
      }

      // Show section addition form (for "Add Section" button)
      function showSectionModal() {
        document.querySelector('.overlay-section').style.display = 'flex';
      }

      // Close modal
      function closeModal() {
        document.querySelector('.overlay').style.display = 'none';
        document.querySelector('.overlay-section').style.display = 'none';
      }

      // Close student modal specifically
      function closeStudentModal() {
        const overlay = document.querySelector('.overlay');
        if (overlay) {
          overlay.style.display = 'none';
          // Reset form when closing
          const form = document.getElementById('add-student-form');
          if (form) form.reset();
          // Reset photo to default
          const photo = document.getElementById('student-photo');
          if (photo) photo.src = '/images/student_user.png';
        }
      }

      // Close modal when clicking overlay
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('overlay') || e.target.classList.contains('overlay-section')) {
          closeModal();
        }
      });

      document.addEventListener('DOMContentLoaded', function() {
        const fnameField = document.getElementById('fname');
        const lnameField = document.getElementById('lname');
        const studentIdField = document.getElementById('student_school_id');
        
        if (fnameField && lnameField && studentIdField) {
          // Leave blank; server will generate on submit
        }

        // Handle grade level select changes (Section Form) - Only for JHS now
        const gradeSelect = document.getElementById('section-grade-level');
        
        if (gradeSelect) {
          gradeSelect.addEventListener('change', function() {
            const gradeLevelId = parseInt(this.value);
            console.log('Grade level changed to:', gradeLevelId);
            
            // All available grades are JHS (7-10), so no special handling needed
            console.log('JHS grade selected:', gradeLevelId);
          });
        }

        // Handle grade level radio button changes for strand visibility (Student Form)
        const gradeRadios = document.querySelectorAll('input[name="grade_level_id"]');
        const studentStrandSelect = document.getElementById('strand');
        const studentStrandGroup = document.querySelector('#strand-group');
        const semesterGroup = document.querySelector('#semester-group');
        const sectionSelect = document.getElementById('section');
        
        // Function to load sections based on grade level and strand
        function loadSections(gradeLevelId, strandId = null) {
          if (!gradeLevelId || !sectionSelect) {
            return;
          }
          
          console.log('Loading sections for grade:', gradeLevelId, 'strand:', strandId);
          
          // Build URL with query parameters
          let url = '{{ route("api.sections") }}';
          url += '?grade_level_id=' + gradeLevelId;
          if (strandId) {
            url += '&strand_id=' + strandId;
          }
          
          // Fetch sections from API
          fetch(url)
            .then(response => response.json())
            .then(data => {
              console.log('Sections loaded:', data);
              
              // Clear existing options and add auto-assign option
              sectionSelect.innerHTML = '<option value="">-- Auto-assign (Recommended) --</option>';
              
              // Add sections to dropdown
              if (data.sections && data.sections.length > 0) {
                data.sections.forEach(section => {
                  const option = document.createElement('option');
                  option.value = section.id;
                  option.textContent = section.section_name;
                  sectionSelect.appendChild(option);
                });
                
                console.log('Sections loaded:', data.sections.length, 'section(s) available');
              } else {
                // No sections available - auto-assign will create one
                console.log('No sections available for this grade/strand, auto-assign will create new section');
              }
            })
            .catch(error => {
              console.error('Error loading sections:', error);
              sectionSelect.innerHTML = '<option value="">-- Auto-assign (Recommended) --</option>';
              console.log('Error loading sections, but auto-assign is still available');
            });
        }
        
        if (gradeRadios && studentStrandSelect && studentStrandGroup) {
          gradeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
              const gradeName = this.getAttribute('data-grade');
              // Extract numeric part from "Grade 11" or "11"
              const gradeNum = parseInt(gradeName.replace(/\D/g, ''));
              const gradeLevelId = this.value;
              
              console.log('Grade level changed to:', gradeName, '→ Numeric:', gradeNum, 'ID:', gradeLevelId);
              
              // Show strand field for grades 11-12 (SHS), hide for grades 7-10 (JHS)
              if (gradeNum >= 11 && gradeNum <= 12) {
                // Show strand and semester fields for Senior High
                studentStrandGroup.style.display = 'block';
                studentStrandSelect.required = true;
                studentStrandSelect.classList.remove('error');
                
                if (semesterGroup) {
                  semesterGroup.style.display = 'block';
                }
                
                // Don't load sections yet - wait for strand selection
                sectionSelect.innerHTML = '<option value="">-- Auto-assign (Recommended) --</option>';
                // Section dropdown is always enabled for auto-assignment
                
                console.log('Senior High selected - strand and semester fields shown');
              } else {
                // Hide strand and semester fields for Junior High
                studentStrandGroup.style.display = 'none';
                studentStrandSelect.required = false;
                studentStrandSelect.value = '';
                studentStrandSelect.classList.remove('error');
                
                if (semesterGroup) {
                  semesterGroup.style.display = 'none';
                }
                
                // For JHS (grades 7-10), load sections immediately
                loadSections(gradeLevelId, null);
                
                console.log('Junior High selected - strand and semester fields hidden, loading sections');
              }
            });
          });
          
          // Handle strand changes for SHS students
          if (studentStrandSelect) {
            studentStrandSelect.addEventListener('change', function() {
              const selectedGradeRadio = document.querySelector('input[name="grade_level_id"]:checked');
              if (selectedGradeRadio) {
                const gradeLevelId = selectedGradeRadio.value;
                const strandId = this.value;
                
                if (strandId) {
                  console.log('Strand changed to:', strandId, 'for grade:', gradeLevelId);
                  loadSections(gradeLevelId, strandId);
                } else {
                  // No strand selected, but still allow auto-assign
                  sectionSelect.innerHTML = '<option value="">-- Auto-assign (Recommended) --</option><option value="" disabled>Select strand to view sections</option>';
                  sectionSelect.disabled = false;
                }
              }
            });
          }
        }
        
        // Add form validation for section creation
        const sectionForm = document.querySelector('form[action*="section.store"]');
        if (sectionForm) {
          sectionForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Always prevent default form submission
            
            const gradeLevelId = parseInt(document.getElementById('section-grade-level').value);
            const sectionName = document.querySelector('input[name="section_name"]').value.trim();
            
            console.log('AJAX Form submission - Grade Level ID:', gradeLevelId, 'Section Name:', sectionName);
            
            // Client-side validation
            let hasErrors = false;
            
            // Check if grade level is selected
            if (!gradeLevelId || gradeLevelId === '') {
              console.log('Validation failed: No grade level selected');
              alert('Please select a grade level.');
              document.getElementById('section-grade-level').focus();
              hasErrors = true;
            }
            
            // Check if section name is provided
            if (!sectionName) {
              console.log('Validation failed: No section name provided');
              alert('Please enter a section name.');
              document.querySelector('input[name="section_name"]').focus();
              hasErrors = true;
            }
            
            if (hasErrors) {
              console.log('Client-side validation failed, not submitting');
              return false;
            }
            
            console.log('Client-side validation passed, submitting via AJAX');
            
            // Prepare form data
            const formData = new FormData(sectionForm);
            
            // Submit via AJAX
            fetch(sectionForm.action, {
              method: 'POST',
              body: formData,
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              }
            })
            .then(response => {
              console.log('AJAX Response received:', response.status, response.statusText);
              return response.text();
            })
            .then(data => {
              console.log('AJAX Response data:', data);
              
              // Check if response contains success message
              if (data.includes('Section added successfully')) {
                console.log('Section created successfully!');
                alert('Section created successfully!');
                
                // Reset form
                sectionForm.reset();
                
                // Hide modal
                const overlaySection = document.querySelector('.overlay-section');
                if (overlaySection) {
                  overlaySection.style.display = 'none';
                }
                
                // Optionally reload the page to show the new section
                setTimeout(() => {
                  window.location.reload();
                }, 1000);
              } else if (data.includes('Please correct the errors below')) {
                console.log('Validation errors detected');
                alert('Please check the form for errors and try again.');
              } else {
                console.log('Unexpected response:', data);
                alert('An error occurred. Please check the console for details.');
              }
            })
            .catch(error => {
              console.error('AJAX Error:', error);
              alert('An error occurred while creating the section. Please check the console for details.');
            });
          });
        }

        // Add form validation for student creation
        const studentForm = document.querySelector('form[id="add-student-form"]');
        if (studentForm) {
          studentForm.addEventListener('submit', function(e) {
            const selectedGradeRadio = document.querySelector('input[name="grade_level_id"]:checked');
            const gradeLevelId = selectedGradeRadio ? parseInt(selectedGradeRadio.value) : null;
            const strandId = document.getElementById('strand').value;
            
            // Check if grade level is selected
            if (!gradeLevelId) {
              e.preventDefault();
              alert('Please select a grade level.');
              return false;
            }
            
            // Check if strand is required but not selected (only for SHS)
            if (gradeLevelId >= 11 && gradeLevelId <= 12 && (!strandId || strandId === '')) {
              e.preventDefault();
              studentStrandSelect.classList.add('error');
              alert('Please select a strand for Senior High School (Grade 11-12) students.');
              document.getElementById('strand').focus();
              return false;
            } else {
              studentStrandSelect.classList.remove('error');
            }
            
            // Section is optional - no validation needed
          });
        }

        // Grade filter functionality
        const gradeFilter = document.getElementById('sort');
        if (gradeFilter) {
          gradeFilter.addEventListener('change', function() {
            const selectedGrade = this.value;
            const strandBoxes = document.querySelectorAll('.strand-box');
            
            strandBoxes.forEach(box => {
              const boxGrade = box.getAttribute('data-grade');
              
              // Extract numeric grade from "Grade X" format (e.g., "Grade 7" -> "7")
              const boxGradeNumber = boxGrade ? boxGrade.replace(/\D/g, '') : '';
              
              if (selectedGrade === '' || selectedGrade === boxGradeNumber) {
                // Show the box if no filter is selected or if it matches the selected grade
                box.style.display = 'block';
              } else {
                // Hide the box if it doesn't match the selected grade
                box.style.display = 'none';
              }
            });
          });
        }
      });
    </script>

    <!-- Modal Functions -->
    <script>
      function showResetConfirmation() {
        const modal = document.getElementById('reset-modal');
        if (modal) {
          modal.style.display = 'flex';
        }
      }

      function confirmReset() {
        const form = document.getElementById('reset-form');
        if (form) {
          form.submit();
        }
      }

      function closeResetModal() {
        const modal = document.getElementById('reset-modal');
        if (modal) {
          modal.style.display = 'none';
        }
      }

      function closeModal() {
        const modal = document.getElementById('confirm-modal');
        if (modal) {
          modal.style.display = 'none';
        }
      }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush

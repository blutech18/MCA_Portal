<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MCA Montessori School - Mark Attendance</title>
    <link rel="stylesheet" href="{{ asset('css/ins_attendance.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .attendance-form {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-filters {
            display: flex;
            gap: 20px;
            align-items: end;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }
        
        .filter-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #7a222b;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #7a222b;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a1a1f;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #545b62;
        }
        
        .students-list {
            margin-top: 20px;
        }
        
        .student-row {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #fafafa;
            transition: all 0.3s ease;
        }
        
        .student-row:hover {
            background: #f0f0f0;
            border-color: #7a222b;
        }
        
        .student-info {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #7a222b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .student-details h4 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
        
        .student-details p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        .attendance-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .status-buttons {
            display: flex;
            gap: 5px;
        }
        
        .status-btn {
            padding: 8px 12px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .status-btn.active {
            border-color: #7a222b;
            background: #7a222b;
            color: white;
        }
        
        .status-btn.present.active {
            border-color: #28a745;
            background: #28a745;
        }
        
        .status-btn.absent.active {
            border-color: #dc3545;
            background: #dc3545;
        }
        
        .status-btn.late.active {
            border-color: #ffc107;
            background: #ffc107;
            color: #333;
        }
        
        .time-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .time-inputs input {
            padding: 5px 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
            width: 80px;
            font-size: 12px;
        }
        
        .bulk-actions {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background: #28a745;
        }
        
        .notification.error {
            background: #dc3545;
        }
        
        .no-students {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .no-students i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ddd;
        }
        
        @media (max-width: 768px) {
            .form-filters {
                flex-direction: column;
                align-items: stretch;
            }
            
            .student-row {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .attendance-controls {
                justify-content: space-between;
            }
            
            .bulk-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
          <div class="logo-container">
              <img src="{{ asset('images/logo.png') }}" alt="MCA Montessori School" class="logo">
              <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
          </div>
          <nav class="sidebar-nav">
            <ul>
                <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                <li>
                    <a href="{{ route('instructor.schedule') }}" class="nav-item">CLASSES</a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                        <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                <li><a href="{{ route('instructor.attendance.mark.form') }}" class="nav-item active">MARK ATTENDANCE</a></li>
                <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
            </ul>
          </nav>
        </div>

        <!-- Mobile Menu Button -->
        <div class="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>MARK ATTENDANCE</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/instructor_user.png') }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->short_name }}</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon"></a>
                    <a href="javascript:void(0)" class="icon-link logout-btn" onclick="confirmExit()" title="Logout">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #1A2B49;"></i>
                    </a>
                    </div>
                </div>
            </div>
          
            <!-- Attendance Marking Content -->
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-clipboard-check"></i> Mark Daily Attendance</h2>
                    <p>Record student attendance for your classes</p>
                </div>
                
                <div class="attendance-form">
                    <div class="form-header">
                        <h3><i class="fas fa-calendar-day"></i> Attendance Form</h3>
                        <div>
                            <a href="{{ route('instructor.attendance') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Reports
                            </a>
                        </div>
                    </div>
                    
                    <form method="GET" action="{{ route('instructor.attendance.mark.form') }}" class="form-filters">
                        <div class="filter-group">
                            <label for="class_id"><i class="fas fa-chalkboard-teacher"></i> Select Class:</label>
                            <select id="class_id" name="class_id" required>
                                <option value="">Choose a class</option>
                                @if(isset($classes) && count($classes) > 0)
                                    @foreach($classes as $class)
                                        <option value="{{ $class['id'] }}" {{ $selectedClassId == $class['id'] ? 'selected' : '' }}>
                                            {{ $class['name'] }} - {{ $class['section'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="date"><i class="fas fa-calendar-alt"></i> Date:</label>
                            <input type="date" id="date" name="date" value="{{ $selectedDate }}" required>
                        </div>
                        
                        <div class="filter-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Load Students
                            </button>
                        </div>
                    </form>
                    
                    @if(isset($selectedClass) && $selectedClass)
                        <div class="class-info" style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <h4><i class="fas fa-info-circle"></i> Class Information</h4>
                            <p><strong>Class:</strong> {{ $selectedClass->class->name }}</p>
                            <p><strong>Section:</strong> {{ $selectedClass->class->section->section_name }}</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</p>
                        </div>
                        
                        @if($students->count() > 0)
                            <div class="bulk-actions">
                                <button type="button" class="btn btn-success" onclick="markAllPresent()">
                                    <i class="fas fa-check-circle"></i> Mark All Present
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="markAllAbsent()">
                                    <i class="fas fa-times-circle"></i> Mark All Absent
                                </button>
                                <button type="button" class="btn btn-primary" onclick="saveAttendance()">
                                    <i class="fas fa-save"></i> Save Attendance
                                </button>
                            </div>
                            
                            <form id="attendance-form" method="POST" action="{{ route('instructor.attendance.bulk.mark') }}">
                                @csrf
                                <input type="hidden" name="instructor_class_id" value="{{ $selectedClassId }}">
                                <input type="hidden" name="date" value="{{ $selectedDate }}">
                                
                                <div class="students-list">
                                    @foreach($students as $student)
                                        @php
                                            $existing = $existingAttendance->get($student->student_id);
                                        @endphp
                                        <div class="student-row">
                                            <div class="student-info">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->last_name, 0, 1)) }}
                                                </div>
                                                <div class="student-details">
                                                    <h4>{{ $student->first_name }} {{ $student->last_name }}</h4>
                                                    <p>Student ID: {{ $student->student_id }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="attendance-controls">
                                                <div class="status-buttons">
                                                    <button type="button" class="status-btn present {{ $existing && $existing->status == 'present' ? 'active' : '' }}" 
                                                            data-student="{{ $student->student_id }}" data-status="present">
                                                        <i class="fas fa-check"></i> Present
                                                    </button>
                                                    <button type="button" class="status-btn absent {{ $existing && $existing->status == 'absent' ? 'active' : '' }}" 
                                                            data-student="{{ $student->student_id }}" data-status="absent">
                                                        <i class="fas fa-times"></i> Absent
                                                    </button>
                                                    <button type="button" class="status-btn late {{ $existing && $existing->status == 'late' ? 'active' : '' }}" 
                                                            data-student="{{ $student->student_id }}" data-status="late">
                                                        <i class="fas fa-clock"></i> Late
                                                    </button>
                                                </div>
                                                
                                                <div class="time-inputs">
                                                    <input type="time" name="attendance[{{ $student->student_id }}][time_in]" 
                                                           value="{{ $existing ? $existing->time_in : '' }}" 
                                                           placeholder="Time In">
                                                    <input type="time" name="attendance[{{ $student->student_id }}][time_out]" 
                                                           value="{{ $existing ? $existing->time_out : '' }}" 
                                                           placeholder="Time Out">
                                                </div>
                                                
                                                <input type="hidden" name="attendance[{{ $student->student_id }}][student_id]" value="{{ $student->student_id }}">
                                                <input type="hidden" name="attendance[{{ $student->student_id }}][status]" 
                                                       value="{{ $existing ? $existing->status : 'present' }}" 
                                                       class="status-input">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        @else
                            <div class="no-students">
                                <i class="fas fa-user-slash"></i>
                                <h3>No Students Found</h3>
                                <p>No students are enrolled in this class section.</p>
                            </div>
                        @endif
                    @else
                        <div class="no-students">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <h3>Select a Class</h3>
                            <p>Please select a class and date to mark attendance.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
            <button class="cancel-btn" onclick="closeModal()">No</button>
        </div>
    </div>
    
    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('active');
                });
            }
            
            // Status button handlers
            document.querySelectorAll('.status-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.dataset.student;
                    const status = this.dataset.status;
                    
                    // Remove active class from all buttons for this student
                    document.querySelectorAll(`[data-student="${studentId}"]`).forEach(b => b.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Update hidden input
                    const statusInput = document.querySelector(`input[name="attendance[${studentId}][status]"]`);
                    if (statusInput) {
                        statusInput.value = status;
                    }
                });
            });
            
            // Time input validation
            document.querySelectorAll('input[type="time"]').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value && !isValidTimeFormat(this.value)) {
                        this.style.borderColor = '#dc3545';
                        this.title = 'Please enter time in HH:MM format (e.g., 08:30)';
                    } else {
                        this.style.borderColor = '#ddd';
                        this.title = '';
                    }
                });
                
                input.addEventListener('input', function() {
                    // Clear error styling on input
                    this.style.borderColor = '#ddd';
                    this.title = '';
                });
            });
        });
        
        function markAllPresent() {
            document.querySelectorAll('.status-btn.present').forEach(btn => {
                btn.click();
            });
        }
        
        function markAllAbsent() {
            document.querySelectorAll('.status-btn.absent').forEach(btn => {
                btn.click();
            });
        }
        
        function saveAttendance() {
            const form = document.getElementById('attendance-form');
            
            // Validate form before submission
            if (!validateForm()) {
                showNotification('Please fix the validation errors before saving.', 'error');
                return;
            }
            
            // Create a clean form data object
            const formData = new FormData();
            
            // Add required fields
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('instructor_class_id', document.querySelector('input[name="instructor_class_id"]').value);
            formData.append('date', document.querySelector('input[name="date"]').value);
            
            // Process attendance data
            const students = form.querySelectorAll('.student-row');
            students.forEach((studentRow, index) => {
                const studentId = studentRow.querySelector('.status-btn').dataset.student;
                const statusInput = studentRow.querySelector('.status-input');
                const timeInInput = studentRow.querySelector('input[name*="[time_in]"]');
                const timeOutInput = studentRow.querySelector('input[name*="[time_out]"]');
                
                // Add student data
                formData.append(`attendance[${index}][student_id]`, studentId);
                formData.append(`attendance[${index}][status]`, statusInput.value);
                
                // Only add time values if they are valid
                if (timeInInput && timeInInput.value && isValidTimeFormat(timeInInput.value)) {
                    formData.append(`attendance[${index}][time_in]`, timeInInput.value);
                }
                
                if (timeOutInput && timeOutInput.value && isValidTimeFormat(timeOutInput.value)) {
                    formData.append(`attendance[${index}][time_out]`, timeOutInput.value);
                }
            });
            
            // Debug: Log form data
            console.log('Form action:', form.action);
            console.log('Form data entries:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            // Show loading state
            const saveBtn = event.target;
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            saveBtn.disabled = true;
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    // Try to get response text for debugging
                    return response.text().then(text => {
                        console.error('Error response:', text);
                        try {
                            const errorData = JSON.parse(text);
                            if (errorData.errors) {
                                showValidationErrors(errorData.errors);
                                return Promise.reject(new Error('Validation failed'));
                            }
                        } catch (e) {
                            // Not JSON, show generic error
                        }
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                if (data && data.success) {
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data?.message || 'Error saving attendance', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message !== 'Validation failed') {
                    showNotification('Error saving attendance. Please try again.', 'error');
                }
            })
            .finally(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
        }
        
        function isValidTimeFormat(timeString) {
            // Check if time string matches HH:MM format
            const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
            return timeRegex.test(timeString);
        }
        
        function validateForm() {
            let isValid = true;
            const errors = [];
            
            // Check if at least one student has a status selected
            const students = document.querySelectorAll('.student-row');
            let hasSelectedStatus = false;
            
            students.forEach((studentRow, index) => {
                const statusInput = studentRow.querySelector('.status-input');
                if (statusInput && statusInput.value) {
                    hasSelectedStatus = true;
                }
                
                // Validate time inputs
                const timeInInput = studentRow.querySelector('input[name*="[time_in]"]');
                const timeOutInput = studentRow.querySelector('input[name*="[time_out]"]');
                
                if (timeInInput && timeInInput.value && !isValidTimeFormat(timeInInput.value)) {
                    errors.push(`Student ${index + 1}: Invalid time in format`);
                    timeInInput.style.borderColor = '#dc3545';
                    isValid = false;
                }
                
                if (timeOutInput && timeOutInput.value && !isValidTimeFormat(timeOutInput.value)) {
                    errors.push(`Student ${index + 1}: Invalid time out format`);
                    timeOutInput.style.borderColor = '#dc3545';
                    isValid = false;
                }
            });
            
            if (!hasSelectedStatus) {
                errors.push('Please select attendance status for at least one student');
                isValid = false;
            }
            
            if (!isValid) {
                showNotification('Validation errors:\n• ' + errors.join('\n• '), 'error');
            }
            
            return isValid;
        }
        
        function showValidationErrors(errors) {
            let errorMessage = 'Please fix the following errors:\n';
            for (const field in errors) {
                if (errors[field]) {
                    errorMessage += `• ${errors[field].join(', ')}\n`;
                }
            }
            showNotification(errorMessage, 'error');
        }
        
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.classList.add('show'), 100);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
    </script>

    <script src="{{ asset('js/logout.js') }}"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Advisory Section - MCA Montessori School</title>
    <link rel="stylesheet" href="{{ asset('css/ins_class_students.css') }}?v={{ time() }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                    <li class="has-submenu">`n                        <a href="#" class="nav-item" onclick="toggleSubmenu(event)">CLASSES</a>`n                        <ul class="sub-menu" id="classes-submenu">
                            <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item active">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
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
                <h1>ADVISORY SECTION</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/instructor_user.png') }}?v={{ time() }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->short_name }}</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell.png') }}?v={{ time() }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings.png') }}?v={{ time() }}" alt="Settings" class="icon"></a>
                        <a href="javascript:void(0)" class="icon-link logout-btn" onclick="confirmExit()" title="Logout">
                            <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #1A2B49;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Students Content -->
            <div class='content-section'>
                <div class='page-header'>
                    <h2><i class='fas fa-user-friends'></i> My Advisory Section</h2>
                    @if($section)
                        <p>Manage and view students in {{ $section->section_name }} - {{ $section->gradeLevel->name ?? 'N/A' }}</p>
                    @else
                        <p>Manage and view your advisory section students</p>
                    @endif
                </div>
                
                <!-- View Toggle -->
                <div class='view-toggle'>
                    <a href='{{ route('instructor.student', ['view' => 'all']) }}' 
                       class='view-toggle-btn {{ $viewType === 'all' ? 'active' : '' }}'>
                        <i class='fas fa-users'></i> My Students (All Classes)
                    </a>
                    <a href='{{ route('instructor.student', ['view' => 'advisory']) }}' 
                       class='view-toggle-btn {{ $viewType === 'advisory' ? 'active' : '' }}'>
                        <i class='fas fa-user-friends'></i> My Advisory Section
                    </a>
                </div>

                <div class='students-container'>

                @if(isset($error))
                    <div class='no-students'>
                        <i class='fas fa-exclamation-triangle'></i>
                        <h3>{{ $error }}</h3>
                        <p>Please contact the administrator to assign you an advisory section.</p>
                    </div>
                @else
                    <!-- Filters -->
                    <form method='GET' action='{{ route('instructor.student') }}'>
                        <input type='hidden' name='view' value='advisory'>
                        <div class='filters-section'>
                            <div class='filter-group'>
                                <label for='search'><i class='fas fa-search'></i> Search:</label>
                                <input type='text' 
                                       name='search' 
                                       id='search' 
                                       placeholder='Search by name or ID...' 
                                       value='{{ $filters['search'] ?? '' }}'>
                            </div>

                            <div class='filter-actions'>
                                <button type='submit' class='btn-filter'>
                                    <i class='fas fa-filter'></i> Apply
                                </button>
                                <a href='{{ route('instructor.student', ['view' => 'advisory']) }}' class='btn-clear'>
                                    <i class='fas fa-times'></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Section Info -->
                    @if($section)
                    <div class='section-info'>
                        <strong><i class='fas fa-info-circle'></i> Section Information:</strong>
                        <span>{{ $section->section_name }} - {{ $section->gradeLevel->name ?? 'N/A' }}</span>
                        @if($section->strand)
                            <span> | Strand: {{ $section->strand->strand_name }}</span>
                        @endif
                    </div>
                    @endif

                    <!-- Students Count -->
                    <div class='students-count'>
                        <strong><i class='fas fa-users'></i> Total Students in Advisory:</strong> {{ $students->count() }}
                    </div>

                    <!-- Students Table -->
                    @if($students->count() > 0)
                    <table class='students-table'>
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Grade Level</th>
                                <th>Section</th>
                                <th>Status</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td class='student-id'>{{ $student->school_student_id ?? 'N/A' }}</td>
                                <td class='student-name'>
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </td>
                                <td>{{ $student->gradeLevel->name ?? 'N/A' }}</td>
                                <td>{{ $section->section_name ?? 'N/A' }}</td>
                                <td>{{ $student->status->status_name ?? 'Active' }}</td>
                                <td>{{ $student->contact_number ?? 'N/A' }}</td>
                                <td>
                                    <div style='display: flex; gap: 5px;'>
                                        <button onclick='openGradeInput({{ $student->student_id }}, "{{ $student->first_name }} {{ $student->last_name }}")' 
                                                class='btn-action btn-grade'
                                                title='Input Grades'>
                                            <i class='fas fa-edit'></i> Grades
                                        </button>
                                        <button onclick='viewStudentDetails({{ $student->student_id }})' 
                                                class='btn-action btn-view'
                                                title='View Details'>
                                            <i class='fas fa-eye'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class='no-students'>
                        <i class='fas fa-users-slash'></i>
                        <h3>No Students Found</h3>
                        <p>{{ isset($filters['search']) && $filters['search'] != '' ? 'Try adjusting your search criteria.' : 'No students found in your advisory section.' }}</p>
                    </div>
                    @endif
                @endif

                </div> <!-- Close students-container -->
            </div> <!-- Close content-section -->
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id='confirm-modal' class='modal' style='display:none;'>
        <div class='modal-content'>
            <p>Are you sure you want to log out?</p>
            <button class='confirm-btn' onclick='logout(event)'>Yes, Logout</button>
            <button class='cancel-btn' onclick='closeModal()'>No</button>
        </div>
    </div>

    <form id='logout-form' action='{{ route('logout') }}' method='POST' style='display: none;'>
        @csrf
    </form>

    <!-- Grade Input Modal -->
    <div id='gradeModal' class='grade-modal'>
        <div class='grade-modal-content'>
            <div class='grade-modal-header'>
                <h3><i class='fas fa-edit'></i> Input Grades for <span id='studentName'></span></h3>
                <button class='close-modal' onclick='closeGradeModal()'>&times;</button>
            </div>
            
            <div class='grade-modal-body'>
                <!-- Student Info Card -->
                <div class='student-info-card'>
                    <h4 style='margin: 0 0 10px 0; color: #1A2B49;'>Student Information</h4>
                    <div style='display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;'>
                        <p style='margin: 5px 0;'><strong>Student ID:</strong> <span id='modalStudentId'>-</span></p>
                        <p style='margin: 5px 0;'><strong>Grade Level:</strong> <span id='modalGradeLevel'>-</span></p>
                        <p style='margin: 5px 0;'><strong>Section:</strong> <span id='modalSection'>-</span></p>
                        <p style='margin: 5px 0;'><strong>Contact:</strong> <span id='modalContact'>-</span></p>
                    </div>
                </div>

                <!-- Grade Input Form -->
                <form id='gradeForm' class='grade-input-form'>
                    <div class='form-row'>
                        <div class='form-group-modal'>
 =>                            <label for='subjectSelect'>Select Subject:</label>
                            <select id='subjectSelect' required>
                                <option value=''>Choose Subject</option>
                                <!-- Subjects will be populated by JavaScript -->
                            </select>
                        </div>
                        <div class='form-group-modal'>
                            <label for='schoolYear'>School Year:</label>
                            <input type='text' id='schoolYear' value='{{ now()->year }}-{{ now()->addYear()->year }}' readonly>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group-modal'>
                            <label for='quarter1'>1st Quarter:</label>
                            <input type='number' id='quarter1' min='0' max='100' step='0.01'>
                        </div>
                        <div class='form-group-modal'>
                            <label for='quarter2'>2nd Quarter:</label>
                            <input type='number' id='quarter2' min='0' max='100' step='0.01'>
                        </div>
                        <div class='form-group-modal'>
                            <label for='quarter3'>3rd Quarter:</label>
                            <input type='number' id='quarter3' min='0' max='100' step='0.01'>
                        </div>
                        <div class='form-group-modal'>
                            <label for='quarter4'>4th Quarter:</label>
                            <input type='number' id='quarter4' min='0' max='100' step='0.01'>
                        </div>
                    </div>
                </form>

                <!-- Grade History -->
                <div class='grade-history'>
                    <h4>Grade History</h4>
                    <div id='gradeHistoryContent'>
                        <!-- Grade history will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <div class='modal-footer'>
                <button class='btn-modal btn-cancel-modal' onclick='closeGradeModal()'>Cancel</button>
                <button class='btn-modal btn-save-grade' onclick='confirmSaveGrade()'>Save Grades</button>
            </div>
        </div>
    </div>

    <script>
        let currentStudentData = null;

        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Load subjects when opening grade modal
        async function loadStudentSubjects(studentId) {
            try {
                const response = await fetch(`/api/instructor/student/${studentId}/subjects`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const subjects = await response.json();
                    const subjectSelect = document.getElementById('subjectSelect');
                    
                    // Clear existing options
                    subjectSelect.innerHTML = '<option value="">Choose Subject</option>';
                    
                    // Sort subjects: default subjects first, then alphabetically
                    subjects.sort((a, b) => {
                        if (a.is_default && !b.is_default) return -1;
                        if (!a.is_default && b.is_default) return 1;
                        return a.name.localeCompare(b.name);
                    });
                    
                    // Add subjects with visual indicators for default subjects
                    subjects.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.is_default ? `⭐ ${subject.name}` : subject.name;
                        option.style.fontWeight = subject.is_default ? 'bold' : 'normal';
                        option.style.color = subject.is_default ? '#7a222b' : 'inherit';
                        subjectSelect.appendChild(option);
                    });
                } else {
                    console.error('Error loading subjects:', response.statusText);
                }
            } catch (error) {
                console.error('Error loading subjects:', error);
            }
        }

        // Open grade input modal
        function openGradeInput(studentId, studentName) {
            currentStudentData = {
                id: studentId,
                name: studentName
            };

            // Update modal
            document.getElementById('studentName').textContent = studentName;
            
            // Load student data
            loadStudentDetails(studentId);
            loadStudentSubjects(studentId);
            loadExistingGrades(studentId);

            // Show modal
            document.getElementById('gradeModal').style.display = 'block';
        }

        // Load student details
        async function loadStudentDetails(studentId) {
            try {
                const response = await fetch(`/instructor/student/${studentId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    const student = data.student;

                    document.getElementById('modalStudentId').textContent = student.school_student_id || 'N/A';
                    document.getElementById('modalGradeLevel').textContent = 'Grade ' + (student.grade_level?.name || 'N/A');
                    document.getElementById('modalSection').textContent = student.section?.section_name || 'N/A';
                    document.getElementById('modalContact').textContent = student.contact_number || 'N/A';
                } else {
                    console.error('Error loading student details:', response.statusText);
                }
            } catch (error) {
                console.error('Error loading student details:', error);
            }
        }

        // Load existing grades
        async function loadExistingGrades(studentId) {
            try {
                const response = await fetch(`/api/instructor/student/${studentId}/grades`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    const grades = await response.json();
                    displayGradeHistory(grades);
                } else {
                    console.error('Error loading grades:', response.statusText);
                    document.getElementById('gradeHistoryContent').innerHTML = '<p style="color: #dc3545; text-align: center;">Error loading grade history</p>';
                }
            } catch (error) {
                console.error('Error loading existing grades:', error);
            }
        }

        function displayGradeHistory(grades) {
            const container = document.getElementById('gradeHistoryContent');
            
            if (!grades || grades.length === 0) {
                container.innerHTML = '<p style="color: #6c757d; text-align: center;">No grades recorded yet.</p>';
                return;
            }

            let html = '<table class="history-table"><thead><tr>';
            html += '<th>Subject</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>Final</th>';
            html += '</tr></thead><tbody>';

            grades.forEach(grade => {
                html += '<tr>';
                html += `<td>${grade.subject?.name || 'N/A'}</td>`;
                html += `<td>${grade.first_quarter || '-'}</td>`;
                html += `<td>${grade.second_quarter || '-'}</td>`;
                html += `<td>${grade.third_quarter || '-'}</td>`;
                html += `<td>${grade.fourth_quarter || '-'}</td>`;
                html += `<td><strong>${grade.final_grade ? grade.final_grade.toFixed(2) : '-'}</strong></td>`;
                html += '</tr>';
            });

            html += '</tbody></table>';
            container.innerHTML = html;
        }

        function closeGradeModal() {
            document.getElementById('gradeModal').style.display = 'none';
            document.getElementById('gradeForm').reset();
            currentStudentData = null;
        }

        function confirmSaveGrade() {
            const subjectSelect = document.getElementById('subjectSelect');
            if (!subjectSelect.value) {
                alert('Please select a subject first.');
                return;
            }

            const quarters = {
                '1st': document.getElementById('quarter1').value,
                '2nd': document.getElementById('quarter2').value,
                '3rd': document.getElementById('quarter3').value,
                '4th': document.getElementById('quarter4').value
            };

            const filledQuarters = Object.entries(quarters).filter(([_, value]) => value.trim() !== '');
            
            if (filledQuarters.length === 0) {
                alert('Please enter at least one quarter grade.');
                return;
            }

            const confirmMessage = `Save grades for ${currentStudentData.name}?\n\n`;
            if (confirm(confirmMessage)) {
                saveGrade();
            }
        }

        async function saveGrade() {
            try {
                const formData = {
                    student_id: currentStudentData.id,
                    subject_id: document.getElementById('subjectSelect').value,
                    class_id: 1, // This should be dynamic based on selected subject
                    school_year: document.getElementById('schoolYear').value,
                    first_quarter: document.getElementById('quarter1').value || null,
                    second_quarter: document.getElementById('quarter2').value || null,
                    third_quarter: document.getElementById('quarter3').value || null,
                    fourth_quarter: document.getElementById('quarter4').value || null,
                };

                const response = await fetch('/api/instructor/grades', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });

                if (response.ok) {
                    alert('Grades saved successfully!');
                    closeGradeModal();
                    loadExistingGrades(currentStudentData.id); // Refresh grade history
                } else {
                    const errorData = await response.json();
                    alert(`Error saving grades: ${errorData.message || 'Unknown error'}`);
                }
            } catch (error) {
                console.error('Error saving grade:', error);
                alert('Error saving grades. Please try again.');
            }
        }

        // View student details function
        function viewStudentDetails(studentId) {
            // This would typically open a modal or redirect to a detailed view
            alert(`Viewing details for student ID: ${studentId}`);
        }

        // Modal functions
        function confirmExit() {
            document.getElementById('confirm-modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('confirm-modal').style.display = 'none';
        }

        function logout(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }
    </script>
    
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
</body>
</html>


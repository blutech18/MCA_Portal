<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grade Input - MCA Montessori School</title>
    <link rel="stylesheet" href="{{ asset('css/ins_grade_input.css') }}">
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
                    <li>
                        <a href="{{ route('instructor.schedule') }}" class="nav-item">CLASSES</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item active">GRADE REPORTS</a></li>
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
                <h1>GRADE INPUT</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/instructor_user.png') }}?v={{ time() }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->short_name ?? 'INSTRUCTOR' }}</p>
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

            <!-- Grade Input Content -->
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-edit"></i> Grade Input</h2>
                    <p>Input and manage student grades for your classes</p>
                    <p style="color: #28a745; font-size: 14px; margin-top: 8px;">
                        <i class="fas fa-info-circle"></i> <strong>Tip:</strong> You can save grades for individual quarters. All quarter fields are optional - enter only the grades you have available.
                    </p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <a href="{{ route('instructor.report') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                </div>

                @if(isset($iclass) && $iclass)
                <div class="class-info">
                    <p><strong>Class:</strong> {{ $iclass->class->name ?? 'N/A' }}</p>
                    <p><strong>Subject:</strong> {{ $iclass->class->subject->name ?? 'N/A' }}</p>
                    <p><strong>Section:</strong> {{ $iclass->class->section->section_name ?? 'N/A' }}</p>
                </div>

                <form id="gradeInputForm">
                    @csrf
                    <table class="grade-table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>1st Quarter <span style="font-weight: normal; font-size: 11px; color: #6c757d;">(Optional)</span></th>
                                <th>2nd Quarter <span style="font-weight: normal; font-size: 11px; color: #6c757d;">(Optional)</span></th>
                                <th>3rd Quarter <span style="font-weight: normal; font-size: 11px; color: #6c757d;">(Optional)</span></th>
                                <th>4th Quarter <span style="font-weight: normal; font-size: 11px; color: #6c757d;">(Optional)</span></th>
                                <th>Final Grade <span style="font-weight: normal; font-size: 11px; color: #6c757d;">(Average)</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                            @php
                                $student = $row['student'];
                                $grade = $row['grade'];
                                $subject = $row['subject'];
                                $class = $row['class'];
                            @endphp
                            <tr data-student-id="{{ $student->student_id }}"
                                data-student-name="{{ $student->first_name }} {{ $student->last_name }}"
                                data-class-id="{{ $class->id }}"
                                data-subject-id="{{ $subject->id }}"
                                data-subject-name="{{ $subject->name }}">
                                <td>
                                    <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                                    <input type="hidden" name="grades[{{ $loop->index }}][grade_id]" value="{{ $grade->id ?? '' }}">
                                    <input type="hidden" name="grades[{{ $loop->index }}][student_id]" value="{{ $student->student_id }}">
                                    <input type="hidden" name="grades[{{ $loop->index }}][class_id]" value="{{ $class->id }}">
                                    <input type="hidden" name="grades[{{ $loop->index }}][subject_id]" value="{{ $subject->id }}">
                                </td>
                                <td>
                                    <input type="number" 
                                           class="grade-input" 
                                           name="grades[{{ $loop->index }}][first_quarter]" 
                                           value="{{ $grade->first_quarter ?? '' }}"
                                           min="0" 
                                           max="100" 
                                           step="0.01"
                                           placeholder="Optional"
                                           data-quarter="1st">
                                    <div class="validation-error">Grade must be 0-100</div>
                                </td>
                                <td>
                                    <input type="number" 
                                           class="grade-input" 
                                           name="grades[{{ $loop->index }}][second_quarter]" 
                                           value="{{ $grade->second_quarter ?? '' }}"
                                           min="0" 
                                           max="100" 
                                           step="0.01"
                                           placeholder="Optional"
                                           data-quarter="2nd">
                                    <div class="validation-error">Grade must be 0-100</div>
                                </td>
                                <td>
                                    <input type="number" 
                                           class="grade-input" 
                                           name="grades[{{ $loop->index }}][third_quarter]" 
                                           value="{{ $grade->third_quarter ?? '' }}"
                                           min="0" 
                                           max="100" 
                                           step="0.01"
                                           placeholder="Optional"
                                           data-quarter="3rd">
                                    <div class="validation-error">Grade must be 0-100</div>
                                </td>
                                <td>
                                    <input type="number" 
                                           class="grade-input" 
                                           name="grades[{{ $loop->index }}][fourth_quarter]" 
                                           value="{{ $grade->fourth_quarter ?? '' }}"
                                           min="0" 
                                           max="100" 
                                           step="0.01"
                                           placeholder="Optional"
                                           data-quarter="4th">
                                    <div class="validation-error">Grade must be 0-100</div>
                                </td>
                                <td class="final-grade">
                                    <span class="calculated-final">{{ $grade->final_grade ? number_format($grade->final_grade, 2) : 'N/A' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="text-align: center; margin-top: 30px;">
                        <button type="button" class="save-grades-btn" onclick="showConfirmation()">
                            <i class="fas fa-save"></i> Save All Grades
                        </button>
                    </div>
                </form>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> No class assigned or selected. Please go back and select a class.
                </div>
                @endif
            </div> <!-- Close content-section -->
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirmation-modal">
        <div class="confirmation-modal-content">
            <div class="modal-header">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Confirm Grade Submission</h3>
            </div>
            <div class="modal-body">
                <p><strong>Are you sure you want to save these grades?</strong></p>
                <p>Please review the grades being saved:</p>
                <div id="gradeSummary" class="grade-summary">
                    <!-- Grade summary will be populated by JavaScript -->
                </div>
                <p style="color: #dc3545; font-weight: 600;">
                    <i class="fas fa-info-circle"></i> This action will update the grades in the system and students will be able to see them immediately.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="closeConfirmation()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="modal-btn modal-btn-confirm" onclick="confirmSaveGrades()">
                    <i class="fas fa-check"></i> Confirm & Save
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="success-message">
        <i class="fas fa-check-circle"></i> <span id="successText">Grades saved successfully!</span>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal" style="display:none;">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
            <button class="cancel-btn" onclick="closeModal()">No</button>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            if (mobileBtn) {
                mobileBtn.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('active');
                });
            }
        });
        // Real-time grade validation
        document.querySelectorAll('.grade-input').forEach(input => {
            input.addEventListener('input', function() {
                validateGradeInput(this);
                calculateFinalGrade(this.closest('tr'));
            });

            input.addEventListener('blur', function() {
                validateGradeInput(this);
            });
        });

        function validateGradeInput(input) {
            const value = parseFloat(input.value);
            const errorDiv = input.nextElementSibling;
            
            // Allow empty values (optional fields)
            if (input.value === '') {
                input.classList.remove('invalid');
                errorDiv.style.display = 'none';
                return true;
            }
            
            // Validate range 0-100
            if (isNaN(value) || value < 0 || value > 100) {
                input.classList.add('invalid');
                errorDiv.style.display = 'block';
                return false;
            }
            
            input.classList.remove('invalid');
            errorDiv.style.display = 'none';
            return true;
        }

        function calculateFinalGrade(row) {
            const inputs = row.querySelectorAll('.grade-input');
            const grades = [];
            
            inputs.forEach(input => {
                const value = parseFloat(input.value);
                if (!isNaN(value) && value >= 0 && value <= 100) {
                    grades.push(value);
                }
            });
            
            const finalGradeSpan = row.querySelector('.calculated-final');
            if (grades.length > 0) {
                const average = grades.reduce((a, b) => a + b, 0) / grades.length;
                finalGradeSpan.textContent = average.toFixed(2);
                finalGradeSpan.style.color = average >= 75 ? '#28a745' : '#dc3545';
            } else {
                finalGradeSpan.textContent = 'N/A';
                finalGradeSpan.style.color = '#6c757d';
            }
        }

        function showConfirmation() {
            // Validate all inputs first
            let hasError = false;
            document.querySelectorAll('.grade-input').forEach(input => {
                if (!validateGradeInput(input)) {
                    hasError = true;
                }
            });

            if (hasError) {
                alert('Please fix the invalid grades before saving.');
                return;
            }

            // Collect grades being saved
            const rows = document.querySelectorAll('.grade-table tbody tr');
            let summaryHTML = '';
            let changesCount = 0;

            rows.forEach(row => {
                const studentName = row.dataset.studentName;
                const subjectName = row.dataset.subjectName;
                const inputs = row.querySelectorAll('.grade-input');
                const grades = [];
                
                inputs.forEach(input => {
                    if (input.value !== '') {
                        const quarter = input.dataset.quarter;
                        grades.push(`${quarter}: ${input.value}`);
                    }
                });

                if (grades.length > 0) {
                    changesCount++;
                    summaryHTML += `
                        <div class="grade-summary-item">
                            <div>
                                <div class="grade-summary-label">${studentName}</div>
                                <div class="grade-summary-value">${subjectName}</div>
                            </div>
                            <div style="text-align: right;">
                                <div>${grades.join(', ')}</div>
                                <div style="font-weight: bold; color: #5c0017;">
                                    Final: ${row.querySelector('.calculated-final').textContent}
                                </div>
                            </div>
                        </div>
                    `;
                }
            });

            if (changesCount === 0) {
                alert('No grades to save. Please enter at least one grade.');
                return;
            }

            document.getElementById('gradeSummary').innerHTML = summaryHTML;
            document.getElementById('confirmationModal').style.display = 'block';
        }

        function closeConfirmation() {
            document.getElementById('confirmationModal').style.display = 'none';
        }

        async function confirmSaveGrades() {
            const form = document.getElementById('gradeInputForm');
            const formData = new FormData(form);
            const saveBtn = document.querySelector('.modal-btn-confirm');
            
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            try {
                // Save each student's grades individually
                const rows = document.querySelectorAll('.grade-table tbody tr');
                let savedCount = 0;
                let errors = [];

                for (let row of rows) {
                    const gradeData = {
                        student_id: row.dataset.studentId,
                        class_id: row.dataset.classId,
                        subject_id: row.dataset.subjectId,
                        first_quarter: row.querySelector('[data-quarter="1st"]').value || null,
                        second_quarter: row.querySelector('[data-quarter="2nd"]').value || null,
                        third_quarter: row.querySelector('[data-quarter="3rd"]').value || null,
                        fourth_quarter: row.querySelector('[data-quarter="4th"]').value || null,
                    };

                    // Only save if at least one grade is entered
                    if (Object.values(gradeData).some(v => v !== null && v !== '')) {
                        try {
                            const response = await fetch('{{ route('instructor.grade.save') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(gradeData)
                            });

                            const result = await response.json();
                            if (result.success) {
                                savedCount++;
                            } else {
                                errors.push(`${row.dataset.studentName}: ${result.message || 'Unknown error'}`);
                            }
                        } catch (error) {
                            errors.push(`${row.dataset.studentName}: ${error.message}`);
                        }
                    }
                }

                closeConfirmation();
                
                if (errors.length === 0) {
                    showSuccessMessage(`Successfully saved grades for ${savedCount} student(s)!`);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    alert(`Saved ${savedCount} grades, but encountered errors:\n${errors.join('\n')}`);
                    window.location.reload();
                }

            } catch (error) {
                console.error('Error saving grades:', error);
                alert('An error occurred while saving grades. Please try again.');
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-check"></i> Confirm & Save';
            }
        }

        function showSuccessMessage(message) {
            const successDiv = document.getElementById('successMessage');
            document.getElementById('successText').textContent = message;
            successDiv.style.display = 'block';
            
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 3000);
        }

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
    
    <script src="{{ asset('js/logout.js') }}"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Students - MCA Montessori School</title>
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
                    <li>
                        <a href="{{ route('instructor.schedule') }}" class="nav-item">CLASSES</a>
                        <ul class="sub-menu">
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
                <h1>STUDENT MANAGEMENT</h1>
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
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-users"></i> Student Management</h2>
                    <p>Manage and view your students across all classes</p>
                </div>

            <!-- View Toggle -->
            <div class="view-toggle">
                <a href="{{ route('instructor.student', ['view' => 'all']) }}" 
                   class="view-toggle-btn {{ $viewType === 'all' ? 'active' : '' }}">
                    <i class="fas fa-users"></i> My Students (All Classes)
                </a>
                <a href="{{ route('instructor.student', ['view' => 'advisory']) }}" 
                   class="view-toggle-btn {{ $viewType === 'advisory' ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i> My Advisory Section
                </a>
            </div>

            <div class="students-container">

                <!-- Filters -->
                <form method="GET" action="{{ route('instructor.student') }}">
                    <input type="hidden" name="view" value="all">
                    <div class="filters-section">
                        <div class="filter-group">
                            <label for="section"><i class="fas fa-door-open"></i> Section:</label>
                            <select name="section" id="section">
                                <option value="">All Sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" 
                                            {{ ($filters['section'] ?? '') == $section->id ? 'selected' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="grade_level"><i class="fas fa-graduation-cap"></i> Grade Level:</label>
                            <select name="grade_level" id="grade_level">
                                <option value="">All Grade Levels</option>
                                @foreach($gradeLevels as $gradeLevel)
                                    <option value="{{ $gradeLevel->grade_level_id }}" 
                                            {{ ($filters['grade_level'] ?? '') == $gradeLevel->grade_level_id ? 'selected' : '' }}>
                                        {{ $gradeLevel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="search"><i class="fas fa-search"></i> Search:</label>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   placeholder="Search by name or ID..." 
                                   value="{{ $filters['search'] ?? '' }}">
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-filter"></i> Apply
                            </button>
                            <a href="{{ route('instructor.student', ['view' => 'all']) }}" class="btn-clear">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Students Count and Batch Actions -->
                <div class="students-count" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                    <strong><i class="fas fa-info-circle"></i> Total Students:</strong> {{ $students->count() }}
                        <span id="selectedCount" style="margin-left: 20px; color: #FF6B35; display: none;">
                            <strong><i class="fas fa-check-circle"></i> Selected:</strong> <span id="selectedNumber">0</span>
                        </span>
                    </div>
                    <div>
                        <button type="button" class="btn-filter" onclick="toggleSelectAll()" style="margin-right: 10px;">
                            <i class="fas fa-check-double"></i> <span id="selectAllText">Select All</span>
                        </button>
                        <button type="button" class="btn-filter" onclick="openBatchGradeInput()" id="batchGradeBtn" style="display: none; background: #FF6B35;">
                            <i class="fas fa-users-cog"></i> Batch Grade Input
                        </button>
                    </div>
                </div>

                <!-- Students Table -->
                @if($students->count() > 0)
                <table class="students-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()"></th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Grade Level</th>
                            <th>Section</th>
                            <th>Subjects Taught</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                       class="student-checkbox" 
                                       value="{{ $student->student_id }}" 
                                       data-name="{{ $student->first_name }} {{ $student->last_name }}"
                                       data-section="{{ $student->section_id }}"
                                       onchange="updateSelectedCount()">
                            </td>
                            <td class="student-id">{{ $student->school_student_id ?? 'N/A' }}</td>
                            <td class="student-name">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </td>
                            <td>{{ $student->gradeLevel->name ?? 'N/A' }}</td>
                            <td>{{ $student->section->section_name ?? 'N/A' }}</td>
                            <td>
                                @if(isset($student->subjects_taught) && $student->subjects_taught->count() > 0)
                                    @foreach($student->subjects_taught as $subject)
                                        <span class="subject-badge">{{ $subject }}</span>
                                    @endforeach
                                @else
                                    <span class="subject-badge" style="background: #f8d7da; color: #721c24;">No subjects</span>
                                @endif
                            </td>
                            <td>{{ $student->contact_number ?? 'N/A' }}</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <button onclick="openGradeInput({{ $student->student_id }}, '{{ $student->first_name }} {{ $student->last_name }}')" 
                                            class="btn-action btn-grade"
                                            title="Input Grades">
                                        <i class="fas fa-edit"></i> Grades
                                    </button>
                                    <button onclick="viewStudentDetails({{ $student->student_id }})" 
                                            class="btn-action btn-view"
                                            title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="no-students">
                    <i class="fas fa-users-slash"></i>
                    <h3>No Students Found</h3>
                    <p>{{ isset($filters['search']) && $filters['search'] != '' ? 'Try adjusting your search or filters.' : 'You are not currently assigned to teach any students.' }}</p>
                </div>
                @endif
                </div> <!-- Close students-container -->
            </div> <!-- Close content-section -->
        </div>
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

    <!-- Grade Input Modal -->
    <div id="gradeModal" class="grade-modal">
        <div class="grade-modal-content">
            <div class="grade-modal-header">
                <h3><i class="fas fa-edit"></i> Input Grades for <span id="studentName"></span></h3>
                <button class="close-modal" onclick="closeGradeModal()">&times;</button>
            </div>
            
            <div class="grade-modal-body">
                <!-- Student Info Card -->
                <div class="student-info-card">
                    <h4 style="margin: 0 0 10px 0; color: #5c0017;">Student Information</h4>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                        <p style="margin: 5px 0;"><strong>Student ID:</strong> <span id="modalStudentId">-</span></p>
                        <p style="margin: 5px 0;"><strong>Grade Level:</strong> <span id="modalGradeLevel">-</span></p>
                        <p style="margin: 5px 0;"><strong>Section:</strong> <span id="modalSection">-</span></p>
                        <p style="margin: 5px 0;"><strong>Contact:</strong> <span id="modalContact">-</span></p>
                    </div>
                </div>

                <!-- Grade Input Form -->
                <div class="grade-input-form">
                    <h4 style="color: #5c0017; margin-bottom: 15px;">Enter New Grade</h4>
                    
                    <form id="gradeForm">
                        <input type="hidden" id="formStudentId" name="student_id">
                        <input type="hidden" id="formClassId" name="class_id">
                        <input type="hidden" id="formSubjectId" name="subject_id">
                        <input type="hidden" id="formGradeId" name="grade_id">

                        <div class="form-group-modal" style="margin-bottom: 15px;">
                            <label for="subjectSelect">Subject: <span style="color: red;">*</span></label>
                            <select id="subjectSelect" name="subject_select" required style="padding: 10px; border: 2px solid #ced4da; border-radius: 6px;">
                                <option value="">-- Select Subject --</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group-modal">
                                <label for="quarter1">1st Quarter (70-100):</label>
                                <input type="number" id="quarter1" name="first_quarter" min="70" max="100" step="0.01" placeholder="70.00">
                            </div>
                            <div class="form-group-modal">
                                <label for="quarter2">2nd Quarter (70-100):</label>
                                <input type="number" id="quarter2" name="second_quarter" min="70" max="100" step="0.01" placeholder="70.00">
                            </div>
                            <div class="form-group-modal">
                                <label for="quarter3">3rd Quarter (70-100):</label>
                                <input type="number" id="quarter3" name="third_quarter" min="70" max="100" step="0.01" placeholder="70.00">
                            </div>
                            <div class="form-group-modal">
                                <label for="quarter4">4th Quarter (70-100):</label>
                                <input type="number" id="quarter4" name="fourth_quarter" min="70" max="100" step="0.01" placeholder="70.00">
                            </div>
                        </div>

                        <div style="background: #e7f3ff; padding: 15px; border-radius: 6px; margin-top: 15px;">
                            <p style="margin: 0; font-weight: 600;">
                                <i class="fas fa-calculator"></i> Final Grade: 
                                <span id="calculatedFinal" style="color: #5c0017; font-size: 18px;">0.00</span>
                            </p>
                            <small style="color: #6c757d;">Automatically calculated as average of all quarters entered</small>
                        </div>
                    </form>
                </div>

                <!-- Grade History -->
                <div class="grade-history">
                    <h4><i class="fas fa-history"></i> Grade History</h4>
                    <div id="gradeHistoryContent">
                        <p style="color: #6c757d; text-align: center;">Loading grade history...</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel-modal" onclick="closeGradeModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn-modal btn-save-grade" onclick="confirmSaveGrade()">
                    <i class="fas fa-save"></i> Save Grade
                </button>
            </div>
        </div>
    </div>

    <!-- Grade Confirmation Modal -->
    <div id="gradeConfirmModal" class="grade-modal">
        <div class="grade-modal-content" style="max-width: 500px;">
            <div class="grade-modal-header">
                <h3>⚠️ Confirm Grade Submission</h3>
                <button class="close-modal" onclick="closeConfirmModal()">&times;</button>
            </div>
            <div class="grade-modal-body">
                <p>Are you sure you want to save these grades?</p>
                <div id="confirmSummary" style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin: 15px 0;">
                    <!-- Summary will be populated by JS -->
                </div>
                <p style="color: #dc3545; font-weight: 600;">⚠️ Students will see these grades immediately after saving!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel-modal" onclick="closeConfirmModal()">Cancel</button>
                <button type="button" class="btn-modal btn-save-grade" onclick="submitGrade()">Confirm & Save</button>
            </div>
        </div>
    </div>

    <!-- Batch Grade Input Modal -->
    <div id="batchGradeModal" class="grade-modal">
        <div class="grade-modal-content" style="max-width: 800px;">
            <div class="grade-modal-header">
                <h3><i class="fas fa-users-cog"></i> Batch Grade Input</h3>
                <button class="close-modal" onclick="closeBatchGradeModal()">&times;</button>
            </div>
            
            <div class="grade-modal-body">
                <div class="student-info-card" style="background: #e7f3ff;">
                    <h4 style="margin: 0 0 10px 0; color: #1A2B49;">Selected Students</h4>
                    <div id="batchStudentsList" style="max-height: 100px; overflow-y: auto; padding: 10px; background: white; border-radius: 4px;">
                        <!-- Will be populated by JS -->
                    </div>
                </div>

                <form id="batchGradeForm">
                    <div class="form-group-modal" style="margin: 20px 0;">
                        <label for="batchSubjectSelect">Select Subject: <span style="color: red;">*</span></label>
                        <select id="batchSubjectSelect" required style="padding: 10px; border: 2px solid #ced4da; border-radius: 6px;">
                            <option value="">-- Select Subject --</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group-modal">
                            <label for="batchQuarter1">1st Quarter (0-100):</label>
                            <input type="number" id="batchQuarter1" min="0" max="100" step="0.01" placeholder="0.00">
                        </div>
                        <div class="form-group-modal">
                            <label for="batchQuarter2">2nd Quarter (0-100):</label>
                            <input type="number" id="batchQuarter2" min="0" max="100" step="0.01" placeholder="0.00">
                        </div>
                        <div class="form-group-modal">
                            <label for="batchQuarter3">3rd Quarter (0-100):</label>
                            <input type="number" id="batchQuarter3" min="0" max="100" step="0.01" placeholder="0.00">
                        </div>
                        <div class="form-group-modal">
                            <label for="batchQuarter4">4th Quarter (0-100):</label>
                            <input type="number" id="batchQuarter4" min="0" max="100" step="0.01" placeholder="0.00">
                        </div>
                    </div>

                    <div style="background: #e7f3ff; padding: 15px; border-radius: 6px; margin-top: 15px;">
                        <p style="margin: 0; font-weight: 600;">
                            <i class="fas fa-calculator"></i> Final Grade (for all selected students): 
                            <span id="batchCalculatedFinal" style="color: #1A2B49; font-size: 18px;">0.00</span>
                        </p>
                        <small style="color: #6c757d;">This grade will be applied to all selected students</small>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel-modal" onclick="closeBatchGradeModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn-modal btn-save-grade" onclick="confirmBatchGrade()">
                    <i class="fas fa-save"></i> Save Batch Grades
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentStudentData = null;
        let instructorClasses = @json($instructor->instructorClasses ?? []);
        let selectedStudents = [];

        // Auto-calculate final grade
        document.addEventListener('DOMContentLoaded', function() {
            const quarterInputs = ['quarter1', 'quarter2', 'quarter3', 'quarter4'];
            quarterInputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', calculateFinalGrade);
                }
            });

            // Batch grade inputs
            const batchQuarterInputs = ['batchQuarter1', 'batchQuarter2', 'batchQuarter3', 'batchQuarter4'];
            batchQuarterInputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', calculateBatchFinalGrade);
                }
            });
        });

        // Batch grading functions
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            const count = checkboxes.length;
            
            document.getElementById('selectedNumber').textContent = count;
            document.getElementById('selectedCount').style.display = count > 0 ? 'inline' : 'none';
            document.getElementById('batchGradeBtn').style.display = count > 0 ? 'inline-block' : 'none';
            document.getElementById('selectAllText').textContent = count === document.querySelectorAll('.student-checkbox').length ? 'Deselect All' : 'Select All';
            
            // Update selectedStudents array
            selectedStudents = Array.from(checkboxes).map(cb => ({
                id: cb.value,
                name: cb.getAttribute('data-name'),
                section_id: cb.getAttribute('data-section')
            }));
        }

        function openBatchGradeInput() {
            if (selectedStudents.length === 0) {
                alert('Please select at least one student.');
                return;
            }

            // Populate selected students list
            const studentsList = document.getElementById('batchStudentsList');
            studentsList.innerHTML = selectedStudents.map(s => 
                `<div style="padding: 5px; border-bottom: 1px solid #eee;">• ${s.name}</div>`
            ).join('');

            // Populate subject dropdown - filter by common section if possible
            const sectionId = selectedStudents[0].section_id;
            const allSameSection = selectedStudents.every(s => s.section_id === sectionId);
            
            const batchSubjectSelect = document.getElementById('batchSubjectSelect');
            batchSubjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';

            let relevantClasses = instructorClasses;
            if (allSameSection) {
                relevantClasses = instructorClasses.filter(ic => ic.class.section_id == sectionId);
            }

            relevantClasses.forEach(ic => {
                const option = document.createElement('option');
                option.value = JSON.stringify({
                    class_id: ic.class_id,
                    subject_id: ic.class.subject.id,
                    subject_name: ic.class.subject.name
                });
                option.textContent = ic.class.subject.name;
                batchSubjectSelect.appendChild(option);
            });

            document.getElementById('batchGradeModal').style.display = 'block';
        }

        function closeBatchGradeModal() {
            document.getElementById('batchGradeModal').style.display = 'none';
            document.getElementById('batchGradeForm').reset();
            document.getElementById('batchCalculatedFinal').textContent = '0.00';
        }

        function calculateBatchFinalGrade() {
            const quarters = [];
            ['batchQuarter1', 'batchQuarter2', 'batchQuarter3', 'batchQuarter4'].forEach(id => {
                const val = document.getElementById(id).value;
                if (val && val !== '') {
                    quarters.push(parseFloat(val));
                }
            });

            const final = quarters.length > 0 ? quarters.reduce((a, b) => a + b, 0) / quarters.length : 0;
            document.getElementById('batchCalculatedFinal').textContent = final.toFixed(2);
        }

        async function confirmBatchGrade() {
            const subjectSelect = document.getElementById('batchSubjectSelect');
            if (!subjectSelect.value) {
                alert('Please select a subject first.');
                return;
            }

            const quarters = {
                '1st': document.getElementById('batchQuarter1').value,
                '2nd': document.getElementById('batchQuarter2').value,
                '3rd': document.getElementById('batchQuarter3').value,
                '4th': document.getElementById('batchQuarter4').value
            };

            const hasGrade = Object.values(quarters).some(v => v !== '');
            if (!hasGrade) {
                alert('Please enter at least one quarter grade.');
                return;
            }

            const subjectData = JSON.parse(subjectSelect.value);
            const finalGrade = document.getElementById('batchCalculatedFinal').textContent;

            const confirmMsg = `Save these grades for ${selectedStudents.length} students?\n\n` +
                              `Subject: ${subjectData.subject_name}\n` +
                              `Final Grade: ${finalGrade}\n\n` +
                              `Students will see these grades immediately!`;

            if (confirm(confirmMsg)) {
                await submitBatchGrades(subjectData);
            }
        }

        async function submitBatchGrades(subjectData) {
            const gradeData = {
                class_id: subjectData.class_id,
                subject_id: subjectData.subject_id,
                first_quarter: document.getElementById('batchQuarter1').value || null,
                second_quarter: document.getElementById('batchQuarter2').value || null,
                third_quarter: document.getElementById('batchQuarter3').value || null,
                fourth_quarter: document.getElementById('batchQuarter4').value || null
            };

            let successCount = 0;
            let errorCount = 0;

            for (const student of selectedStudents) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                    const response = await fetch('{{ route('instructor.grade.save') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...gradeData,
                            student_id: student.id
                        })
                    });

                    const result = await response.json();
                    if (result.success) {
                        successCount++;
                    } else {
                        errorCount++;
                    }
                } catch (error) {
                    console.error(`Error saving grade for student ${student.id}:`, error);
                    errorCount++;
                }
            }

            if (successCount > 0) {
                alert(`✅ Successfully saved grades for ${successCount} student(s)!` + 
                      (errorCount > 0 ? `\n⚠️ ${errorCount} failed.` : ''));
                closeBatchGradeModal();
                
                // Deselect all checkboxes
                document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = false);
                document.getElementById('selectAllCheckbox').checked = false;
                updateSelectedCount();
                
                location.reload(); // Refresh to show updated data
            } else {
                alert('❌ Failed to save batch grades. Please try again.');
            }
        }

        function calculateFinalGrade() {
            const quarters = [];
            ['quarter1', 'quarter2', 'quarter3', 'quarter4'].forEach(id => {
                const val = document.getElementById(id).value;
                if (val && val !== '') {
                    quarters.push(parseFloat(val));
                }
            });

            const final = quarters.length > 0 ? quarters.reduce((a, b) => a + b, 0) / quarters.length : 0;
            document.getElementById('calculatedFinal').textContent = final.toFixed(2);
        }

        async function openGradeInput(studentId, studentName) {
            document.getElementById('studentName').textContent = studentName;
            
            // Fetch student details
            try {
                const response = await fetch(`/instructor/student/${studentId}`);
                const data = await response.json();
                currentStudentData = data.student;

                // Populate student info
                document.getElementById('modalStudentId').textContent = data.student.school_student_id || 'N/A';
                document.getElementById('modalGradeLevel').textContent = 'Grade ' + (data.student.grade_level?.name || 'N/A');
                document.getElementById('modalSection').textContent = data.student.section?.section_name || 'N/A';
                document.getElementById('modalContact').textContent = data.student.contact_number || 'N/A';
                document.getElementById('formStudentId').value = studentId;

                // Populate subject dropdown
                populateSubjects(data.student.section_id);

                // Display grade history
                displayGradeHistory(data.grades);

                // Show modal
                document.getElementById('gradeModal').style.display = 'block';
            } catch (error) {
                console.error('Error loading student data:', error);
                alert('Failed to load student information. Please try again.');
            }
        }

        function populateSubjects(sectionId) {
            const subjectSelect = document.getElementById('subjectSelect');
            subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';

            // Filter classes by section
            const relevantClasses = instructorClasses.filter(ic => ic.class.section_id === sectionId);
            
            // Sort classes by default subjects first, then alphabetically
            relevantClasses.sort((a, b) => {
                const aIsDefault = a.class.subject.is_default || false;
                const bIsDefault = b.class.subject.is_default || false;
                
                if (aIsDefault && !bIsDefault) return -1;
                if (!aIsDefault && bIsDefault) return 1;
                return a.class.subject.name.localeCompare(b.class.subject.name);
            });
            
            relevantClasses.forEach(ic => {
                const option = document.createElement('option');
                option.value = JSON.stringify({
                    class_id: ic.class_id,
                    subject_id: ic.class.subject.id,
                    subject_name: ic.class.subject.name
                });
                
                // Add visual indicator for default subjects
                const isDefault = ic.class.subject.is_default || false;
                option.textContent = isDefault ? `⭐ ${ic.class.subject.name}` : ic.class.subject.name;
                option.style.fontWeight = isDefault ? 'bold' : 'normal';
                option.style.color = isDefault ? '#7a222b' : 'inherit';
                
                subjectSelect.appendChild(option);
            });

            // Load existing grades when subject changes
            subjectSelect.addEventListener('change', function() {
                if (this.value) {
                    const data = JSON.parse(this.value);
                    document.getElementById('formClassId').value = data.class_id;
                    document.getElementById('formSubjectId').value = data.subject_id;
                    // currentStudentData is the student object, get student_id from formStudentId
                    const studentId = document.getElementById('formStudentId').value;
                    loadExistingGrades(studentId, data.class_id, data.subject_id);
                }
            });
        }

        async function loadExistingGrades(studentId, classId, subjectId) {
            try {
                const response = await fetch(`/instructor/student/${studentId}`);
                const data = await response.json();
                
                const grade = data.grades.find(g => g.class_id == classId && g.subject_id == subjectId);
                
                if (grade) {
                    document.getElementById('formGradeId').value = grade.id;
                    document.getElementById('quarter1').value = grade.first_quarter || '';
                    document.getElementById('quarter2').value = grade.second_quarter || '';
                    document.getElementById('quarter3').value = grade.third_quarter || '';
                    document.getElementById('quarter4').value = grade.fourth_quarter || '';
                    calculateFinalGrade();
                } else {
                    // Clear form
                    document.getElementById('formGradeId').value = '';
                    document.getElementById('quarter1').value = '';
                    document.getElementById('quarter2').value = '';
                    document.getElementById('quarter3').value = '';
                    document.getElementById('quarter4').value = '';
                    document.getElementById('calculatedFinal').textContent = '0.00';
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

            const hasGrade = Object.values(quarters).some(v => v !== '');
            if (!hasGrade) {
                alert('Please enter at least one quarter grade.');
                return;
            }

            // Build summary
            const subjectData = JSON.parse(subjectSelect.value);
            const studentName = document.getElementById('studentName').textContent;
            const final = document.getElementById('calculatedFinal').textContent;

            let summary = `<strong>Student:</strong> ${studentName}<br>`;
            summary += `<strong>Subject:</strong> ${subjectData.subject_name}<br><br>`;
            summary += `<strong>Grades:</strong><br>`;
            
            Object.entries(quarters).forEach(([quarter, grade]) => {
                if (grade) {
                    summary += `• ${quarter} Quarter: ${grade}<br>`;
                }
            });
            
            summary += `<br><strong>Final Grade:</strong> ${final}`;

            document.getElementById('confirmSummary').innerHTML = summary;
            document.getElementById('gradeConfirmModal').style.display = 'block';
        }

        function closeConfirmModal() {
            document.getElementById('gradeConfirmModal').style.display = 'none';
        }

        async function submitGrade() {
            const formData = {
                grade_id: document.getElementById('formGradeId').value || null,
                student_id: document.getElementById('formStudentId').value,
                class_id: document.getElementById('formClassId').value,
                subject_id: document.getElementById('formSubjectId').value,
                first_quarter: document.getElementById('quarter1').value || null,
                second_quarter: document.getElementById('quarter2').value || null,
                third_quarter: document.getElementById('quarter3').value || null,
                fourth_quarter: document.getElementById('quarter4').value || null
            };

            // Validate all fields are present
            if (!formData.student_id || !formData.class_id || !formData.subject_id) {
                alert('❌ Missing required information. Please select a subject first.');
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                const response = await fetch('{{ route('instructor.grade.save') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                // Check if response is ok
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Server error:', errorText);
                    throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();

                if (result.success) {
                    alert('✅ Grade saved successfully!');
                    closeConfirmModal();
                    closeGradeModal();
                    location.reload(); // Refresh to show updated data
                } else {
                    const errorMsg = result.message || 'Unknown error';
                    const errors = result.errors ? '\n' + JSON.stringify(result.errors, null, 2) : '';
                    alert('❌ Failed to save grade: ' + errorMsg + errors);
                }
            } catch (error) {
                console.error('Error saving grade:', error);
                alert('❌ Failed to save grade: ' + error.message);
            }
        }

        function viewStudentDetails(studentId) {
            window.location.href = `/instructor/grade-input?student_id=${studentId}`;
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
    
    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
    
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
</body>
</html>


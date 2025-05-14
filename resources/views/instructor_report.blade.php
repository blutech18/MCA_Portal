<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Report Card</title>
    <link rel="stylesheet" href="{{ asset('css/ins_reportcard.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
                    <li><a href="{{ route('instructor.report') }}" class="nav-item active">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
                </ul>
                <div class="logout">
                    <a href="javascript:void(0)" class="nav-item" onclick="confirmExit()">LOGOUT</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>  
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>REPORT CARD</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="examplepic.png" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">Krystal Mendez</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="bell.png" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="settings.png" alt="Settings" class="icon"></a>
                    </div>
                </div>
            </div>

            <div class="search-container">
                <input type="text" placeholder="Search" class="search-bar">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>

            <div class="controls">
                <form id="filterForm" method="GET" action="{{ route('instructor.report') }}">
                  @csrf
                  <select name="class_id" onchange="document.getElementById('filterForm').submit()">
                    @foreach($instructor->instructorClasses as $iclassOption)
                      <option value="{{ $iclassOption->id }}"
                              {{ $iclassOption->id == $iclass->id ? 'selected' : '' }}>
                        {{ $iclassOption->class->name }} — {{ $iclassOption->class->section->section_name }}
                      </option>
                    @endforeach
                  </select>
                </form>
            </div>
              
            <div class="report-card-content">
                <h2 class="section-title">STUDENT LIST</h2>
              
                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif
              
                <div class="table-container">
                  <table class="student-table">
                    <thead>
                      <tr>
                        <th>NAME</th><th>CLASS</th><th>SECTION</th>
                        <th>SUBJECT</th><th>1Q</th><th>2Q</th>
                        <th>3Q</th><th>4Q</th><th>FINAL</th><th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $row)
                        @php
                          $s   = $row['student'];
                          $c   = $row['class'];
                          $sub = $row['subject'];
                          $g   = $row['grade'];
                        @endphp
              
                        <form method="POST" action="{{ route('instructor.grade.save') }}">
                          @csrf
                          <input type="hidden" name="grade_id"   value="{{ $g->id }}">
                          <input type="hidden" name="student_id" value="{{ $s->student_id }}">
                          <input type="hidden" name="class_id"   value="{{ $c->id }}">
                          <input type="hidden" name="subject_id" value="{{ $sub->id }}">
              
                          <tr>
                            <td>{{ $s->full_name }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->section->section_name }}</td>
                            <td>{{ $sub->name }}</td>
                            <td><input type="number" step="0.01" name="first_quarter"  value="{{ old('first_quarter',  $g->first_quarter)  }}" style="width:60px"></td>
                            <td><input type="number" step="0.01" name="second_quarter" value="{{ old('second_quarter', $g->second_quarter) }}" style="width:60px"></td>
                            <td><input type="number" step="0.01" name="third_quarter"  value="{{ old('third_quarter',  $g->third_quarter)  }}" style="width:60px"></td>
                            <td><input type="number" step="0.01" name="fourth_quarter" value="{{ old('fourth_quarter', $g->fourth_quarter) }}" style="width:60px"></td>
                            <td>{{ number_format($g->final_grade ?? 0, 2) }}</td>
                            <td><button type="submit" class="btn btn-sm btn-primary">Save</button></td>
                          </tr>
                        </form>
                      @endforeach
                    </tbody>
                  </table>
                </div>

            </div>

            @if($coreStudent)
              <div class="table-container">
                <div class="table-header" style="display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;background:#050a30;color:#fff;">
                  <div>
                    <label for="studentSelect" style="margin-right:1rem;color:#fff;font-weight:600;">Pick Student:</label>
                    <select id="studentSelect" onchange="location = '?student='+this.value" style="padding:0.5rem;border-radius:4px;border:none;">
                      @foreach($rows as $row)
                        @php $s = $row['student']; @endphp
                        <option value="{{ $s->student_id }}" {{ optional($coreStudent)->student_id==$s->student_id?'selected':'' }}>
                          {{ $s->full_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  
                </div>

                <form method="POST" action="{{ route('instructor.evaluations.save') }}">
                  @csrf
                  <input type="hidden" name="student_id" value="{{ $coreStudent->student_id }}">
                  <table class="student-table core-values-table">
                    <thead>
                      <tr>
                        <th>Core Value</th>
                        <th>Score (0–100)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($coreValues as $cv)
                        <tr>
                          <td>{{ $cv->name }}</td>
                          <td>
                            <input type="number"
                                  name="scores[{{ $cv->id }}]"
                                  value="{{ old('scores.'.$cv->id, $evaluations[$cv->id] ?? '') }}"
                                  min="0" max="100" step="0.1"
                                  style="width:80px;padding:0.25rem;border:1px solid #ccc;border-radius:4px;">
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div style="padding:1rem 1.5rem; text-align:right;">
                    <button type="submit" class="btn btn-primary">Save Evaluations</button>
                  </div>
                </form>
              </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            document.querySelector('.search-button').addEventListener('click', function() {
                const searchValue = document.querySelector('.search-bar').value;
                console.log('Searching for:', searchValue);
                // Implement actual search functionality here
            });

            // Handle row selection in student table
            const tableRows = document.querySelectorAll('.student-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    // Remove active class from all rows
                    tableRows.forEach(r => r.classList.remove('active'));
                    // Add active class to clicked row
                    this.classList.add('active');
                    
                    // Update student card info based on selected student
                    const name = this.cells[0].textContent;
                    const section = this.cells[2].textContent;
                    const grade = this.cells[3].textContent;
                    
                    document.querySelector('.student-info .info-value:nth-child(2)').textContent = name;
                    document.querySelector('.student-info .info-value:nth-child(4)').textContent = section;
                    document.querySelector('.student-info .info-value:nth-child(6)').textContent = grade;
                });
            });
        });
    </script>
</body>
</html>
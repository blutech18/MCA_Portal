<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Year Comparison</title>
  <link rel="stylesheet" href="{{ asset('css/styles_admin_archive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_archive_comparison.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="{{ asset('images/schoollogo.png') }}" alt="School Logo" class="logo">
      <h2>MCA Montessori School</h2>
      <nav class="menu">
        <ul>
          <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Dashboard</a></li>
          <li><a href="{{ route('admin.users') }}" class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">Users</a></li>
          <li>
            <a href="#" onclick="toggleSubMenu(event)">Instructors ▾</a>
            <ul class="submenu hidden">
              <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
              <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
          <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
          <li><a href="{{ route('admin.archive') }}" class="{{ Route::currentRouteName() == 'admin.archive' ? 'active' : '' }}">Archive</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <div class="welcome">
          <h3>Year-over-Year Comparison</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/settings.png') }}" class="icon" id="settingsToggle">
          <div class="dropdown-menu" id="settingsMenu">
            <button class="dropdown-item" onclick="confirmExit()">
              <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M16 13v-2H7V8l-5 4 5 4v-3zM20 3h-8v2h8v14h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
              </svg>
              <span>Logout</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
            </form>
          </div>
        </div>
      </header>

      <div class="container-archive">
        <!-- Success/Error Messages -->
        @if(session('success'))
          <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-message">{{ session('success') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
          </div>
        @endif
        
        @if(session('error'))
          <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-message">{{ session('error') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
          </div>
        @endif

        @if(isset($errors) && $errors->any())
          <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <div class="alert-message">
              <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
          </div>
        @endif

        <!-- Navigation -->
        <section class="archive-controls">
          <div class="year-selector">
            <a href="{{ route('admin.archive') }}" class="btn btn-outline">← Back to Archive</a>
          </div>
          <div class="archive-actions">
            <button class="btn btn-info" onclick="exportComparison()">
              📊 Export Comparison
            </button>
            <a href="{{ route('admin.academic-years') }}" class="btn btn-secondary">
              ⚙️ Manage Academic Years
            </a>
          </div>
        </section>

        <!-- Comparison Overview -->
        <section class="comparison-overview">
          <div class="overview-grid">
            <div class="overview-card">
              <div class="overview-icon">📅</div>
              <div class="overview-content">
                <h3>{{ $comparison->count() }}</h3>
                <p>Academic Years</p>
              </div>
            </div>
            
            <div class="overview-card">
              <div class="overview-icon">👥</div>
              <div class="overview-content">
                <h3>{{ $comparison->sum('total_students') }}</h3>
                <p>Total Students (All Years)</p>
              </div>
            </div>
            
            <div class="overview-card">
              <div class="overview-icon">📈</div>
              <div class="overview-content">
                <h3>{{ $comparison->isNotEmpty() ? number_format(($comparison->max('total_students') - $comparison->min('total_students')) / max($comparison->min('total_students'), 1) * 100, 1) : 0 }}%</h3>
                <p>Growth Rate</p>
              </div>
            </div>
            
            <div class="overview-card">
              <div class="overview-icon">🏆</div>
              <div class="overview-content">
                <h3>{{ $comparison->isNotEmpty() ? $comparison->where('total_students', $comparison->max('total_students'))->first()['year'] ?? 'N/A' : 'N/A' }}</h3>
                <p>Peak Enrollment Year</p>
              </div>
            </div>
          </div>
        </section>

        <!-- Year Comparison Table -->
        <section class="comparison-table-section">
          <div class="table-header">
            <h4>Academic Year Comparison</h4>
            <span class="comparison-note">Data comparison across {{ $comparison->count() }} academic years</span>
          </div>
          
          @if($comparison->count() > 0)
            <div class="table-container">
              <table id="comparison-table">
                <thead>
                  <tr>
                    <th>Academic Year</th>
                    <th>Total Students</th>
                    <th>Grade Distribution</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($comparison as $yearData)
                    <tr>
                      <td>
                        <div class="year-info">
                          <strong>{{ $yearData['year'] }}</strong>
                          @if($years->where('year_name', $yearData['year'])->first()->is_current ?? false)
                            <span class="current-badge">Current</span>
                          @elseif($years->where('year_name', $yearData['year'])->first()->is_archived ?? false)
                            <span class="archived-badge">Archived</span>
                          @endif
                        </div>
                      </td>
                      <td>
                        <div class="student-count">
                          <strong>{{ $yearData['total_students'] }}</strong>
                          @if($loop->index > 0)
                            @php
                              $prevCount = $comparison[$loop->index - 1]['total_students'];
                              $change = $yearData['total_students'] - $prevCount;
                              $changePercent = $prevCount > 0 ? ($change / $prevCount * 100) : 0;
                            @endphp
                            <small class="change {{ $change >= 0 ? 'positive' : 'negative' }}">
                              {{ $change >= 0 ? '+' : '' }}{{ $change }} ({{ $changePercent >= 0 ? '+' : '' }}{{ number_format($changePercent, 1) }}%)
                            </small>
                          @endif
                        </div>
                      </td>
                      <td>
                        <div class="grade-distribution-dropdown">
                          @if(isset($yearData['grade_distribution']) && count($yearData['grade_distribution']) > 0)
                            @php
                              $totalStudents = $yearData['total_students'];
                              $grades7to12 = collect($yearData['grade_distribution'])->filter(function($grade) {
                                $gradeLevel = $grade->grade_level_id ?? 0;
                                return $gradeLevel >= 7 && $gradeLevel <= 12;
                              })->sortBy('grade_level_id');
                            @endphp
                            
                            <div class="dropdown-container">
                              <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                <span class="total-students">{{ $totalStudents }} Total Students</span>
                                <span class="dropdown-arrow">▼</span>
                              </button>
                              
                              <div class="dropdown-content">
                                @if($grades7to12->count() > 0)
                                  @foreach($grades7to12 as $grade)
                                    @php
                                      $gradeName = $grade->gradeLevel->name ?? "Grade {$grade->grade_level_id}";
                                      // Remove "Grade " prefix if it exists for cleaner display
                                      if (strpos($gradeName, 'Grade ') === 0) {
                                        $gradeName = substr($gradeName, 6);
                                      }
                                    @endphp
                                    <div class="grade-item">
                                      <span class="grade-name">Grade {{ $gradeName }}</span>
                                      <span class="grade-count">{{ $grade->count }}</span>
                                    </div>
                                  @endforeach
                                @else
                                  <div class="grade-item no-data">
                                    <span class="grade-name">No Grades 7-12 Data</span>
                                    <span class="grade-count">-</span>
                                  </div>
                                @endif
                              </div>
                            </div>
                          @else
                            <div class="dropdown-container">
                              <button class="dropdown-toggle disabled">
                                <span class="total-students">0 Total Students</span>
                                <span class="dropdown-arrow">▼</span>
                              </button>
                            </div>
                          @endif
                        </div>
                      </td>
                      <td>
                        @if($years->where('year_name', $yearData['year'])->first()->is_current ?? false)
                          <span class="status-badge active">Active</span>
                        @elseif($years->where('year_name', $yearData['year'])->first()->is_archived ?? false)
                          <span class="status-badge archived">Archived</span>
                        @else
                          <span class="status-badge inactive">Inactive</span>
                        @endif
                      </td>
                      <td>
                        <div class="action-buttons">
                          @php
                            $currentAcademicYear = \App\Models\AcademicYear::getCurrentAcademicYear();
                            $isCurrentYear = $yearData['year'] === ($currentAcademicYear->year_name ?? null);
                          @endphp
                          <a href="{{ route('admin.archive.year', $yearData['year']) }}" class="btn btn-sm btn-info" title="View all students for {{ $yearData['year'] }}">
                            👁️ View Students
                          </a>
                          <button class="btn btn-sm btn-success" onclick="exportYear('{{ $yearData['year'] }}')" title="Export student data for {{ $yearData['year'] }}">
                            📊 Export
                          </button>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="no-data">
              <div class="no-data-icon">📊</div>
              <h4>No comparison data available</h4>
              <p>No academic years found for comparison.</p>
            </div>
          @endif
        </section>

        <!-- Growth Chart Section -->
        <section class="growth-chart-section">
          <div class="chart-header">
            <h4>Enrollment Growth Trend</h4>
            <p>Student enrollment across academic years</p>
          </div>
          
          <div class="chart-container">
            <canvas id="growthChart" width="400" height="200"></canvas>
          </div>
        </section>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Export functionality
    function exportComparison() {
      if (confirm('Do you want to export the comparison data?')) {
        // Create a form to submit export request
        const form = document.createElement('form');
        form.method = 'GET';
        form.action = `{{ route('admin.archive.export', '') }}/comparison`;
        document.body.appendChild(form);
        form.submit();
      }
    }

    function exportYear(year) {
      if (confirm(`Do you want to export student data for academic year ${year}?\n\nThis will download a CSV file containing all student information for that year.`)) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '⏳ Exporting...';
        button.disabled = true;
        
        // Create a temporary link to trigger download
        const link = document.createElement('a');
        link.href = `{{ route('admin.archive.export', '') }}/${encodeURIComponent(year)}`;
        link.download = `students_${year.replace(/[^a-zA-Z0-9]/g, '_')}_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Reset button after a short delay
        setTimeout(() => {
          button.innerHTML = originalText;
          button.disabled = false;
        }, 2000);
      }
    }

    // Logout functionality
    function confirmExit() {
      if (confirm('Are you sure you want to logout?')) {
        document.getElementById('logout-form').submit();
      }
    }

    // Toggle dropdown functionality
    function toggleDropdown(button) {
      const dropdown = button.closest('.dropdown-container');
      const content = dropdown.querySelector('.dropdown-content');
      const arrow = button.querySelector('.dropdown-arrow');
      
      // Close all other dropdowns
      document.querySelectorAll('.dropdown-content').forEach(otherContent => {
        if (otherContent !== content) {
          otherContent.classList.remove('show');
        }
      });
      
      // Toggle current dropdown
      content.classList.toggle('show');
      
      // Rotate arrow
      if (content.classList.contains('show')) {
        arrow.style.transform = 'rotate(180deg)';
      } else {
        arrow.style.transform = 'rotate(0deg)';
      }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.dropdown-container')) {
        document.querySelectorAll('.dropdown-content').forEach(content => {
          content.classList.remove('show');
        });
        document.querySelectorAll('.dropdown-arrow').forEach(arrow => {
          arrow.style.transform = 'rotate(0deg)';
        });
      }
    });

    // Auto-close success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          if (alert.parentNode) {
            alert.remove();
          }
        }, 5000);
      });
    });

    // Growth Chart
    const comparisonData = @json($comparison);
    const ctx = document.getElementById('growthChart').getContext('2d');
    
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: comparisonData.map(item => item.year),
        datasets: [{
          label: 'Total Students',
          data: comparisonData.map(item => item.total_students),
          borderColor: '#7a222b',
          backgroundColor: 'rgba(122, 34, 43, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Student Enrollment Growth'
          },
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Students'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Academic Year'
            }
          }
        }
      }
    });
  </script>
</body>
</html>

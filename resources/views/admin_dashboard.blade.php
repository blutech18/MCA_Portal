@extends('layouts.admin_base')

@section('title', 'Dashboard')
@section('header', 'Welcome, Administrator!')

@push('head')
  <style>
    /* Layout spacing */
    .admin-dashboard .container { max-width: 1200px; margin: 0 auto; padding: 12px; box-sizing: border-box; }
    .admin-dashboard .dashboard-section { padding: 0; }
    .admin-dashboard .banner,
    .admin-dashboard .banner-subjects,
    .admin-dashboard .banner-strands { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      grid-auto-rows: 1fr; /* equal height rows */
      gap: 12px; 
      padding: 12px; 
      box-sizing: border-box;
      max-width: 100%;
      width: 100%;
      align-items: stretch;
    }
    /* 2x2 dashboard grid for tables and charts */
    .admin-dashboard .dashboard-grid-2x2 { 
      display: grid; 
      grid-template-columns: repeat(2, minmax(0, 1fr));
      grid-auto-rows: 1fr;
      gap: 12px;
      padding: 12px;
      box-sizing: border-box;
      width: 100%;
      align-items: stretch;
    }
    /* Provide clear separation between tables and charts */
    .admin-dashboard .banner-strands { margin-top: 16px; }
    /* Stronger rule to ensure spacing is applied even if other styles exist */
    .admin-dashboard .banner-subjects + .banner-strands { margin-top: 16px !important; }
    .admin-dashboard .dashboard-separator { height: 16px; }

    /* Simple card */
    .admin-dashboard .card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px; }
    .admin-dashboard .users-box, 
    .admin-dashboard .subjects-box { 
      background: #ffffff; 
      border: 1px solid #e5e7eb; 
      border-radius: 8px; 
      padding: 14px 16px; 
      display: flex; 
      flex-direction: column; 
      gap: 8px; 
      box-shadow: none; 
      max-width: 100%;
      box-sizing: border-box;
      height: 100%; /* fill grid row height */
    }
    /* Stronger specificity: ensure all direct grid children fill height */
    .admin-dashboard .banner > .subjects-box,
    .admin-dashboard .banner-subjects > .subjects-box,
    .admin-dashboard .banner-strands > .subjects-box { height: 100%; }
    /* Ensure card/table sections have adequate height without page overflow */
    .admin-dashboard .subjects-box { min-height: 420px; }
    .admin-dashboard .dashboard-grid-2x2 .subjects-box { min-height: 420px; display: flex; flex-direction: column; }
    /* Make card bodies flex-fill for equal heights across 2x2 */
    .admin-dashboard .dashboard-grid-2x2 .subjects-box .subject-g11 { flex: 1 1 auto; min-height: 0; overflow: auto; }
    /* Chart cards: keep consistent inner height */
    /* Charts containers (Junior/Senior) */
    .admin-dashboard .dashboard-grid-2x2 .subjects-box .logo-number {
      position: relative;
      flex: 1 1 auto;
      min-height: 0; /* allow flex container to control height */
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px; /* consistent inner padding like tables */
      overflow: hidden; /* prevent scrollbars around canvas */
    }
    .admin-dashboard .dashboard-grid-2x2 .subjects-box .logo-number canvas {
      width: 100% !important;
      height: 100% !important;
      display: block;
    }

    /* Fixed-height scrollable tables for first two cards (All Subjects, All Classes) */
    .admin-dashboard .dashboard-grid-2x2 > .subjects-box:nth-child(-n+2) .subject-g11 { height: 300px; overflow-y: auto; overflow-x: hidden; }
    .admin-dashboard .dashboard-grid-2x2 > .subjects-box:nth-child(-n+2) table { width: 100%; border-collapse: collapse; }
    .admin-dashboard .dashboard-grid-2x2 > .subjects-box:nth-child(-n+2) table thead th { position: sticky; top: 0; background: #f9fafb; z-index: 1; }
    .admin-dashboard .users-box > *:last-child,
    .admin-dashboard .subjects-box > *:last-child { margin-bottom: 0; }
    .admin-dashboard .subject-box-title { display: flex; align-items: center; justify-content: space-between; margin: 0; }
    .admin-dashboard .subject-box-title h3, 
    .admin-dashboard .subject-box-title p { margin: 0; font-weight: 600; color: #111827; font-size: 14px; }
    .admin-dashboard .subject-box-title a { color: #1f2937; text-decoration: none; font-size: 12px; }
    .admin-dashboard .subject-box-title a:hover { text-decoration: underline; }

    /* KPI blocks */
    .admin-dashboard .logo-number { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .admin-dashboard .logo-number img { width: 40px; height: 40px; object-fit: contain; flex: 0 0 auto; }
    .admin-dashboard .logo-number h2 { margin: 0; font-size: 20px; color: #111827; font-weight: 700; line-height: 1; }

    /* Tables */
    .admin-dashboard .subjects-box table { width: 100%; border-collapse: collapse; table-layout: fixed; }
    .admin-dashboard .subjects-box thead th { text-align: left; background: #f9fafb; color: #374151; font-size: 12px; padding: 10px 12px; border-bottom: 1px solid #e5e7eb; }
    .admin-dashboard .subjects-box tbody td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; font-size: 13px; color: #111827; word-wrap: break-word; overflow-wrap: anywhere; }
    .admin-dashboard .subjects-box tbody tr:hover { background: #f9fafb; }

    /* Charts */
    .admin-dashboard .logo-number canvas { width: 100% !important; height: 220px !important; display: block; }

    /* Responsive */
    @media (max-width: 640px) {
      .admin-dashboard .banner, .admin-dashboard .banner-subjects, .admin-dashboard .banner-strands, .admin-dashboard .dashboard-grid-2x2 { padding: 10px; gap: 8px; }
      .admin-dashboard .dashboard-separator { height: 10px; }
      .admin-dashboard .logo-number img { width: 32px; height: 32px; }
    }
  </style>
@endpush

@section('content')
      <div class="admin-dashboard">
      <div class="container">
      <section class="banner">
        <!-- Student Users -->
        <div class="users-box">
          <div class="subject-box-title">
            <p>Student Users</p>
            <a href="{{ route('admin.users') }}">See more »</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/student_user.png') }}" alt="Students">
            <h2><strong>{{ $studentCount }}</strong></h2>
          </div>
        </div>

        <!-- Instructor Users -->
        <div class="users-box">
          <div class="subject-box-title">
            <p>Instructor Users</p>
            <a href="{{ route('admin.instructors') }}">See more »</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/instructor_user.png') }}" alt="Instructors">
            <h2><strong>{{ $instructorCount }}</strong></h2>
          </div>
        </div>

        <!-- Total Users -->
        <div class="users-box">
          <div class="subject-box-title">
            <p>Total Users</p>
            <a href="{{ route('admin.users') }}">See more »</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/all_user.png') }}" alt="All Users">
            <h2><strong>{{ $totalCount }}</strong></h2>
          </div>
        </div>
        
      </section>

      <!-- Content Sections -->
      <section class="dashboard-grid-2x2">

        <div class="subjects-box">
          <div class="subject-box-title">
            <h3>All Subjects</h3>
            <a href="{{ route('admin.subjects') }}">See more &gt;&gt;</a>
          </div>
          <div class="subject-g11">
            <table>
              <thead>
                <tr>
                  <th>Subject Code</th>
                  <th>Subject Name</th>
                </tr>
              </thead>
              <tbody>
                @foreach($subjects as $subj)
                  <tr>
                    <td>{{ $subj->code }}</td>
                    <td>{{ $subj->name }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="subjects-box">
          <div class="subject-box-title">
            <h3>All Classes</h3>
            <a href="{{ route('admin.classes') }}">See more &gt;&gt;</a>
          </div>
          <div class="subject-g11">
            <table>
              <thead>
                <tr>
                  <th>Class Name</th>
                  <th>Class Code</th>
                  <th>Subject</th>
                </tr>
              </thead>
              <tbody>
                @foreach($classes as $class)
                  <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->code }}</td>
                    <td>{{ $class->subject->name ?? 'N/A' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="subjects-box">
          <div class="subject-box-title">
            <p>Junior High Sections</p>
            <a href="{{ route('admin.classes') }}">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <canvas id="juniorChart"></canvas>
      </div>
        </div>
        <div class="subjects-box">
          <div class="subject-box-title">
            <p>Senior High Sections</p>
            <a href="{{ route('admin.classes') }}">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <canvas id="seniorChart"></canvas>
          </div>
        </div>
      </section>
      <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
            <button class="cancel-btn" onclick="closeModal()">No</button>
        </div>
      </div>
  </div>
@endsection

@push('scripts')
  <script>
    const juniorLabels = @json($juniorLabels);
    const juniorData = @json($juniorData);
    const seniorLabels = @json($seniorLabels);
    const seniorData = @json($seniorData);

    console.log("juniorLabels:", juniorLabels);
    console.log("seniorLabels:", seniorLabels);
</script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
  <script src="{{ asset('js/script_admin_dashboard.js') }}"></script>
  <script src="{{ asset('js/logout.js') }}"></script>
@endpush

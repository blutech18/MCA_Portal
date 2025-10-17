@extends('layouts.admin_base')

@section('title', 'Admin - Users')
@section('header', 'Users')

@push('head')
  <style>
    .admin-users .container { max-width: 1200px; margin: 0 auto; padding: 12px; }
    .admin-users .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .admin-users .card { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:14px 16px; display:flex; flex-direction:column; gap:8px; }
    .admin-users .subject-box-title { display:flex; align-items:center; justify-content:space-between; }
    .admin-users .subject-box-title p { margin:0; font-weight:600; }
    .admin-users .search-bar { width:100%; padding:8px 10px; border:1px solid #e5e7eb; border-radius:6px; }
    .admin-users .table-wrap { flex:1 1 auto; height:300px; overflow:auto; }
    .admin-users table { width:100%; border-collapse:collapse; table-layout:fixed; }
    .admin-users thead th { position:sticky; top:0; background:#f9fafb; color:#000; border-bottom:1px solid #e5e7eb; text-align:left; padding:10px 12px; font-size:12px; }
    .admin-users tbody td { padding:8px 10px; border-bottom:1px solid #f3f4f6; font-size:13px; word-wrap:break-word; }
    
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
  <div class="admin-users">
    <div class="container">
      @php
        $studentUsers = $users->where('user_type', 'student');
        $instructorUsers = $users
            ->where('user_type', 'instructor')
            ->reject(function ($user) { return $user->username === 'admin_mca' || $user->name === 'Administrator'; });
      @endphp

      <div class="grid">
        <div class="card">
          <div class="subject-box-title">
            <p>Student Users</p>
          </div>
          <input type="text" class="search-bar" placeholder="Search Student Users..." onkeyup="filterUsers(this, 'student-table')">
          <div class="table-wrap">
            <table id="student-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($studentUsers as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="subject-box-title">
            <p>Instructors</p>
          </div>
          <input type="text" class="search-bar" placeholder="Search Instructors..." onkeyup="filterUsers(this, 'instructor-table')">
          <div class="table-wrap">
            <table id="instructor-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Username</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($instructorUsers as $user)
                  <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div id="addUserModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Add New User</h2>
      
            @php
                // grab the error bag from the session
                $errorsBag = session('errors');
            @endphp
                
            @if($errorsBag && $errorsBag->any())
                <div class="alert alert-danger" style="color:red; margin-bottom:1rem;">
                    <ul style="padding-left:1.2rem; margin:0;">
                    @foreach($errorsBag->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
        
            @if(session('success'))
                <div id="successPopup" class="popup-success">
                {{ session('success') }}
                </div>
            @endif

      
          <form method="POST" action="{{ route('users.store') }}">
            @csrf
      
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
      
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
      
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
      
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
      
            <label for="user_type">User Type</label>
            <select id="user_type" name="user_type" required>
              <option value="">-- Select User Type --</option>
              <option value="student" {{ old('user_type')=='student'?'selected':'' }}>Student</option>
              <option value="faculty" {{ old('user_type')=='faculty'?'selected':'' }}>Instructor</option>
            </select>
      
            <button type="submit" class="submit-btn">Add User</button>
          </form>

        </div>
    </div>
      

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // If there were validation errors in session, auto‑open the modal:
        @if (session('errors') && session('errors')->any())
            document.getElementById('addUserModal').style.display = 'flex';
        @endif

        // Open "Add User" modal on button click
        document.querySelectorAll('.add-user-btn').forEach(btn => {
            btn.addEventListener('click', () => {
            document.getElementById('addUserModal').style.display = 'flex';
            });
        });

        // Close modal on "×"
        document.querySelectorAll('.modal .close').forEach(x => {
            x.addEventListener('click', () => {
            x.closest('.modal').style.display = 'none';
            });
        });

        // Close modal when clicking on overlay
        window.addEventListener('click', e => {
            if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
            }
        });
        });

        @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const successPopup = document.getElementById('successPopup');
            if (successPopup) {
            successPopup.style.display = 'block';

            // Optional: Automatically hide after 5s
            setTimeout(() => {
                successPopup.style.display = 'none';
            }, 5000);
            }
        });
        @endif
    
    </script>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    <!-- Modal Functions -->
    <script>
      function closeModal() {
        const modal = document.getElementById('confirm-modal');
        if (modal) {
          modal.style.display = 'none';
        }
      }
    </script>

    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush


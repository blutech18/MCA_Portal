@extends('layouts.app')

@section('content')
 
    <div class="container-users">
        @php
             $studentUsers = $users->where('user_type', 'student');
            $instructorUsers = $users
                ->where('user_type', 'faculty')
                ->reject(function ($user) {
                    return $user->username === 'admin_mca' || $user->name === 'Administrator';
                });
            
        @endphp

        <div class="users-box2">
            <div class="subject-box-title">
                <p>Student Users</p>
                <button class="add-user-btn" data-type="student">+ Add User</button>
            </div>

            <!-- Search Bar -->
            <input type="text" class="search-bar" placeholder="Search Student Users..." onkeyup="filterUsers(this, 'student-table')">

            <!-- Users Table -->
            <table class="users-table" id="student-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <!-- Add more columns if needed -->
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

        <div class="users-box2">
            <div class="subject-box-title">
                <p>Instructors</p>
                <button class="add-user-btn" data-type="instructor">+ Add User</button>
            </div>

            <!-- Search Bar -->
            <input type="text" class="search-bar" placeholder="Search Instructors..." onkeyup="filterUsers(this, 'instructor-table')">

            <!-- Users Table -->
            <table class="users-table" id="instructor-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <!-- Add more columns if needed -->
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
      

    <!-- Confirm Logout Modal (if you still need it) -->
    <div id="confirm-modal" class="modal">
      <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
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
@endpush


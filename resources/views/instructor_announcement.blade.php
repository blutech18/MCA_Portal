@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Announcements</title>
    <link rel="stylesheet" href="{{ asset('css/instructor_announcement.css') }}?v={{ time() }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
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
                          <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                      </ul>
                  </li>
                  <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                  <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                  <li><a href="{{ route('instructor.announcement') }}" class="nav-item active">ANNOUNCEMENTS</a></li>
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
              <h1>ANNOUNCEMENTS</h1>
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
          
            <!-- Announcements Content -->
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-bullhorn"></i> Announcements</h2>
                    <p>Create and manage announcements for your students</p>
                </div>
                
                <!-- Success/Error Notifications -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(session('errors'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach(session('errors')->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="announcement-form">
                    <div class="form-header">
                        <h3><i class="fas fa-plus-circle"></i> Create New Announcement</h3>
                    </div>
                    <form action="{{ route('instructor.announcement.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="section-select"><i class="fas fa-layer-group"></i> Select Section:</label>
                            <select id="section-select" name="section_id" required>
                                <option value="">Choose a section</option>
                                @if(isset($sections) && $sections->count() > 0)
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                            {{ $section->section_name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No sections available</option>
                                @endif
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="title"><i class="fas fa-heading"></i> Title:</label>
                            <input type="text" id="title" name="title" required placeholder="Enter announcement title..." value="{{ old('title') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="message"><i class="fas fa-comment"></i> Message:</label>
                            <textarea id="message" name="message" rows="4" required placeholder="Enter your announcement message...">{{ old('message') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="file"><i class="fas fa-paperclip"></i> Attachment (Optional):</label>
                            <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>
                        
                        <button type="submit" class="announce-btn"><i class="fas fa-paper-plane"></i> Send Announcement</button>
                    </form>
                </div>
                
                <div class="announcements-list">
                    <div class="list-header">
                        <h3><i class="fas fa-list"></i> Recent Announcements</h3>
                    </div>
                    <div class="announcements-list-content">
                        @if(isset($announcements) && $announcements->count() > 0)
                        @foreach($announcements as $a)
                            <div class="announcement-item">
                                <div class="announcement-header">
                                    <div class="announcement-title">
                                        <h4><i class="fas fa-bullhorn"></i> {{ $a->title ?? 'Untitled Announcement' }}</h4>
                                        <p class="class-info"><i class="fas fa-chalkboard-teacher"></i> Class: {{ $a->class_name ?? 'Unknown Class' }}</p>
                                    </div>
                                    <div class="announcement-date">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $a->created_at ? $a->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="announcement-content">
                                    <p>{{ $a->message ?? 'No message' }}</p>
                                    @if($a->file_exists)
                                        <div class="attachment">
                                            <i class="fas fa-paperclip"></i>
                                            <a href="{{ $a->file_url }}" target="_blank" download="{{ $a->file_name }}">
                                                <i class="fas fa-download"></i> Download {{ $a->file_name }}
                                            </a>
                                        </div>
                                    @elseif($a->file_path)
                                        <div class="attachment-missing">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <span>Attachment file missing: {{ $a->file_name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-announcements">
                            <i class="fas fa-inbox"></i>
                            <p>No announcements yet.</p>
                        </div>
                        @endif
                    </div>
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
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar) {
                        sidebar.classList.toggle('active');
                    }
                });
            }
            
            // Search functionality
            const searchButton = document.querySelector('.search-button');
            if (searchButton) {
                searchButton.addEventListener('click', function() {
                    const searchBar = document.querySelector('.search-bar');
                    if (searchBar) {
                        const searchValue = searchBar.value;
                        console.log('Searching for:', searchValue);
                        // Implement actual search functionality here
                    }
                });
            }

            // Form validation and submission
            const announceBtn = document.querySelector('.announce-btn');
            const form = document.querySelector('form[action*="announcement"]');
            
            if (announceBtn && form) {
                // Handle form submission
                form.addEventListener('submit', function(e) {
                    const messageText = document.querySelector('#message');
                    const selectedSection = document.querySelector('#section-select');
                    const titleInput = document.querySelector('#title');
                    
                    // Check for validation errors
                    let hasErrors = false;
                    
                    if (titleInput && titleInput.value.trim() === '') {
                        e.preventDefault();
                        alert('Please enter a title for the announcement.');
                        hasErrors = true;
                    }
                    
                    if (messageText && messageText.value.trim() === '') {
                        e.preventDefault();
                        alert('Please enter a message before announcing.');
                        hasErrors = true;
                    }
                    
                    if (selectedSection && (selectedSection.value === '' || selectedSection.value === null)) {
                        e.preventDefault();
                        alert('Please select a section before announcing.');
                        hasErrors = true;
                    }
                    
                    // If all validations pass, show loading state
                    if (!hasErrors) {
                        announceBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                        announceBtn.disabled = true;
                        
                        // Re-enable button after 10 seconds in case of error
                        setTimeout(function() {
                            announceBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Announcement';
                            announceBtn.disabled = false;
                        }, 10000);
                    }
                });
            }
            
            // File upload preview
            const fileInput = document.querySelector('#file');
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        console.log('File selected:', file.name);
                        // You can add file preview functionality here
                    }
                });
            }
        });
    </script>
    
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
</body>
</html>

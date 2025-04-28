<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Announcements</title>
    <link rel="stylesheet" href="{{ asset('css/ins_announcement.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{asset('images/logo.png')}}" alt="MCA Montessori School" class="logo">
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
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item active">ANNOUNCEMENTS</a></li>
                </ul>
                <div class="logout">
                    <a href="javascript:void(0)" class="nav-item" onclick="confirmExit()">LOGOUT</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>  
            </nav>
        </div>

        
        <div class="main-content">
            <div class="header">
                <h1>ANNOUNCEMENTS</h1>
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

            
            <h1>Post a New Announcement</h1>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="announcement-creation">
                <form method="POST" action="{{ route('instructor.announcement.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="controls-container">
                        <div class="section-dropdown" style="flex: 1;">
                            <label>Section</label>
                            <select name="class_name">
                                <option value="" disabled {{ old('class_name') ? '' : 'selected' }}>Choose Section</option>
                                @foreach($instructor->instructorClasses as $ic)
                                    <option value="{{ $ic->class->section->section_name }}"
                                        {{ old('class_name') == $ic->class->section->section_name ? 'selected' : '' }}>
                                        {{ $ic->class->name }} — {{ $ic->class->section->section_name }}
                                    </option>
                                @endforeach
                            </select>
            
                            @isset($errors)
                                @error('class_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            @endisset
                        </div>
            
                        <div style="flex: 1;">
                            <label>Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" style="width: 100%; padding: 10px 16px; border: 1px solid #ccc; border-radius: 6px;">
            
                            @isset($errors)
                                @error('title')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            @endisset
                        </div>
                    </div>
            
                    <div class="message-box">
                        <div class="message-header">
                            <h3>Message</h3>
                        </div>
                        <div class="message-content">
                            <textarea name="message" rows="6">{{ old('message') }}</textarea>
            
                            @isset($errors)
                                @error('message')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            @endisset
                        </div>
                    </div>
            
                    <div class="controls-container">
                        <div>
                            <label class="add-file-btn">
                                📎 Add File
                                <input type="file" name="file" style="display: none;">
                            </label>
            
                            @isset($errors)
                                @error('file')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            @endisset
                        </div>
            
                        <div>
                            <button type="submit" class="announce-btn">🚀 Announce</button>
                        </div>
                    </div>
                </form>
            </div>
            

            <hr>

            <h2>All Announcements</h2>
            <div class="announcements-list">
            @forelse($announcements as $a)
                <div class="announcement-card">
                <h4>{{ $a->title }}</h4>
                <p><strong>To:</strong> {{ $a->class_name }}</p>
                <p>{{ $a->message }}</p>
                @if($a->file_path)
                    <p><a href="{{ Storage::url($a->file_path) }}" target="_blank">Download Attachment</a></p>
                @endif
                <small>
                    Posted 
                    {{ optional($a->created_at)->diffForHumans() ?? 'Just now' }}
                </small>
                </div>
            @empty
                <p>No announcements yet.</p>
            @endforelse
            </div>

            
            
            <!--<div class="announcement-status">
                <div class="table-container">
                    <table class="status-table">
                        <thead>
                            <tr>
                                <th>STUDENT</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>John Rivera</td>
                                <td>Not Viewed</td>
                            </tr>
                            <tr>
                                <td>Sofia Garcia</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>Miguel Cruz</td>
                                <td>Not Viewed</td>
                            </tr>
                            <tr>
                                <td>Gabriela Ponce</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>Alex Reyes</td>
                                <td>Not Viewed</td>
                            </tr>
                            <tr>
                                <td>Isabella Lim</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>Diego Tan</td>
                                <td>Not Viewed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>-->

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

            
            document.querySelector('.announce-btn').addEventListener('click', function() {
                const messageText = document.querySelector('.message-content textarea').value;
                const selectedSection = document.querySelector('#section-select').value;
                
                if (messageText.trim() === '') {
                    alert('Please enter a message before announcing.');
                    return;
                }
                
                if (selectedSection === '' || selectedSection === null) {
                    alert('Please select a section before announcing.');
                    return;
                }
                
                
                document.querySelector('.preview-content p').textContent = messageText;
                document.querySelector('.preview-recipient').textContent = 'To: ' + 
                    document.querySelector('#section-select option:checked').text;
                
                
                alert('Announcement sent successfully!');
                
                
                document.querySelector('.message-content textarea').value = '';
            });
            
            
            document.querySelector('.add-file-btn').addEventListener('click', function() {
                alert('File upload functionality would be implemented here.');
                
            });
        });
    </script>
</body>
</html>
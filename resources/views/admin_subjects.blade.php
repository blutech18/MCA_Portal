@extends('layouts.admin_base')

@section('title', 'Admin - Subject Management')
@section('header', 'Manage Subjects')

@push('head')
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self';">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_instructors.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/style_admin_subjects.css') }}?v={{ time() }}">
@endpush

@section('content')
      <div class="container-subjects">
        <div class="search-bar-container">
          <h3>All Subjects</h3>
          <input
            type="text"
            id="instructor-search"
            class="search-bar2"
            placeholder="Search Subject"
            aria-label="Search Subject"
          >
        </div>
        <div class="subject-section">
          <div class="profile-header">
            <select name="sort" id="sort">
              <option value="">---Sort by---</option>
            </select>
            <!-- Add Subject Button -->
            <button class="btn add-subject" id="add-subject-btn">Add</button>
            <!-- Reset to Default Subjects Button -->
            <button class="btn reset-default-btn" id="reset-default-btn" data-reset-url="{{ route('admin.subjects.reset-default') }}" style="background-color: #28a745; color: white; margin-left: 10px;">Reset to Default Subjects</button>
          </div>

          <!-- Display the existing subjects -->
          <ul class="subject-list">
            @foreach ($subjects as $subject)
              <li>
                <div class="subject-info">
                  <div class="subject-name">
                    @if($subject->is_default)
                      <span style="color: #7a222b; font-weight: bold;">⭐ {{ $subject->name }}</span>
                    @else
                      <span>{{ $subject->name }}</span>
                    @endif
                  </div>
                  <div class="subject-meta">
                    <span class="subject-code">{{ $subject->code }}</span>
                    @if($subject->is_default)
                      <span class="subject-badge core-badge">Core Subject</span>
                    @else
                      <span class="subject-badge custom-badge">Custom</span>
                    @endif
                  </div>
                </div>
                <button class="btn delete-btn" onclick="showDeleteConfirmation('{{ $subject->id }}', '{{ $subject->name }}')">Delete</button>
              </li>
            @endforeach
          </ul>
          
        </div>
      </div>

      <!-- Overlay -->
      <div id="overlay"></div>

      <!-- Add Subject Form (Hidden by default) -->
      <div id="add-subject-form">
          <button type="button" id="close-modal-btn">&times;</button>
          <form action="{{ route('admin.subjects.store') }}" method="POST">
              @csrf
              <div>
                <label for="code">Subject Code:</label>
                <input type="text" name="code" id="code" required maxlength="10" pattern="[A-Z0-9\-]+" title="Only uppercase letters, numbers, and hyphens allowed (max 10 characters)">
                <small style="display: block; color: #666; margin-top: 5px;">
                    *Only uppercase letters, numbers, and hyphens (max 10 characters)
                </small>
            </div>
              <div>
                  <label for="name">Subject Name:</label>
                  <input type="text" name="name" id="name" required maxlength="255" pattern="[a-zA-Z0-9\s\-\.]+" title="Only letters, numbers, spaces, hyphens, and periods allowed">
                  <small style="display: block; color: #666; margin-top: 5px;">
                      *Only letters, numbers, spaces, hyphens, and periods allowed
                  </small>
              </div>
              <div>
                  <label for="is_default">
                      <input type="checkbox" name="is_default" id="is_default" value="1">
                      Mark as Core Subject (Default)
                  </label>
                  <small style="display: block; color: #666; margin-top: 5px;">
                      Core subjects are automatically assigned to all students
                  </small>
              </div>
              <button type="submit" class="btn">Add Subject</button>
              <button type="button" id="cancel-btn" class="btn">Cancel</button>
          </form>
      </div>

      <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
            <button class="cancel-btn" onclick="closeModal()">No</button>
        </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div id="delete-modal" class="modal">
        <div class="modal-content">
            <p id="delete-message">Are you sure you want to delete this subject?</p>
            <button class="confirm-btn" onclick="confirmDelete()">Yes, Delete</button>
            <button class="cancel-btn" onclick="closeDeleteModal()">No</button>
        </div>
      </div>
@endsection
  @if(session('success'))
      <div class="alert alert-success" id="success-alert">
          <button class="alert-close" onclick="closeAlert('success-alert')">&times;</button>
          <strong>Success!</strong> {!! htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8') !!}
      </div>
  @endif

  @if(session('error'))
      <div class="alert alert-error" id="error-alert">
          <button class="alert-close" onclick="closeAlert('error-alert')">&times;</button>
          <strong>Error!</strong> {!! htmlspecialchars(session('error'), ENT_QUOTES, 'UTF-8') !!}
      </div>
  @endif


@push('scripts')
  <script>
    function toggleSubMenu(event) {
        event.preventDefault();
        const submenu = event.target.nextElementSibling;
        submenu.classList.toggle('hidden');
      }

    // Auto-hide notifications after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        
        if (successAlert) {
            setTimeout(function() {
                closeAlert('success-alert');
            }, 5000); // Hide after 5 seconds
        }
        
        if (errorAlert) {
            setTimeout(function() {
                closeAlert('error-alert');
            }, 7000); // Hide error alerts after 7 seconds (longer for errors)
        }
    });

    // Function to close alert notification
    function closeAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            alert.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }
    }

    // Enhanced form validation similar to siblings field security
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');
        const nameInput = document.getElementById('name');
        
        // Security: Sanitize text content to prevent XSS
        function sanitizeText(text) {
            if (typeof text !== 'string') return '';
            return text.replace(/[<>\"'&]/g, function(match) {
                const escapeMap = {
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#x27;',
                    '&': '&amp;'
                };
                return escapeMap[match];
            });
        }
        
        // Security: Validate and sanitize input
        function validateAndSanitizeInput(input, pattern, maxLength, errorMessage) {
            if (!input || typeof input.value !== 'string') return false;
            
            let value = input.value;
            
            // Remove any invalid characters based on pattern
            if (pattern === 'code') {
                value = value.replace(/[^A-Z0-9\-]/g, '').toUpperCase();
            } else if (pattern === 'name') {
                value = value.replace(/[^a-zA-Z0-9\s\-\.]/g, '');
            }
            
            // Enforce max length
            if (value.length > maxLength) {
                value = value.slice(0, maxLength);
            }
            
            input.value = value;
            return value;
        }
        
        // Subject Code validation
        if (codeInput) {
            codeInput.addEventListener('input', function() {
                const span = this.parentElement.querySelector('small');
                const value = validateAndSanitizeInput(this, 'code', 10, 'code');
                
                if (value && !/^[A-Z0-9\-]+$/.test(value)) {
                    this.style.borderColor = '#dc3545';
                    if (span) {
                        span.style.color = '#dc3545';
                        span.textContent = sanitizeText('*Invalid - Only uppercase letters, numbers, and hyphens allowed');
                    }
                } else if (value) {
                    this.style.borderColor = '#28a745';
                    if (span) {
                        span.style.color = '#28a745';
                        span.textContent = sanitizeText('*Valid - Only uppercase letters, numbers, and hyphens (max 10 characters)');
                    }
                } else {
                    this.style.borderColor = '';
                    if (span) {
                        span.style.color = '#666';
                        span.textContent = sanitizeText('*Only uppercase letters, numbers, and hyphens (max 10 characters)');
                    }
                }
            });
        }
        
        // Subject Name validation
        if (nameInput) {
            nameInput.addEventListener('input', function() {
                const span = this.parentElement.querySelector('small');
                const value = validateAndSanitizeInput(this, 'name', 255, 'name');
                
                if (value && !/^[a-zA-Z0-9\s\-\.]+$/.test(value)) {
                    this.style.borderColor = '#dc3545';
                    if (span) {
                        span.style.color = '#dc3545';
                        span.textContent = sanitizeText('*Invalid - Only letters, numbers, spaces, hyphens, and periods allowed');
                    }
                } else if (value) {
                    this.style.borderColor = '#28a745';
                    if (span) {
                        span.style.color = '#28a745';
                        span.textContent = sanitizeText('*Valid - Only letters, numbers, spaces, hyphens, and periods allowed');
                    }
                } else {
                    this.style.borderColor = '';
                    if (span) {
                        span.style.color = '#666';
                        span.textContent = sanitizeText('*Only letters, numbers, spaces, hyphens, and periods allowed');
                    }
                }
            });
        }
    });

    // Delete Modal Functions
    let deleteSubjectId = null;

    function showDeleteConfirmation(subjectId, subjectName) {
      deleteSubjectId = subjectId;
      const message = document.getElementById('delete-message');
      if (message) {
        message.textContent = `Are you sure you want to delete "${subjectName}"?`;
      }
      const modal = document.getElementById('delete-modal');
      if (modal) {
        modal.style.display = 'flex';
      }
    }

    function confirmDelete() {
      if (deleteSubjectId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/subjects/${deleteSubjectId}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
      }
      closeDeleteModal();
    }

    function closeDeleteModal() {
      const modal = document.getElementById('delete-modal');
      if (modal) {
        modal.style.display = 'none';
      }
      deleteSubjectId = null;
    }

    function closeModal() {
      const modal = document.getElementById('confirm-modal');
      if (modal) {
        modal.style.display = 'none';
      }
    }
  </script>
  <script src="{{ asset('js/script_admin_subjects.js') }}?v={{ time() }}"></script>
  <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush

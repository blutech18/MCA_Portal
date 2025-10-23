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
      <div id="add-subject-form" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 550px; max-width: 90vw; background: white; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15); z-index: 1001; max-height: 90vh; overflow-y: auto;">
          <!-- Header -->
          <div style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 24px; border-radius: 12px 12px 0 0; position: relative;">
            <div style="display: flex; align-items: center; gap: 16px;">
              <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                  <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px;">Add New Subject</h3>
                <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">Create a new subject for the curriculum</p>
              </div>
            </div>
            <button type="button" id="close-modal-btn" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; backdrop-filter: blur(10px); font-size: 24px; line-height: 1;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">&times;</button>
          </div>
          
          <!-- Form Body -->
          <form action="{{ route('admin.subjects.store') }}" method="POST" style="padding: 24px;">
              @csrf
              <div style="margin-bottom: 20px;">
                <label for="code" style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-weight: 600; color: #495057; font-size: 13px;">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
                    <polyline points="16 18 22 12 16 6"></polyline>
                    <polyline points="8 6 2 12 8 18"></polyline>
                  </svg>
                  Subject Code
                </label>
                <input type="text" name="code" id="code" required maxlength="10" pattern="[A-Z0-9\-]+" title="Only uppercase letters, numbers, and hyphens allowed (max 10 characters)" placeholder="e.g., MATH-101" style="width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; transition: all 0.2s ease; background-color: #fff; box-sizing: border-box;" onfocus="this.style.borderColor='#7a222b'; this.style.boxShadow='0 0 0 3px rgba(122,34,43,0.1)'" onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                <small style="display: block; color: #6c757d; font-size: 11px; margin-top: 6px; font-style: italic;">
                    Only uppercase letters, numbers, and hyphens (max 10 characters)
                </small>
            </div>
              <div style="margin-bottom: 20px;">
                  <label for="name" style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-weight: 600; color: #495057; font-size: 13px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
                      <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                      <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    Subject Name
                  </label>
                  <input type="text" name="name" id="name" required maxlength="255" pattern="[a-zA-Z0-9\s\-\.]+" title="Only letters, numbers, spaces, hyphens, and periods allowed" placeholder="e.g., Mathematics" style="width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; transition: all 0.2s ease; background-color: #fff; box-sizing: border-box;" onfocus="this.style.borderColor='#7a222b'; this.style.boxShadow='0 0 0 3px rgba(122,34,43,0.1)'" onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
                  <small style="display: block; color: #6c757d; font-size: 11px; margin-top: 6px; font-style: italic;">
                      Only letters, numbers, spaces, hyphens, and periods allowed
                  </small>
              </div>
              <div style="margin-bottom: 24px; padding: 14px; background: #f8f9fa; border-radius: 6px; border-left: 3px solid #7a222b;">
                  <label for="is_default" style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 500; color: #495057;">
                      <input type="checkbox" name="is_default" id="is_default" value="1" style="width: 18px; height: 18px; cursor: pointer; accent-color: #7a222b;">
                      <span>Mark as Core Subject (Default)</span>
                  </label>
                  <small style="display: block; color: #6c757d; font-size: 11px; margin-top: 8px; margin-left: 28px; font-style: italic;">
                      Core subjects are automatically assigned to all students
                  </small>
              </div>
              
              <!-- Footer Buttons -->
              <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 16px; border-top: 1px solid #dee2e6;">
                <button type="button" id="cancel-btn" style="background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                  Cancel
                </button>
                <button type="submit" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; border: none; padding: 10px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(122,34,43,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(122,34,43,0.2)'">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Add Subject
                </button>
              </div>
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

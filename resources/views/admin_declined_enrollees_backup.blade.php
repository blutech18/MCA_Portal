@extends('layouts.admin_base')

@section('title', 'Admin - Declined Enrollees')
@section('header', 'Declined Enrollees')

@push('head')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_dashboard.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_users.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/styles_enrollees.css') }}">
  <style>
    /* Assessment Information Styling */
    .strand-info {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .selected-strand {
      font-weight: 600;
      color: #2c3e50;
    }

    .assessment-info {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 12px;
    }

    .assessment-recommendation {
      background: #e8f4fd;
      color: #2980b9;
      padding: 2px 6px;
      border-radius: 4px;
      border: 1px solid #bdc3c7;
    }

    .strand-override {
      color: #e74c3c;
      font-weight: bold;
      cursor: help;
    }

    .strand-match {
      color: #27ae60;
      font-weight: bold;
      cursor: help;
    }

    .strand-cell {
      min-width: 120px;
    }

    /* Tooltip styles for better UX */
    [title] {
      cursor: help;
    }
    /* Enhanced table cards (match enrollees page) */
    .strand-box { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:8px 14px; }
    .strand-box .table-container { max-height: 420px; overflow:auto; }
    .strand-box table { width:100%; border-collapse:collapse; table-layout:fixed; }
    .strand-box thead th { position:sticky; top:0; background:#f9fafb; color:#111; padding:10px 12px; border-bottom:1px solid #e5e7eb; text-align:left; font-size:12px; }
    .strand-box tbody td { padding:8px 10px; border-bottom:1px solid #f3f4f6; font-size:13px; word-wrap:break-word; overflow-wrap:anywhere; }
    .strand-box tbody tr:hover { background:#f9fafb; }
    .strand-box .courses-list { display:flex; align-items:center; justify-content:space-between; gap:12px; padding-bottom:8px; border-bottom:1px solid #e5e7eb; margin-bottom:10px; }
    .strand-box .courses-list h2 { margin:0; font-size:18px; font-weight:600; color:#111827; }
    .strand-box .courses-list .search-bar2 { margin-left:auto; max-width:260px; width:100%; padding:8px 10px; border:1px solid #e5e7eb; border-radius:6px; }
    /* Formal spacing between tables */
    #old-enrollees-section { margin-top:20px; }
    
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
        
          <div class="container-classes">
            <div class="strand-box" style="display:none">
              <div class="courses-list mb-4 flex justify-between items-center" style="display:none">
                <h2>Declined Applications</h2>
              </div>

              <div id="enrollee-modal"
                style="position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.75); z-index: 9999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                <div style="width: 90%; max-width: 900px; max-height: 90vh; overflow: hidden;">
                  <div id="enrollee-modal-content"></div>
                </div>
              </div>
            </div>
          </div>

          <div id="new-enrollees-section" class="container-classes">
            <div class="strand-box">
              <div class="courses-list">
                <h2>Declined New Student Enrollees</h2>
                <input type="text" id="instructor-search" class="search-bar2" placeholder="Search new enrollees…">
              </div>
        
              <div class="table-container">
                <table class="enrollees-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>LRN No.</th>
                      <th>Contact</th>
                      <th>Email</th>
                      <th>Previous Grade</th>
                      <th>Strand / Assessment</th>
                      <th>Status</th>
                      <th>Decline Reason</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($newEnrollees as $e)
                    <tr>
                      <td class="name-cell">{{ $e->display_name }}</td>
                      <td>{{ $e->lrn ?? '–' }}</td>
                      <td>{{ $e->contact_no }}</td>
                      <td class="email-cell">{{ $e->email }}</td>
                      <td>
                        @if($e->shs_grade)
                            {{ $e->shs_grade }}
                        @else
                            {{ $e->previous_grade }}
                        @endif
                      </td>
                      <td class="strand-cell">
                        @if($e->strand)
                          <div class="strand-info">
                            <span class="selected-strand">{{ $e->strand }}</span>
                            @if($e->assessmentResult)
                              <div class="assessment-info">
                                <span class="assessment-recommendation" title="Assessment Recommended: {{ $e->assessmentResult->recommended_strand }}">
                                  📊 {{ $e->assessmentResult->recommended_strand }}
                                </span>
                                @if($e->strand !== $e->assessmentResult->recommended_strand)
                                  <span class="strand-override" title="Student chose different strand than recommended">⚠️</span>
                                @else
                                  <span class="strand-match" title="Student followed assessment recommendation">✅</span>
                                @endif
                              </div>
                            @endif
                          </div>
                        @else
                          –
                        @endif
                      </td>
                      <td>
                        <span class="status-badge status-{{ $e->status ?? 'pending' }}">
                          {{ ucfirst($e->status ?? 'pending') }}
                        </span>
                      </td>
                      <td class="decline-reason-cell">
                        @php
                          $reason = $e->decline_reason ?? '';
                          // Extract only the dropdown reason (before the ' - ' separator)
                          $dropdownReason = explode(' - ', $reason)[0];
                        @endphp
                        {{ $dropdownReason ?: '–' }}
                      </td>
                      <td class="actions-cell">
                        <div class="action-buttons">
                          <button
                            type="button"
                            data-url="{{ route('admin.enrollee.new.modal', $e->id) }}"
                            class="btn view-btn"
                            title="View Details"
                          >Info</button>
                          <button 
                            type="button" 
                            class="btn delete-btn" 
                            title="Delete Enrollee"
                            data-enrollee-id="{{ $e->id }}"
                            data-enrollee-name="{{ $e->display_name }}"
                            data-enrollee-type="new"
                            onclick="handleDeleteClick(this)"
                          >
                            Delete
                          </button>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div id="old-enrollees-section" class="container-classes">
            <div class="strand-box">
              <div class="courses-list">
                <h2>Declined Old Student Enrollees</h2>
                <input type="text" id="old-enrollee-search" class="search-bar2" placeholder="Search old enrollees…">
              </div>

              <div class="table-container">
                <table class="enrollees-table">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>LRN</th>
                      <th>Applying Grade</th>
                      <th>Status</th>
                      <th>Decline Reason</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($oldEnrollees as $e)
                      <tr>
                        <td>{{ $e->student_id }}</td>
                        <td class="name-cell">{{ $e->display_name }}</td>
                        <td>{{ $e->lrn }}</td>
                        <td>{{ $e->grade_level_applying ?? '–' }}</td>
                        <td>
                          <span class="status-badge status-{{ $e->status ?? 'pending' }}">
                            {{ ucfirst($e->status ?? 'pending') }}
                          </span>
                        </td>
                        <td class="decline-reason-cell">
                          @php
                            $reason = $e->decline_reason ?? '';
                            // Extract only the dropdown reason (before the ' - ' separator)
                            $dropdownReason = explode(' - ', $reason)[0];
                          @endphp
                          {{ $dropdownReason ?: '–' }}
                        </td>
                        <td class="actions-cell">
                          <div class="action-buttons">
                            <button
                              type="button"
                              data-url="{{ route('admin.enrollee.old.modal', $e->id) }}"
                              class="btn view-btn"
                              title="View Details"
                            >
                              Info
                            </button>
                            <button 
                              type="button" 
                              class="btn delete-btn" 
                              title="Delete Enrollee"
                              data-enrollee-id="{{ $e->id }}"
                              data-enrollee-name="{{ $e->display_name }}"
                              data-enrollee-type="old"
                              onclick="handleDeleteClick(this)"
                            >
                              Delete
                            </button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center py-4">No declined old-student enrollees yet.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

            </div>
          </div>

@endsection

    <script>
      // Clean consolidated JavaScript for declined enrollees page
      document.addEventListener('DOMContentLoaded', function() {
        console.log('Declined enrollees page loaded');
        
        // Auto-hide flash messages after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
          setTimeout(() => {
            if (alert && alert.parentNode) {
              alert.style.transition = 'opacity 0.5s ease';
              alert.style.opacity = '0';
              setTimeout(() => {
                alert.remove();
              }, 500);
            }
          }, 5000);
        });

        // Search functionality for new enrollees
        const newSearchInput = document.getElementById('instructor-search');
        if (newSearchInput) {
          newSearchInput.addEventListener('keyup', function(){
            const term = this.value.toLowerCase();
            const newSection = document.getElementById('new-enrollees-section');
            if (newSection && !newSection.classList.contains('hidden')) {
              const rows = newSection.querySelectorAll('.enrollee-table tbody tr');
              rows.forEach(row => {
                if (row.textContent) {
                  row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
                }
              });
            }
          });
        }

        // Search functionality for old enrollees
        const oldSearchInput = document.getElementById('old-enrollee-search');
        if (oldSearchInput) {
          oldSearchInput.addEventListener('keyup', function(){
            const term = this.value.toLowerCase();
            const oldSection = document.getElementById('old-enrollees-section');
            if (oldSection && !oldSection.classList.contains('hidden')) {
              const rows = oldSection.querySelectorAll('.enrollee-table tbody tr');
              rows.forEach(row => {
                if (row.textContent) {
                  row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
                }
              });
            }
          });
        }

        // View button functionality
        const viewButtons = document.querySelectorAll('.view-btn');
        viewButtons.forEach(btn => {
          btn.addEventListener('click', async e => {
            e.preventDefault();
            const url = btn.dataset.url;
            console.log('Opening modal, fetching', url);

            try {
              const res = await fetch(url);
              if (!res.ok) {
                const contentType = res.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                  const errorData = await res.json();
                  throw new Error(errorData.message || errorData.error || `HTTP ${res.status}`);
                } else {
                  throw new Error(`HTTP ${res.status}`);
                }
              }
              
              const data = await res.json();
              console.log('Modal data received:', data);

              // Populate the modal with null checks
              const modalTitle = document.getElementById('modal-title');
              const modalContent = document.getElementById('modal-content');
              const modal = document.getElementById('enrollee-modal');
              
              if (modalTitle) {
                modalTitle.textContent = data.title || 'Enrollee Details';
              }
              if (modalContent) {
                modalContent.innerHTML = data.content || 'No content available';
              }
              if (modal) {
                modal.style.display = 'flex';
              }
              
            } catch (error) {
              console.error('Error fetching enrollee data:', error);
              alert('Error loading enrollee details: ' + error.message);
            }
          });
        });

        // Close modal functionality
        const closeModalBtn = document.getElementById('close-modal');
        if (closeModalBtn) {
          closeModalBtn.addEventListener('click', () => {
            const modal = document.getElementById('enrollee-modal');
            if (modal) {
              modal.style.display = 'none';
            }
          });
        }

        // Close modal when clicking outside
        const modal = document.getElementById('enrollee-modal');
        if (modal) {
          modal.addEventListener('click', (e) => {
            if (e.target === modal) {
              modal.style.display = 'none';
            }
          });
        }

        // Grade filter functionality
        const filter = document.getElementById('grade-filter');
        if (filter) {
          filter.addEventListener('change', function () {
            const newSection = document.getElementById('new-enrollees-section');
            const oldSection = document.getElementById('old-enrollees-section');
            
            if (this.value === 'new') {
              if (newSection) newSection.classList.remove('hidden');
              if (oldSection) oldSection.classList.add('hidden');
            } else if (this.value === 'old') {
              if (newSection) newSection.classList.add('hidden');
              if (oldSection) oldSection.classList.remove('hidden');
            } else {
              if (newSection) newSection.classList.remove('hidden');
              if (oldSection) oldSection.classList.remove('hidden');
            }
          });
        }
      });

      // Enhanced delete confirmation
      function confirmDelete(enrolleeName, enrolleeType) {
        console.log('Delete confirmation requested for:', enrolleeName, enrolleeType);
        // Store the delete information for the modal
        window.pendingDelete = { name: enrolleeName, type: enrolleeType };
        
        // Show the delete confirmation modal
        const modal = document.getElementById('delete-modal');
        if (modal) {
          const message = document.getElementById('delete-message');
          if (message) {
            message.innerHTML = `Are you sure you want to delete <strong>${enrolleeName}</strong>?<br><br>This action will permanently remove the ${enrolleeType} enrollee and all associated files from the database.<br><br><strong>This action cannot be undone.</strong>`;
          }
          modal.style.display = 'flex';
        }
        return false; // Prevent form submission, modal will handle it
      }

      // Handle delete button click using data attributes
      function handleDeleteClick(button) {
        const enrolleeName = button.getAttribute('data-enrollee-name');
        const enrolleeType = button.getAttribute('data-enrollee-type');
        
        if (enrolleeName && enrolleeType) {
          return confirmDelete(enrolleeName, enrolleeType);
        }
        return false;
      }

      // Delete Modal Functions
      function confirmDeleteAction() {
        if (window.pendingDelete) {
          // Find the delete form and submit it
          const deleteForms = document.querySelectorAll('form[action*="/admin/"][action*="/enrollees/"][action*="DELETE"]');
          deleteForms.forEach(form => {
            const enrolleeId = form.action.match(/\/enrollees\/(\d+)/);
            if (enrolleeId) {
              form.submit();
              return;
            }
          });
        }
        closeDeleteModal();
      }

      function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        if (modal) {
          modal.style.display = 'none';
        }
        window.pendingDelete = null;
      }

      function closeModal() {
        const modal = document.getElementById('confirm-modal');
        if (modal) {
          modal.style.display = 'none';
        }
      }

      function logout(event) {
        event.preventDefault();
        const form = document.getElementById('logout-form');
        if (form) {
          form.submit();
        }
      }
    </script>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p id="delete-message">Are you sure you want to delete this enrollee?</p>
        <button class="confirm-btn" onclick="confirmDeleteAction()">Yes, Delete</button>
        <button class="cancel-btn" onclick="closeDeleteModal()">No</button>
      </div>
    </div>
        }
        
        // Call the appropriate delete function
        if (enrolleeType === 'old') {
          console.log('Calling deleteOldEnrollee with validated data');
          deleteOldEnrollee(enrolleeId, enrolleeName);
        } else if (enrolleeType === 'new') {
          console.log('Calling deleteNewEnrollee with validated data');
          deleteNewEnrollee(enrolleeId, enrolleeName);
        } else {
          console.error('Unknown enrollee type:', enrolleeType);
          alert('❌ Error: Unknown enrollee type');
        }
      }

      // AJAX delete function for new enrollees
      function deleteNewEnrollee(enrolleeId, enrolleeName) {
        console.log('Delete new enrollee requested:', enrolleeId, enrolleeName);
        
        if (!confirmDelete(enrolleeName, 'new student')) {
          console.log('Delete cancelled by user');
          return;
        }

        console.log('Proceeding with delete for new enrollee:', enrolleeId);
        
        const deleteUrl = `/admin/enrollees/${enrolleeId}`;
        console.log('Delete URL:', deleteUrl);
        
        fetch(deleteUrl, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => {
          console.log('Delete response status:', response.status);
          if (response.ok) {
            return response.text();
          } else {
            throw new Error('Delete failed with status: ' + response.status);
          }
        })
        .then(data => {
          console.log('Delete successful, response:', data);
          alert('✅ New student enrollee deleted successfully!');
          removeEnrolleeRow(enrolleeId);
        })
        .catch(error => {
          console.error('Delete error:', error);
          alert('❌ Failed to delete enrollee: ' + error.message);
        });
      }

      // AJAX delete function for old enrollees
      function deleteOldEnrollee(enrolleeId, enrolleeName) {
        console.log('=== DELETE OLD ENROLLEE DEBUG ===');
        console.log('Function called with parameters:');
        console.log('enrolleeId:', enrolleeId, 'Type:', typeof enrolleeId);
        console.log('enrolleeName:', enrolleeName, 'Type:', typeof enrolleeName);
        
        if (!enrolleeId || enrolleeId === 'undefined' || enrolleeId === 'null' || enrolleeId === '') {
          console.error('Invalid enrolleeId:', enrolleeId);
          alert('❌ Error: Invalid enrollee ID - ' + enrolleeId);
          return;
        }
        
        enrolleeId = String(enrolleeId).trim();
        console.log('Processed enrolleeId:', enrolleeId);
        
        if (!confirmDelete(enrolleeName, 'old student')) {
          console.log('Delete cancelled by user');
          return;
        }

        console.log('Proceeding with delete for old enrollee:', enrolleeId);
        
        if (!enrolleeId || enrolleeId === 'undefined' || enrolleeId === 'null') {
          console.error('enrolleeId is still invalid after processing:', enrolleeId);
          alert('❌ Error: Cannot construct delete URL - invalid ID');
          return;
        }
        
        const deleteUrl = `/admin/admin/old-enrollees/${enrolleeId}`;
        console.log('Constructed URL:', deleteUrl);
        console.log('URL components:');
        console.log('- Base:', '/admin/admin/old-enrollees/');
        console.log('- ID:', enrolleeId);
        console.log('- Full URL:', deleteUrl);
        
        if (deleteUrl === '/admin/admin/old-enrollees/undefined' || deleteUrl === '/admin/admin/old-enrollees/null' || deleteUrl === '/admin/admin/old-enrollees/') {
          console.error('Invalid URL constructed:', deleteUrl);
          alert('❌ Error: Invalid delete URL - ' + deleteUrl);
          return;
        }
        
        console.log('About to make fetch request to URL:', deleteUrl);
        console.log('URL variable type:', typeof deleteUrl);
        console.log('URL variable value:', deleteUrl);
        console.log('URL length:', deleteUrl.length);
        
        fetch(deleteUrl, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => {
          console.log('Delete response status:', response.status);
          if (response.ok) {
            return response.text();
          } else {
            throw new Error('Delete failed with status: ' + response.status);
          }
        })
        .then(data => {
          console.log('Delete successful, response:', data);
          alert('✅ Old student enrollee deleted successfully!');
          removeEnrolleeRow(enrolleeId);
        })
        .catch(error => {
          console.error('Delete error:', error);
          alert('❌ Failed to delete enrollee: ' + error.message);
        });
      }

      // Remove enrollee row from table
      function removeEnrolleeRow(enrolleeId) {
        console.log('Removing enrollee row:', enrolleeId);
        
        const tableRows = document.querySelectorAll('.enrollee-table tbody tr');
        let found = false;
        
        tableRows.forEach(row => {
          const deleteBtn = row.querySelector(`button[onclick*="deleteNewEnrollee(${enrolleeId}"]`) || 
                           row.querySelector(`button[onclick*="deleteOldEnrollee(${enrolleeId}"]`) ||
                           row.querySelector(`button[data-enrollee-id="${enrolleeId}"]`);
          
          if (deleteBtn) {
            console.log('Found row to remove:', row);
            found = true;
            row.style.transition = 'opacity 0.3s ease';
            row.style.opacity = '0';
            setTimeout(() => {
              row.remove();
              console.log('Row removed successfully');
            }, 300);
          }
        });
        
        if (!found) {
          console.log('Row not found for enrollee ID:', enrolleeId);
          setTimeout(() => {
            location.reload();
          }, 1000);
        }
      }
    </script>

    
    
    <script>
      function toggleSubMenu(event) {
          event.preventDefault();
          const submenu = event.target.nextElementSibling;
          submenu.classList.toggle('hidden');
        }
    </script>

    <script>

      document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.view-btn').forEach(btn => {
          btn.addEventListener('click', async e => {
            e.preventDefault();
            const url = btn.dataset.url;
            console.log('Opening modal, fetching', url);

            try {
              const res  = await fetch(url);
              if (!res.ok) {
                // Check if it's a JSON error response
                const contentType = res.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                  const errorData = await res.json();
                  throw new Error(errorData.message || errorData.error || `HTTP ${res.status}`);
                } else {
                  throw new Error(`HTTP ${res.status}`);
                }
              }
              
              const html = await res.text();

              const modal   = document.getElementById('enrollee-modal');
              const content = document.getElementById('enrollee-modal-content');

              content.innerHTML = html;

              // show the modal
              modal.style.display = 'flex';

              // close handlers
              const closeBtn = content.querySelector('.modal-close');
              if (closeBtn) {
                closeBtn.onclick = () => {
                  modal.style.display = 'none';
                  content.innerHTML = '';
                };
              }
              modal.onclick = ev => {
                if (ev.target === modal) {
                  modal.style.display = 'none';
                  content.innerHTML = '';
                }
              };
            } catch (err) {
              console.error('Modal fetch failed:', err);
              alert('Could not load enrollee details: ' + err.message);
            }
          });
        });

        const filter = document.getElementById('enrollee-filter');
        const newSection = document.getElementById('new-enrollees-section');
        const oldSection = document.getElementById('old-enrollees-section');

        filter.addEventListener('change', function () {
          if (this.value === 'new') {
            newSection.classList.remove('hidden');
            oldSection.classList.add('hidden');
          } else {
            oldSection.classList.remove('hidden');
            newSection.classList.add('hidden');
          }
        });
      });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js?v=1759179376"></script>

    <script>
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

      // Toggle enrollee lists function (expose globally for inline onchange)
      window.toggleEnrolleeLists = function(value) {
        const newSection = document.getElementById('new-enrollees-section');
        const oldSection = document.getElementById('old-enrollees-section');
        
        if (value === 'new') {
          if (newSection) newSection.classList.remove('hidden');
          if (oldSection) oldSection.classList.add('hidden');
        } else if (value === 'old') {
          if (newSection) newSection.classList.add('hidden');
          if (oldSection) oldSection.classList.remove('hidden');
        }
      }

    </script>

    <!-- Logout functionality is handled by logout.js -->

    <!-- Logout Modal -->
    <div id="confirm-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>

    <!-- Debug script -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        console.log("=== DEBUG: Admin Declined Enrollees Page ===");
        
        // Check if settings elements exist
        const settingsToggle = document.getElementById('settingsToggle');
        const settingsMenu = document.getElementById('settingsMenu');
        const confirmModal = document.getElementById('confirm-modal');
        const logoutForm = document.getElementById('logout-form');
        
        console.log("Settings Toggle exists:", !!settingsToggle);
        console.log("Settings Menu exists:", !!settingsMenu);
        console.log("Confirm Modal exists:", !!confirmModal);
        console.log("Logout Form exists:", !!logoutForm);
        
        // Check if logout.js functions are loaded
        console.log("confirmExit function exists:", typeof confirmExit !== 'undefined');
        console.log("closeModal function exists:", typeof closeModal !== 'undefined');
        console.log("logout function exists:", typeof logout !== 'undefined');
        
        // Add event listener to settings toggle for debugging
        if (settingsToggle) {
          settingsToggle.addEventListener('click', function() {
            console.log("Settings toggle clicked");
          });
        }
        
        console.log("=== DEBUG END ===");
      });

      // Delete Modal Functions
      function confirmDeleteAction() {
        if (window.pendingDelete) {
          // Find the delete form and submit it
          const deleteForms = document.querySelectorAll('form[action*="/admin/"][action*="/enrollees/"][action*="DELETE"]');
          deleteForms.forEach(form => {
            const formData = new FormData(form);
            const enrolleeId = form.action.match(/\/enrollees\/(\d+)/);
            if (enrolleeId) {
              form.submit();
              return;
            }
          });
        }
        closeDeleteModal();
      }

      function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        if (modal) {
          modal.style.display = 'none';
        }
        window.pendingDelete = null;
      }

      function closeModal() {
        const modal = document.getElementById('confirm-modal');
        if (modal) {
          modal.style.display = 'none';
        }
      }
    </script>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p id="delete-message">Are you sure you want to delete this enrollee?</p>
        <button class="confirm-btn" onclick="confirmDeleteAction()">Yes, Delete</button>
        <button class="cancel-btn" onclick="closeDeleteModal()">No</button>
      </div>
    </div>

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
      font-size: 0.85em;
      color: #666;
      margin-top: 4px;
    }

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
  <div class="declined-enrollees-page">
    <!-- Success/Error Notifications -->
    @if(session('success'))
      <div class="alert alert-success" id="success-alert">
        <button class="alert-close" onclick="closeAlert('success-alert')">&times;</button>
        <strong>Success!</strong> {!! htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8') !!}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger" id="error-alert">
        <button class="alert-close" onclick="closeAlert('error-alert')">&times;</button>
        <strong>Error!</strong> {!! htmlspecialchars(session('error'), ENT_QUOTES, 'UTF-8') !!}
      </div>
    @endif

    <!-- Grade Filter -->
    <div class="filter-controls" style="margin-bottom: 20px;">
      <select id="grade-filter" class="form-control" style="width: 200px; display: inline-block;">
        <option value="">All Grades</option>
        <option value="new">New Student Enrollees</option>
        <option value="old">Old Student Enrollees</option>
      </select>
    </div>

    <!-- New Enrollees Section -->
    <div id="new-enrollees-section" class="strand-box">
      <div class="courses-list">
        <h3>Declined New Student Enrollees</h3>
        <div class="search-control">
          <input type="text" id="instructor-search" placeholder="Search enrollees..." class="search-bar">
        </div>
      </div>
      
      <div class="table-container">
        <table class="enrollees-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Strand</th>
              <th>Grade Level</th>
              <th>Assessment Score</th>
              <th>Payment Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($new_enrollees as $e)
              <tr data-enrollee-id="{{ $e->id }}" data-enrollee-name="{{ $e->display_name }}" data-enrollee-type="new">
                <td>{{ $e->display_name }}</td>
                <td>{{ $e->email }}</td>
                <td>{{ $e->phone_number }}</td>
                <td>
                  <div class="strand-info">
                    <span class="selected-strand">{{ $e->selected_strand }}</span>
                    <div class="assessment-info">
                      Assessment: {{ $e->assessment_score ?? 'N/A' }}
                    </div>
                  </div>
                </td>
                <td>{{ $e->grade_level }}</td>
                <td>{{ $e->assessment_score ?? 'N/A' }}</td>
                <td>
                  @if($e->payment_status === 'verified')
                    <span class="badge badge-success">Verified</span>
                  @elseif($e->payment_status === 'pending')
                    <span class="badge badge-warning">Pending</span>
                  @else
                    <span class="badge badge-secondary">{{ ucfirst($e->payment_status ?? 'Not Set') }}</span>
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="view-btn btn btn-info btn-sm" 
                            data-url="{{ route('admin.enrollees.view', $e->id) }}">
                      View
                    </button>
                    <button class="btn btn-danger btn-sm" 
                            data-enrollee-id="{{ $e->id }}"
                            data-enrollee-name="{{ $e->display_name }}"
                            data-enrollee-type="new"
                            onclick="handleDeleteClick(this)">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">No declined new student enrollees found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Old Enrollees Section -->
    <div id="old-enrollees-section" class="strand-box" style="margin-top: 20px;">
      <div class="courses-list">
        <h3>Declined Old Student Enrollees</h3>
        <div class="search-control">
          <input type="text" id="old-enrollee-search" placeholder="Search enrollees..." class="search-bar">
        </div>
      </div>
      
      <div class="table-container">
        <table class="enrollees-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Strand</th>
              <th>Grade Level</th>
              <th>Assessment Score</th>
              <th>Payment Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($old_enrollees as $e)
              <tr data-enrollee-id="{{ $e->id }}" data-enrollee-name="{{ $e->display_name }}" data-enrollee-type="old">
                <td>{{ $e->display_name }}</td>
                <td>{{ $e->email }}</td>
                <td>{{ $e->phone_number }}</td>
                <td>
                  <div class="strand-info">
                    <span class="selected-strand">{{ $e->selected_strand }}</span>
                    <div class="assessment-info">
                      Assessment: {{ $e->assessment_score ?? 'N/A' }}
                    </div>
                  </div>
                </td>
                <td>{{ $e->grade_level }}</td>
                <td>{{ $e->assessment_score ?? 'N/A' }}</td>
                <td>
                  @if($e->payment_status === 'verified')
                    <span class="badge badge-success">Verified</span>
                  @elseif($e->payment_status === 'pending')
                    <span class="badge badge-warning">Pending</span>
                  @else
                    <span class="badge badge-secondary">{{ ucfirst($e->payment_status ?? 'Not Set') }}</span>
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="view-btn btn btn-info btn-sm" 
                            data-url="{{ route('admin.enrollees.view', $e->id) }}">
                      View
                    </button>
                    <button class="btn btn-danger btn-sm" 
                            data-enrollee-id="{{ $e->id }}"
                            data-enrollee-name="{{ $e->display_name }}"
                            data-enrollee-type="old"
                            onclick="handleDeleteClick(this)">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">No declined old student enrollees found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Enrollee Details Modal -->
    <div id="enrollee-modal" class="modal" style="display: none;">
      <div class="modal-content" style="max-width: 800px; max-height: 80vh; overflow-y: auto;">
        <span id="close-modal" style="float: right; font-size: 24px; cursor: pointer;">&times;</span>
        <h2 id="modal-title">Enrollee Details</h2>
        <div id="modal-content"></div>
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
          const rows = newSection.querySelectorAll('.enrollees-table tbody tr');
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
          const rows = oldSection.querySelectorAll('.enrollees-table tbody tr');
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

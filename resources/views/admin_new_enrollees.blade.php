@extends('layouts.admin_base')

@section('title', 'Admin - Enrollees')
@section('header', 'Manage Enrollees')

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

    /* Filter Controls Styling */
    .filter-controls {
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .filter-controls label {
      font-weight: 600;
      color: #374151;
      margin: 0;
    }

    .filter-controls select {
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 8px 12px;
      background: white;
      font-size: 14px;
      min-width: 200px;
    }

    .filter-controls select:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Ensure proper spacing and positioning */
    .enrollees-page {
      padding: 0;
      margin: 0;
    }

    /* Remove any background or unwanted elements */
    .enrollees-page::before {
      content: none;
    }

    /* Hide any unwanted text that might appear */
    .enrollees-page > *:not(.filter-controls):not(.strand-box):not(.modal) {
      /* Ensure only expected elements are visible */
    }

    /* Ensure clean layout */
    .enrollees-page {
      position: relative;
    }

    /* Modal overlay styling */
    .modal-overlay {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-container {
      background: white;
      border-radius: 8px;
      max-width: 600px;
      width: 90%;
      max-height: 80vh;
      overflow-y: auto;
    }

    /* View modal specific styling */
    #view-modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    #view-content {
      background: white;
      border-radius: 8px;
      max-width: 95%;
      max-height: 95vh;
      overflow-y: auto;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #e5e7eb;
    }

    .modal-title {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
    }

    .modal-close-btn {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #6b7280;
    }

    .modal-body {
      padding: 20px;
    }

    .modal-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 20px;
    }

    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }

    .btn-secondary {
      background: #6b7280;
      color: white;
    }

    .btn-success {
      background: #10b981;
      color: white;
    }

    .btn-danger {
      background: #ef4444;
      color: white;
    }

    .btn-info {
      background: #3b82f6;
      color: white;
    }

    .btn-warning {
      background: #f59e0b;
      color: white;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
    }

    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #d1d5db;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 80px;
    }

    .action-buttons {
      display: flex;
      gap: 5px;
      flex-wrap: wrap;
    }

    .action-buttons .btn {
      padding: 4px 8px;
      font-size: 12px;
    }

    .status-badge {
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
      text-transform: uppercase;
    }

    .status-pending {
      background: #fef3c7;
      color: #92400e;
    }

    .status-accepted {
      background: #d1fae5;
      color: #065f46;
    }

    .status-declined {
      background: #fee2e2;
      color: #991b1b;
    }

    /* Document Viewer Modal Styles */
    .document-viewer-container {
      background: white;
      border-radius: 12px;
      max-width: 1200px;
      width: 90vw;
      height: 90vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    }

    .document-viewer-header {
      background: linear-gradient(135deg, #1f3f49, #2c5a6b);
      color: white;
      padding: 20px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 3px solid #f8d210;
    }

    .document-viewer-title {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .document-viewer-title svg {
      flex-shrink: 0;
    }

    .document-viewer-title h3 {
      margin: 0;
      font-size: 18px;
      font-weight: 700;
    }

    .document-viewer-title p {
      margin: 4px 0 0 0;
      font-size: 13px;
      opacity: 0.9;
    }

    .document-viewer-close {
      background: rgba(255, 255, 255, 0.2);
      border: 2px solid white;
      color: white;
      padding: 8px;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .document-viewer-close:hover {
      background: white;
      color: #1f3f49;
      transform: scale(1.1);
    }

    .document-viewer-body {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      padding: 0;
      background: #0f172a;
    }

    #document-viewer-content {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px;
    }

    #document-viewer-frame {
      width: 100%;
      height: 100%;
      border: none;
      background: #fff;
      border-radius: 8px;
    }

    #document-viewer-image {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      border-radius: 8px;
      background: #fff;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .document-viewer-footer {
      background: #f8f9fa;
      padding: 16px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-top: 1px solid #e5e7eb;
      gap: 16px;
    }

    .document-viewer-info {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: #6b7280;
    }

    .document-viewer-info svg {
      flex-shrink: 0;
      color: #10b981;
    }

    .document-viewer-actions {
      display: flex;
      gap: 10px;
    }

    @media (max-width: 768px) {
      .document-viewer-container {
        width: 95vw;
        height: 95vh;
      }

      .document-viewer-footer {
        flex-direction: column;
        gap: 12px;
      }

      .document-viewer-actions {
        width: 100%;
        flex-direction: column;
      }

      .document-viewer-actions button {
        width: 100%;
      }
    }
  </style>
@endpush

@section('content')
  <div class="enrollees-page">
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
    <div class="filter-controls">
      <label for="grade-filter">Filter Enrollees:</label>
      <select id="grade-filter">
        <option value="">All Enrollees</option>
        <option value="new">New Student Enrollees</option>
        <option value="old">Old Student Enrollees</option>
                  </select>
                    </div>
                    
    <!-- New Enrollees Section -->
    <div id="new-enrollees-section" class="strand-box">
      <div class="courses-list">
        <h3>New Student Enrollees</h3>
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
              <th>Contact</th>
              <th>LRN</th>
              <th>Strand</th>
              <th>Grade Level</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
            @forelse($newEnrollees as $e)
              <tr data-enrollee-id="{{ $e->id }}" data-enrollee-name="{{ $e->display_name }}" data-enrollee-type="new">
                <td>{{ $e->display_name }}</td>
                <td>{{ $e->email }}</td>
                      <td>{{ $e->contact_no }}</td>
                <td>{{ $e->lrn ?? '–' }}</td>
                <td>
                        @php
                          // Determine if student is JHS (grades 7-10)
                          $desiredGrade = $e->desired_grade ?? $e->previous_grade ?? 7;
                          $isJHS = ($desiredGrade >= 7 && $desiredGrade <= 10);
                        @endphp
                        @if($isJHS)
                          <div class="strand-info">
                            <span class="selected-strand">JHS</span>
                          </div>
                        @elseif($e->strand)
                          <div class="strand-info">
                            <span class="selected-strand">{{ $e->strand }}</span>
                            @if($e->assessmentResult)
                              <div class="assessment-info">
                          Assessment: {{ $e->assessmentResult->recommended_strand }}
                              </div>
                            @endif
                          </div>
                        @else
                          –
                        @endif
                      </td>
                <td>{{ $e->desired_grade ?? $e->previous_grade ?? '–' }}</td>
                      <td>
                        <span class="status-badge status-{{ $e->status ?? 'pending' }}">
                          {{ ucfirst($e->status ?? 'pending') }}
                        </span>
                      </td>
                <td>
                        <div class="action-buttons">
                    <button class="view-btn btn btn-info btn-sm" 
                            data-url="{{ route('admin.enrollee.new.modal', $e->id) }}">
                      View
                    </button>
                    @if($e->status !== 'accepted')
                      <button class="btn btn-success btn-sm accept-btn" 
                            data-enrollee-id="{{ $e->id }}"
                            data-enrollee-name="{{ $e->display_name }}"
                              data-enrollee-type="new">
                        Accept
                      </button>
                      <button class="btn btn-warning btn-sm decline-btn" 
                              data-enrollee-id="{{ $e->id }}"
                              data-enrollee-name="{{ $e->display_name }}"
                              data-enrollee-type="new">
                        Decline
                          </button>
                          @endif
                        </div>
                      </td>
                    </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">No new student enrollees found.</td>
              </tr>
            @endforelse
                  </tbody>
                </table>
            </div>
          </div>

    <!-- Old Enrollees Section -->
    <div id="old-enrollees-section" class="strand-box" style="margin-top: 20px;">
      <div class="courses-list">
        <h3>Old Student Enrollees</h3>
        <div class="search-control">
          <input type="text" id="old-enrollee-search" placeholder="Search enrollees..." class="search-bar">
        </div>
              </div>

              <div class="table-container">
                <table class="enrollees-table">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>LRN</th>
                      <th>Strand</th>
              <th>Grade Level</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($oldEnrollees as $e)
              <tr data-enrollee-id="{{ $e->id }}" data-enrollee-name="{{ $e->display_name }}" data-enrollee-type="old">
                        <td>{{ $e->student_id }}</td>
                <td>{{ $e->display_name }}</td>
                        <td>{{ $e->lrn }}</td>
                        <td>
                          @php
                            $gradeLevel = $e->grade_level_applying ?? 7;
                            $isJHS = ($gradeLevel >= 7 && $gradeLevel <= 10);
                          @endphp
                          @if($isJHS)
                            <span class="selected-strand">JHS</span>
                          @elseif($e->strand)
                            {{ $e->strand }}
                          @else
                            –
                          @endif
                        </td>
                        <td>{{ $e->grade_level_applying ?? '–' }}</td>
                        <td>
                          <span class="status-badge status-{{ $e->status ?? 'pending' }}">
                            {{ ucfirst($e->status ?? 'pending') }}
                          </span>
                        </td>
                <td>
                          <div class="action-buttons">
                    <button class="view-btn btn btn-info btn-sm" 
                            data-url="{{ route('admin.enrollee.old.modal', $e->id) }}">
                      View
                            </button>
                    @if($e->status !== 'accepted')
                      <button class="btn btn-success btn-sm accept-btn" 
                              data-enrollee-id="{{ $e->id }}"
                              data-enrollee-name="{{ $e->display_name }}"
                              data-enrollee-type="old">
                              Accept
                            </button>
                      <button class="btn btn-warning btn-sm decline-btn" 
                              data-enrollee-id="{{ $e->id }}"
                              data-enrollee-name="{{ $e->display_name }}"
                              data-enrollee-type="old">
                        Decline
                            </button>
                            @endif
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                <td colspan="7" class="text-center">No old student enrollees found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
      </div>
    </div>
              </div>

  <!-- Logout Confirmation Modal -->
  <div id="confirm-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <p>Are you sure you want to log out?</p>
      <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
      <button class="cancel-btn" onclick="closeModal()">No</button>
    </div>
  </div>

  <!-- View Modal -->
  <div id="view-modal" class="modal-overlay" style="display: none;">
    <div id="view-content">
      <!-- Content will be loaded here directly -->
            </div>
          </div>

  <!-- Accept Modal -->
  <div id="accept-modal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
      <div class="modal-header">
        <h3 class="modal-title">Accept Enrollee</h3>
        <button type="button" class="modal-close-btn" onclick="closeAcceptModal()">
          <span>&times;</span>
        </button>
    </div>

      <div class="modal-body">
        <p>Are you sure you want to accept this enrollee?</p>
        
        <div class="modal-actions">
          <button type="button" onclick="closeAcceptModal()" class="btn btn-secondary">
            Cancel
          </button>
          <button type="button" id="confirm-accept-btn" class="btn btn-success">
            Accept
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Decline Modal -->
  <div id="decline-modal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
      <div class="modal-header">
        <h3 class="modal-title">Decline Enrollee</h3>
        <button type="button" class="modal-close-btn" onclick="closeDeclineModal()">
          <span>&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p>Please provide a reason for declining this enrollee:</p>
        
        <form id="decline-form">
          <div class="form-group">
            <label for="decline-reason">Reason for Decline:</label>
            <select id="decline-reason" name="decline_reason" required>
              <option value="">Select a reason</option>
              <option value="Incomplete Documents">Incomplete Documents</option>
              <option value="Invalid Information">Invalid Information</option>
              <option value="Failed Requirements">Failed Requirements</option>
              <option value="Other">Other</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="decline-comments">Additional Comments:</label>
            <textarea id="decline-comments" name="decline_comments" rows="3" placeholder="Optional additional comments..."></textarea>
          </div>
        </form>
        
        <div class="modal-actions">
          <button type="button" onclick="closeDeclineModal()" class="btn btn-secondary">
            Cancel
          </button>
          <button type="button" id="confirm-decline-btn" class="btn btn-danger">
            Decline Application
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Document Viewer Modal -->
  <div id="document-viewer-modal" class="modal-overlay" style="display: none; z-index: 1001;">
    <div class="document-viewer-container">
      <div class="document-viewer-header">
        <div class="document-viewer-title">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <div>
            <h3 id="document-viewer-doc-title">Document Preview</h3>
            <p>View enrollee document</p>
          </div>
        </div>
        <button type="button" class="document-viewer-close" onclick="closeDocumentViewer()">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>
      <div class="document-viewer-body">
        <div id="document-viewer-content">
          <iframe id="document-viewer-frame" src="about:blank" style="display:none;"></iframe>
          <img id="document-viewer-image" src="" alt="Document" style="display:none;">
        </div>
      </div>
      <div class="document-viewer-footer">
        <div class="document-viewer-info">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="m9 12 2 2 4-4"></path>
          </svg>
          <span>If preview fails, use Download button to open the file locally.</span>
        </div>
        <div class="document-viewer-actions">
          <button id="document-viewer-download-btn" type="button" class="btn btn-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/>
              <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download
          </button>
          <button type="button" class="btn btn-secondary" onclick="closeDocumentViewer()">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Search functionality
      const newSearch = document.getElementById('instructor-search');
      const oldSearch = document.getElementById('old-enrollee-search');
      
      if (newSearch) {
        newSearch.addEventListener('input', function() {
          filterTable('new-enrollees-section', this.value);
        });
      }
      
      if (oldSearch) {
        oldSearch.addEventListener('input', function() {
          filterTable('old-enrollees-section', this.value);
        });
      }
      
      // Grade filter functionality
      const gradeFilter = document.getElementById('grade-filter');
      if (gradeFilter) {
        gradeFilter.addEventListener('change', function() {
          const newSection = document.getElementById('new-enrollees-section');
          const oldSection = document.getElementById('old-enrollees-section');
          
          if (this.value === 'new') {
            if (newSection) newSection.style.display = 'block';
            if (oldSection) oldSection.style.display = 'none';
          } else if (this.value === 'old') {
            if (newSection) newSection.style.display = 'none';
            if (oldSection) oldSection.style.display = 'block';
          } else {
            if (newSection) newSection.style.display = 'block';
            if (oldSection) oldSection.style.display = 'block';
          }
        });
      }
    });

    // Filter table function
    function filterTable(sectionId, searchValue) {
      const section = document.getElementById(sectionId);
      if (!section) return;
      
      const table = section.querySelector('table');
      if (!table) return;
      
      const rows = table.querySelectorAll('tbody tr');
      const searchLower = searchValue.toLowerCase();
      
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchLower) ? '' : 'none';
      });
    }

    // View modal functions
    function viewEnrollee(button) {
      const url = button.getAttribute('data-url');
      const modal = document.getElementById('view-modal');
      const content = document.getElementById('view-content');
      
      if (modal && content) {
        fetch(url)
          .then(response => response.text())
          .then(html => {
            // Load content directly without adding extra close button
            content.innerHTML = html;
            modal.style.display = 'flex';
            
            // Add event listeners to any close buttons in the loaded content
            const closeButtons = content.querySelectorAll('button');
            closeButtons.forEach(button => {
              const buttonText = button.textContent.toLowerCase().trim();
              const onclickAttr = button.getAttribute('onclick');
              
              // Check if button text contains close or has onclick with close
              if (buttonText.includes('close') || buttonText.includes('✕') || 
                  (onclickAttr && onclickAttr.toLowerCase().includes('close'))) {
                
                // Remove any existing onclick attribute
                button.removeAttribute('onclick');
                
                // Add new event listener
                button.addEventListener('click', function(e) {
                  e.preventDefault();
                  window.closeViewModal();
                });
              }
            });
        })
        .catch(error => {
            console.error('Error loading modal content:', error);
            content.innerHTML = '<p>Error loading content.</p>';
            modal.style.display = 'flex';
          });
      }
    }

    // Make closeViewModal globally accessible
    window.closeViewModal = function() {
      const modal = document.getElementById('view-modal');
      if (modal) {
        modal.style.display = 'none';
      }
    }

    // Send credentials via email - global function
    window.sendCredentialsEmail = function(enrolleeId) {
      const button = event.target.closest('button');
      const originalButtonHTML = button.innerHTML;
      
      // Show loading state
      button.disabled = true;
      button.style.opacity = '0.6';
      button.innerHTML = '<div style="font-size: 14px;">⏳ Sending...</div>';
      
      // Send AJAX request - use full URL path
      const baseUrl = window.location.origin;
      fetch(`${baseUrl}/admin/enrollees/${enrolleeId}/credentials/email`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Show success message
          button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
          button.innerHTML = '<div style="font-size: 14px;">✓ Email Sent!</div><div style="font-size: 11px; font-weight: 400; margin-top: 4px; opacity: 0.9;">Check student\'s inbox</div>';
          
          // Show notification
          if (typeof showNotification === 'function') {
            showNotification('success', data.message || 'Credentials sent successfully!');
          } else {
            alert('✓ ' + (data.message || 'Credentials sent successfully!'));
          }
          
          // Reset button after 3 seconds
          setTimeout(() => {
            button.innerHTML = originalButtonHTML;
            button.disabled = false;
            button.style.opacity = '1';
          }, 3000);
        } else {
          throw new Error(data.message || 'Failed to send email');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        
        // Show error state
        button.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
        button.innerHTML = '<div style="font-size: 14px;">✗ Failed</div><div style="font-size: 11px; font-weight: 400; margin-top: 4px; opacity: 0.9;">Try again</div>';
        
        // Show error notification
        if (typeof showNotification === 'function') {
          showNotification('error', error.message || 'Failed to send email. Please try again.');
        } else {
          alert('✗ Error: ' + (error.message || 'Failed to send email. Please try again.'));
        }
        
        // Reset button after 3 seconds
        setTimeout(() => {
          button.innerHTML = originalButtonHTML;
          button.disabled = false;
          button.style.opacity = '1';
        }, 3000);
      });
    };

    // Accept modal functions
    let currentAcceptData = null;

    function acceptEnrollee(button) {
      currentAcceptData = {
        id: button.getAttribute('data-enrollee-id'),
        name: button.getAttribute('data-enrollee-name'),
        type: button.getAttribute('data-enrollee-type')
      };
      
      const modal = document.getElementById('accept-modal');
      if (modal) {
              modal.style.display = 'flex';
      }
    }


    function closeAcceptModal() {
      const modal = document.getElementById('accept-modal');
      if (modal) {
                  modal.style.display = 'none';
      }
      currentAcceptData = null;
    }

    // Decline modal functions
    let currentDeclineData = null;

    function declineEnrollee(button) {
      currentDeclineData = {
        id: button.getAttribute('data-enrollee-id'),
        name: button.getAttribute('data-enrollee-name'),
        type: button.getAttribute('data-enrollee-type')
      };
      
      const modal = document.getElementById('decline-modal');
      if (modal) {
              modal.style.display = 'flex';
      }
    }


    function closeDeclineModal() {
      const modal = document.getElementById('decline-modal');
      if (modal) {
        modal.style.display = 'none';
      }
      currentDeclineData = null;
    }

    // Modal event listeners
      document.addEventListener('DOMContentLoaded', function() {
      // Accept confirmation
      const confirmAcceptBtn = document.getElementById('confirm-accept-btn');
      if (confirmAcceptBtn) {
        confirmAcceptBtn.addEventListener('click', function() {
          if (currentAcceptData) {
            const url = currentAcceptData.type === 'new' 
              ? `/admin/enrollees/${currentAcceptData.id}/accept`
              : `/admin/old-enrollees/${currentAcceptData.id}/accept`;
          
            fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: new URLSearchParams({
                '_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
              alert('❌ Error accepting enrollee. Please try again.');
            });
          }
          closeAcceptModal();
        });
      }

      // Decline confirmation
      const confirmDeclineBtn = document.getElementById('confirm-decline-btn');
      if (confirmDeclineBtn) {
        confirmDeclineBtn.addEventListener('click', function() {
          if (currentDeclineData) {
            const reason = document.getElementById('decline-reason').value;
            const comments = document.getElementById('decline-comments').value;
            
            if (!reason) {
              alert('Please select a reason for declining');
              return;
            }
            
            const url = currentDeclineData.type === 'new' 
              ? `/admin/enrollees/${currentDeclineData.id}/decline`
              : `/admin/old-enrollees/${currentDeclineData.id}/decline`;
        
            fetch(url, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: new URLSearchParams({
                '_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'decline_reason': reason,
                'decline_comments': comments
              })
            })
        .then(response => response.json())
        .then(data => {
              if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
          } else {
                alert('❌ ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
              alert('❌ Error declining enrollee. Please try again.');
            });
          }
          closeDeclineModal();
        });
      }

      // View button event listeners
      const viewButtons = document.querySelectorAll('.view-btn');
      viewButtons.forEach(button => {
        button.addEventListener('click', function() {
          viewEnrollee(this);
        });
      });

      // Accept button event listeners
      const acceptButtons = document.querySelectorAll('.accept-btn');
      acceptButtons.forEach(button => {
        button.addEventListener('click', function() {
          acceptEnrollee(this);
        });
      });

      // Decline button event listeners
      const declineButtons = document.querySelectorAll('.decline-btn');
      declineButtons.forEach(button => {
        button.addEventListener('click', function() {
          declineEnrollee(this);
        });
      });
    });

    // Logout modal functions
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

    // Alert close function
    function closeAlert(alertId) {
      const alert = document.getElementById(alertId);
      if (alert) {
        alert.style.display = 'none';
      }
    }

    // Document Viewer Functions
    let documentViewerErrorShown = false; // Prevent multiple alerts
    
    function viewDocument(url, title) {
      const modal = document.getElementById('document-viewer-modal');
      const frame = document.getElementById('document-viewer-frame');
      const img = document.getElementById('document-viewer-image');
      const downloadBtn = document.getElementById('document-viewer-download-btn');
      const docTitle = document.getElementById('document-viewer-doc-title');
      
      if (!modal || !frame || !img || !downloadBtn) return;
      
      // Reset error flag
      documentViewerErrorShown = false;
      
      // Set document title
      if (docTitle) {
        docTitle.textContent = title || 'Document Preview';
      }
      
      // Store URL for download button
      downloadBtn.setAttribute('data-url', url);
      downloadBtn.onclick = function() {
        window.open(url, '_blank');
      };
      
      // Clear previous error handlers
      img.onerror = null;
      frame.onerror = null;
      
      // Detect file type by extension
      const urlLower = (url || '').toLowerCase();
      const isImage = /(\.png|\.jpg|\.jpeg|\.gif|\.webp)(\?|$)/.test(urlLower);
      const isPDF = /\.pdf(\?|$)/.test(urlLower);
      
      if (isImage) {
        // Show image
        frame.style.display = 'none';
        img.style.display = 'block';
        img.src = url;
        
        // Single error handler
        img.onerror = function() {
          if (!documentViewerErrorShown) {
            documentViewerErrorShown = true;
            alert('Failed to load image. The file may not exist or is inaccessible.');
            closeDocumentViewer();
          }
        };
      } else {
        // Show PDF or other documents in iframe
        img.style.display = 'none';
        frame.style.display = 'block';
        frame.src = url;
        
        // Note: iframe onerror doesn't work reliably, so we skip it
        // Users will see a browser error page in the iframe if it fails
      }
      
      // Show modal
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
      
      // Close on overlay click
      modal.onclick = function(e) {
        if (e.target === modal) {
          closeDocumentViewer();
        }
      };
    }

    function closeDocumentViewer() {
      const modal = document.getElementById('document-viewer-modal');
      const frame = document.getElementById('document-viewer-frame');
      const img = document.getElementById('document-viewer-image');
      
      if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        modal.onclick = null;
      }
      
      // Clear error handlers before clearing sources
      if (img) {
        img.onerror = null;
        img.src = '';
      }
      if (frame) {
        // CRITICAL: Remove onload handler to prevent infinite loop
        frame.onload = null;
        frame.onerror = null;
        frame.src = 'about:blank';
      }
      
      // Reset error flag
      documentViewerErrorShown = false;
    }
    
    // View Document with Fallback
    function viewDocumentWithFallback(url, fallbackUrl, title) {
      console.log('Opening document:', url, 'with fallback:', fallbackUrl);
      
      // Try primary URL first
      viewDocument(url, title);
      
      // If primary URL fails, try fallback
      const modal = document.getElementById('document-viewer-modal');
      const frame = document.getElementById('document-viewer-frame');
      const img = document.getElementById('document-viewer-image');
      
      if (img) {
        const originalOnError = img.onerror;
        img.onerror = function() {
          if (fallbackUrl && !documentViewerErrorShown) {
            console.log('Primary URL failed, trying fallback:', fallbackUrl);
            // Try fallback
            img.onerror = originalOnError;
            img.src = fallbackUrl;
          } else if (originalOnError) {
            originalOnError();
          }
        };
      }
      
      if (frame) {
        const originalOnLoad = frame.onload;
        frame.onload = function() {
          // CRITICAL: Don't try fallback if frame is being cleared (about:blank)
          if (this.src === 'about:blank' || !this.src) {
            return;
          }
          
          // Don't check for errors unless absolutely necessary
          // Most modern browsers handle PDF/document loading in iframes correctly
          if (originalOnLoad) originalOnLoad();
        };
      }
    }
    
    // Download Document with Fallback
    async function downloadDocWithFallback(url, fallbackUrl) {
      try {
        console.log('Attempting download:', url);
        let res = await fetch(url, { credentials: 'same-origin' });
        
        // If primary URL fails and we have a fallback, try it
        if (!res.ok && fallbackUrl) {
          console.log('Primary download failed, trying fallback:', fallbackUrl);
          res = await fetch(fallbackUrl, { credentials: 'same-origin' });
        }
        
        if (!res.ok) throw new Error('Download failed');
        
        const blob = await res.blob();
        const link = document.createElement('a');
        const fname = (url.split('/').pop() || 'document').split('?')[0];
        link.href = URL.createObjectURL(blob);
        link.download = fname || 'document';
        document.body.appendChild(link);
        link.click();
        URL.revokeObjectURL(link.href);
        link.remove();
      } catch (e) {
        console.error('Download error:', e);
        alert('Unable to download document. Please try again later.');
      }
    }

    // Payment Status Update Function
    window.updatePaymentStatus = async function(enrolleeId, type) {
      console.log('updatePaymentStatus called:', { enrolleeId, type });
      
      // Get the select element and button
      const selectId = type === 'old' ? 'payment-status-select-old' : 'payment-status-select';
      const buttonId = type === 'old' ? 'save-payment-status-old' : 'save-payment-status';
      const metaId = type === 'old' ? 'payment-status-meta-old' : 'payment-status-meta';
      
      const select = document.getElementById(selectId);
      const button = document.getElementById(buttonId);
      const meta = document.getElementById(metaId);
      
      if (!select || !button) {
        console.error('Required elements not found:', { selectId, buttonId });
        alert('Error: Could not find payment status elements');
        return;
      }
      
      const value = select.value;
      console.log('Payment status to update:', value);
      
      // Disable button during update
      button.disabled = true;
      button.textContent = 'Saving...';
      
      try {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
          throw new Error('CSRF token not found');
        }
        
        const url = `/admin/api/enrollee/${type}/${enrolleeId}/payment-status`;
        console.log('Making request to:', url);
        
        const response = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify({ payment_status: value })
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
          const errorText = await response.text();
          console.error('Response error:', errorText);
          throw new Error(`HTTP ${response.status}: ${errorText}`);
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (!data.success) {
          throw new Error(data.message || 'Update failed');
        }
        
        // Update metadata
        if (meta) {
          meta.textContent = `Updated just now by ${data.changed_by || 'admin'}`;
        }
        
        alert('✓ Payment status updated successfully to: ' + data.payment_status);
        
      } catch (error) {
        console.error('Payment status update error:', error);
        alert('Error updating payment status: ' + error.message);
      } finally {
        // Re-enable button
        button.disabled = false;
        button.textContent = 'Save';
      }
    };

    // Make functions globally accessible
    window.viewDocument = viewDocument;
    window.closeDocumentViewer = closeDocumentViewer;
    </script>

@push('scripts')
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush

@endsection
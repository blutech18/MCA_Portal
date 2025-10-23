@extends('layouts.admin_base')

@section('title', 'Admin - Section Management')
@section('header', 'Section Management')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  .section-management { padding: 20px; }
  .section-management .container { max-width: 1400px; margin: 0 auto; }
  
  /* Statistics Cards */
  .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
  .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; }
  .stat-card .label { font-size: 12px; color: #6b7280; margin-bottom: 4px; }
  .stat-card .value { font-size: 28px; font-weight: 700; color: #1f2937; }
  .stat-card.green .value { color: #059669; }
  .stat-card.blue .value { color: #3b82f6; }
  .stat-card.orange .value { color: #f59e0b; }
  
  /* Action Bar */
  .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 12px; flex-wrap: wrap; }
  .btn { padding: 10px 18px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; transition: all 0.2s; }
  .btn-primary { background: #3b82f6; color: white; }
  .btn-primary:hover { background: #2563eb; }
  .btn-success { background: #10b981; color: white; }
  .btn-success:hover { background: #059669; }
  .btn-secondary { background: #6b7280; color: white; }
  .btn-secondary:hover { background: #4b5563; }
  .btn-danger { background: #ef4444; color: white; }
  .btn-danger:hover { background: #dc2626; }
  .btn-sm { padding: 6px 12px; font-size: 12px; }
  
  /* Filters */
  .filters { display: flex; gap: 12px; flex-wrap: wrap; background: #fff; padding: 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb; }
  .filter-group { display: flex; flex-direction: column; gap: 4px; }
  .filter-group label { font-size: 12px; font-weight: 500; color: #374151; }
  .filter-group select { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
  
  /* Sections Table */
  .sections-table { background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; }
  .sections-table table { width: 100%; border-collapse: collapse; }
  .sections-table th { background: #f9fafb; padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; }
  .sections-table td { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; font-size: 14px; }
  .sections-table tr:last-child td { border-bottom: none; }
  .sections-table tr:hover { background: #f9fafb; }
  
  /* Status Badges */
  .badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
  .badge.active { background: #d1fae5; color: #065f46; }
  .badge.full { background: #fecaca; color: #991b1b; }
  .badge.inactive { background: #e5e7eb; color: #4b5563; }
  
  /* Capacity Bar */
  .capacity-bar { display: flex; align-items: center; gap: 8px; }
  .progress-bar { flex: 1; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden; }
  .progress-fill { height: 100%; background: #10b981; transition: width 0.3s; }
  .progress-fill.warning { background: #f59e0b; }
  .progress-fill.danger { background: #ef4444; }
  .capacity-text { font-size: 12px; color: #6b7280; min-width: 60px; }
  
  /* Modal */
  .modal { display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000; }
  .modal-content { background: white; border-radius: 8px; padding: 24px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; }
  .modal h2 { margin: 0 0 20px 0; font-size: 20px; font-weight: 600; }
  .form-group { margin-bottom: 16px; }
  .form-group label { display: block; margin-bottom: 6px; font-weight: 500; font-size: 14px; }
  .form-group input, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
  .form-group input:focus, .form-group select:focus { outline: none; border-color: #3b82f6; }
  .form-group small { color: #6b7280; font-size: 12px; }
  .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px; }
  .checkbox-group { display: flex; align-items: center; gap: 8px; }
  .checkbox-group input[type="checkbox"] { width: auto; }
  
  /* Alert */
  .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
  .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
  .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
  .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
  
  /* Empty State */
  .empty-state { text-align: center; padding: 60px 20px; color: #6b7280; }
  .empty-state svg { width: 64px; height: 64px; margin-bottom: 16px; opacity: 0.5; }
  
  /* Action Buttons */
  .action-buttons { display: flex; gap: 6px; }
  
  /* Capacity Report Styles */
  .report-section { margin-bottom: 24px; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; }
  .report-header { background: #f9fafb; padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
  .report-header h3 { margin: 0; font-size: 16px; font-weight: 600; display: flex; align-items: center; justify-content: space-between; }
  .report-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; padding: 16px; background: #fff; border-bottom: 1px solid #e5e7eb; }
  .report-stat { text-align: center; }
  .report-stat .label { font-size: 11px; color: #6b7280; margin-bottom: 4px; }
  .report-stat .value { font-size: 20px; font-weight: 700; }
  .report-sections-list { padding: 12px 16px; background: #fff; }
  .report-section-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f3f4f6; }
  .report-section-item:last-child { border-bottom: none; }
  .section-item-name { font-weight: 500; font-size: 14px; }
  .section-item-stats { display: flex; gap: 16px; align-items: center; font-size: 13px; color: #6b7280; }
  .warning-banner { background: #fef3c7; color: #92400e; padding: 12px 16px; border-left: 4px solid #f59e0b; margin-bottom: 16px; border-radius: 4px; }
  .danger-banner { background: #fee2e2; color: #991b1b; padding: 12px 16px; border-left: 4px solid #ef4444; margin-bottom: 16px; border-radius: 4px; }
</style>
@endpush

@section('content')
<div class="section-management">
  <div class="container">
    <!-- Alert Messages -->
    <div id="alertContainer"></div>
    
    <!-- Capacity Warnings -->
    @php
      $criticalSections = $sections->where('is_full', true)->count();
      $nearlyfullSections = $sections->filter(function($s) { 
        return !$s->is_full && ($s->current_count / $s->max_capacity) >= 0.9; 
      })->count();
      $availableCapacity = $stats['available_capacity'];
    @endphp
    
    @if($criticalSections > 0)
      <div class="danger-banner">
        ⚠️ <strong>CRITICAL:</strong> {{ $criticalSections }} section(s) are now FULL! 
        @if($availableCapacity == 0)
          <strong>No available capacity remaining.</strong> Please create additional sections or no more students can be enrolled.
        @else
          Remaining capacity: {{ $availableCapacity }} spots across all active sections.
        @endif
      </div>
    @elseif($nearlyfullSections > 0)
      <div class="warning-banner">
        ⚠️ <strong>Notice:</strong> {{ $nearlyfullSections }} section(s) are nearly full (90%+ capacity). 
        Available capacity: {{ $availableCapacity }} spots remaining.
      </div>
    @endif
    
    <!-- Statistics Cards -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="label">Total Sections</div>
        <div class="value">{{ $stats['total_sections'] }}</div>
      </div>
      <div class="stat-card green">
        <div class="label">Active Sections</div>
        <div class="value">{{ $stats['active_sections'] }}</div>
      </div>
      <div class="stat-card orange">
        <div class="label">Full Sections</div>
        <div class="value">{{ $stats['full_sections'] }}</div>
      </div>
      <div class="stat-card">
        <div class="label">Total Students Assigned</div>
        <div class="value">{{ $stats['total_students'] }}</div>
      </div>
      <div class="stat-card green">
        <div class="label">Available Capacity</div>
        <div class="value">{{ $stats['available_capacity'] }}</div>
      </div>
    </div>
    
    <!-- Action Bar -->
    <div class="action-bar">
      <div>
        <button class="btn btn-primary" onclick="openCreateModal()">➕ Create Section</button>
        <button class="btn btn-success" onclick="syncAllCounts()">🔄 Sync All Counts</button>
      </div>
      <button class="btn btn-secondary" onclick="viewCapacityReport()">📊 Capacity Report</button>
    </div>
    
    <!-- Filters -->
    <div class="filters">
      <div class="filter-group">
        <label>Grade Level</label>
        <select id="filterGrade" onchange="applyFilters()">
          <option value="">All Grades</option>
          @foreach($gradeLevels as $grade)
            <option value="{{ $grade->grade_level_id }}" {{ request('grade_level_id') == $grade->grade_level_id ? 'selected' : '' }}>
              Grade {{ $grade->name }}
            </option>
          @endforeach
        </select>
      </div>
      
      <div class="filter-group">
        <label>Strand (SHS Only)</label>
        <select id="filterStrand" onchange="applyFilters()">
          <option value="">All Strands</option>
          @foreach($strands as $strand)
            <option value="{{ $strand->id }}" {{ request('strand_id') == $strand->id ? 'selected' : '' }}>
              {{ $strand->name }}
            </option>
          @endforeach
        </select>
      </div>
      
      <div class="filter-group">
        <label>Status</label>
        <select id="filterStatus" onchange="applyFilters()">
          <option value="">All Status</option>
          <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
          <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Full</option>
          <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>
      
      <div class="filter-group">
        <label>&nbsp;</label>
        <button class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
      </div>
    </div>
    
    <!-- Sections Table -->
    <div class="sections-table">
      @if($sections->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Section Name</th>
              <th>Grade Level</th>
              <th>Strand</th>
              <th>Priority</th>
              <th>Capacity</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($sections as $section)
              <tr>
                <td><strong>{{ $section->section_name }}</strong></td>
                <td>Grade {{ $section->gradeLevel->name ?? 'N/A' }}</td>
                <td>{{ $section->strand->name ?? '-' }}</td>
                <td>{{ $section->section_priority }}</td>
                <td>
                  <div class="capacity-bar">
                    <div class="progress-bar">
                      <div class="progress-fill {{ $section->current_count >= $section->max_capacity ? 'danger' : ($section->current_count / $section->max_capacity >= 0.8 ? 'warning' : '') }}" 
                           style="width: {{ $section->max_capacity > 0 ? ($section->current_count / $section->max_capacity * 100) : 0 }}%"></div>
                    </div>
                    <div class="capacity-text">{{ $section->current_count }}/{{ $section->max_capacity }}</div>
                  </div>
                </td>
                <td>
                  @if($section->is_full)
                    Full
                  @elseif($section->is_active)
                    Active
                  @else
                    Inactive
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-sm btn-primary" onclick="viewSection({{ $section->id }})">👁️ View</button>
                    <button class="btn btn-sm btn-secondary" onclick="openEditModal({{ $section->id }})">✏️ Edit</button>
                    @if($section->current_count == 0)
                      <button class="btn btn-sm btn-danger" onclick="deleteSection({{ $section->id }})">🗑️ Delete</button>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3>No sections found</h3>
          <p>Try adjusting your filters or create a new section.</p>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Create/Edit Section Modal -->
<div id="sectionModal" class="modal" style="display: none;">
  <div class="modal-content" style="max-width: 700px; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);">
    <div class="modal-header" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 24px; border-radius: 12px 12px 0 0; position: relative; margin: -24px -24px 24px -24px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
        </div>
        <div style="flex: 1;">
          <h3 id="modalTitle" style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; color: white;">Create Section</h3>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">Configure section details and capacity</p>
        </div>
      </div>
      <button type="button" class="close-btn" onclick="closeModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <form id="sectionForm">
      <input type="hidden" id="sectionId" name="section_id">
      
      <div class="form-group">
        <label for="gradeLevel">Grade Level *</label>
        <select id="gradeLevel" name="grade_level_id" required onchange="updateStrandVisibility()">
          <option value="">Select Grade Level</option>
          @foreach($gradeLevels as $grade)
            <option value="{{ $grade->grade_level_id }}">Grade {{ $grade->name }}</option>
          @endforeach
        </select>
      </div>
      
      <div class="form-group" id="strandGroup" style="display: none;">
        <label for="strand">Strand (Required for SHS)</label>
        <select id="strand" name="strand_id">
          <option value="">Select Strand</option>
          @foreach($strands as $strand)
            <option value="{{ $strand->id }}">{{ $strand->name }}</option>
          @endforeach
        </select>
      </div>
      
      <div id="singleSectionFields">
        <div class="form-group">
          <label for="sectionName">Section Name *</label>
          <input type="text" id="sectionName" name="section_name" placeholder="e.g., Grade 7 - Section 1">
        </div>
        
        <div class="form-group">
          <label for="sectionPriority">Section Priority *</label>
          <input type="number" id="sectionPriority" name="section_priority" min="1" placeholder="1">
          <small>Lower numbers are filled first during enrollment</small>
        </div>
      </div>
      
      <div class="form-group">
        <label for="maxCapacity">Maximum Capacity *</label>
        <input type="number" id="maxCapacity" name="max_capacity" min="1" max="50" required placeholder="30">
      </div>
      
      <div class="form-group" id="bulkCreateGroup" style="display: none;">
        <div class="checkbox-group">
          <input type="checkbox" id="bulkCreate" name="bulk_create" onchange="toggleBulkCreate()">
          <label for="bulkCreate">Bulk Create Multiple Sections</label>
        </div>
      </div>
      
      <div id="bulkCountGroup" class="form-group" style="display: none;">
        <label for="bulkCount">Number of Sections to Create</label>
        <input type="number" id="bulkCount" name="bulk_count" min="1" max="10" placeholder="3">
        <small>Create multiple sections at once (max 10)</small>
      </div>
      
      <div class="form-group" id="isActiveGroup" style="display: none;">
        <div class="checkbox-group">
          <input type="checkbox" id="isActive" name="is_active" checked>
          <label for="isActive">Section is Active</label>
        </div>
      </div>
      
      <div style="background: #f8f9fa; padding: 20px 24px; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #dee2e6; margin: 24px -24px -24px -24px;">
        <button type="button" class="btn btn-secondary" onclick="closeModal()" style="background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
          Cancel
        </button>
        <button type="submit" class="btn btn-primary" id="submitBtn" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; border: none; padding: 10px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(122,34,43,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(122,34,43,0.2)'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
          </svg>
          <span id="submitBtnText">Create Section</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- View Section Details Modal -->
<div id="viewModal" class="modal" style="display: none;">
  <div class="modal-content" style="max-width: 700px; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);">
    <div class="modal-header" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 24px; border-radius: 12px 12px 0 0; position: relative; margin: -24px -24px 24px -24px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </div>
        <div style="flex: 1;">
          <h3 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; color: white;">Section Details</h3>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">View complete section information</p>
        </div>
      </div>
      <button type="button" class="close-btn" onclick="closeViewModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    <div id="sectionDetails" style="padding: 0 24px;"></div>
    <div style="background: #f8f9fa; padding: 20px 24px; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #dee2e6; margin: 24px -24px -24px -24px;">
      <button type="button" class="btn btn-secondary" onclick="closeViewModal()" style="background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        Close
      </button>
    </div>
  </div>
</div>

<!-- Capacity Report Modal -->
<div id="capacityReportModal" class="modal" style="display: none;">
  <div class="modal-content" style="max-width: 1000px; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);">
    <div class="modal-header" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 24px; border-radius: 12px 12px 0 0; position: relative; margin: -24px -24px 24px -24px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <line x1="18" y1="20" x2="18" y2="10"></line>
            <line x1="12" y1="20" x2="12" y2="4"></line>
            <line x1="6" y1="20" x2="6" y2="14"></line>
          </svg>
        </div>
        <div style="flex: 1;">
          <h3 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; color: white;">📊 Capacity Report</h3>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">Overview of section capacities and enrollment status</p>
        </div>
      </div>
      <button type="button" class="close-btn" onclick="closeCapacityReportModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    <div id="capacityReportContent" style="max-height: 70vh; overflow-y: auto; padding: 0 24px;"></div>
    <div style="background: #f8f9fa; padding: 20px 24px; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #dee2e6; margin: 24px -24px -24px -24px;">
      <button type="button" class="btn btn-secondary" onclick="closeCapacityReportModal()" style="background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        Close
      </button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let editMode = false;
  
  // Apply filters
  function applyFilters() {
    const grade = document.getElementById('filterGrade').value;
    const strand = document.getElementById('filterStrand').value;
    const status = document.getElementById('filterStatus').value;
    
    const params = new URLSearchParams();
    if (grade) params.append('grade_level_id', grade);
    if (strand) params.append('strand_id', strand);
    if (status) params.append('status', status);
    
    window.location.href = '{{ route("sections.index") }}' + (params.toString() ? '?' + params.toString() : '');
  }
  
  // Clear filters
  function clearFilters() {
    window.location.href = '{{ route("sections.index") }}';
  }
  
  // Open create modal
  function openCreateModal() {
    editMode = false;
    document.getElementById('modalTitle').textContent = 'Create Section';
    document.getElementById('submitBtn').textContent = 'Create Section';
    document.getElementById('sectionForm').reset();
    document.getElementById('sectionId').value = '';
    document.getElementById('bulkCreateGroup').style.display = 'block';
    document.getElementById('isActiveGroup').style.display = 'none';
    document.getElementById('singleSectionFields').style.display = 'block';
    updateStrandVisibility();
    document.getElementById('sectionModal').style.display = 'flex';
  }
  
  // Open edit modal
  async function openEditModal(sectionId) {
    editMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Section';
    document.getElementById('submitBtn').textContent = 'Update Section';
    document.getElementById('bulkCreateGroup').style.display = 'none';
    document.getElementById('bulkCountGroup').style.display = 'none';
    document.getElementById('isActiveGroup').style.display = 'block';
    document.getElementById('singleSectionFields').style.display = 'block';
    
    try {
      const response = await fetch(`{{ url('admin/sections') }}/${sectionId}`);
      const data = await response.json();
      
      if (data.success) {
        const section = data.section;
        document.getElementById('sectionId').value = section.id;
        document.getElementById('gradeLevel').value = section.grade_level_id;
        document.getElementById('strand').value = section.strand_id || '';
        document.getElementById('sectionName').value = section.section_name;
        document.getElementById('sectionPriority').value = section.section_priority;
        document.getElementById('maxCapacity').value = section.max_capacity;
        document.getElementById('isActive').checked = section.is_active;
        
        updateStrandVisibility();
        document.getElementById('sectionModal').style.display = 'flex';
      }
    } catch (error) {
      showAlert('Failed to load section details', 'error');
    }
  }
  
  // Close modal
  function closeModal() {
    document.getElementById('sectionModal').style.display = 'none';
    document.getElementById('sectionForm').reset();
  }
  
  // Toggle bulk create
  function toggleBulkCreate() {
    const bulkChecked = document.getElementById('bulkCreate').checked;
    document.getElementById('bulkCountGroup').style.display = bulkChecked ? 'block' : 'none';
    document.getElementById('singleSectionFields').style.display = bulkChecked ? 'none' : 'block';
    
    if (bulkChecked) {
      document.getElementById('sectionName').required = false;
      document.getElementById('sectionPriority').required = false;
    } else {
      document.getElementById('sectionName').required = true;
      document.getElementById('sectionPriority').required = true;
    }
  }
  
  // Update strand visibility based on grade level
  function updateStrandVisibility() {
    const gradeLevel = parseInt(document.getElementById('gradeLevel').value);
    const strandGroup = document.getElementById('strandGroup');
    const strandSelect = document.getElementById('strand');
    
    // Show strand for SHS (grades 11 and 12)
    if (gradeLevel >= 11) {
      strandGroup.style.display = 'block';
      strandSelect.required = true;
    } else {
      strandGroup.style.display = 'none';
      strandSelect.required = false;
      strandSelect.value = '';
    }
  }
  
  // Handle form submission
  document.getElementById('sectionForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    
    formData.forEach((value, key) => {
      if (key === 'bulk_create' || key === 'is_active') {
        data[key] = document.getElementById(key === 'bulk_create' ? 'bulkCreate' : 'isActive').checked;
      } else if (value) {
        data[key] = value;
      }
    });
    
    try {
      let url, method;
      
      if (editMode) {
        url = `{{ url('admin/sections') }}/${data.section_id}`;
        method = 'PUT';
      } else {
        url = '{{ route("sections.store") }}';
        method = 'POST';
      }
      
      const response = await fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: JSON.stringify(data)
      });
      
      const result = await response.json();
      
      if (result.success) {
        showAlert(result.message, 'success');
        closeModal();
        setTimeout(() => location.reload(), 1000);
      } else {
        showAlert(result.message, 'error');
      }
    } catch (error) {
      console.error('Error:', error);
      showAlert('An error occurred. Please try again.', 'error');
    }
  });
  
  // View section details
  async function viewSection(sectionId) {
    try {
      const response = await fetch(`{{ url('admin/sections') }}/${sectionId}`);
      const data = await response.json();
      
      if (data.success) {
        const section = data.section;
        const students = section.students || [];
        
        const statusBadge = section.is_full ? 
          '<span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">Full</span>' :
          (section.is_active ? 
            '<span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">Active</span>' :
            '<span style="background: #6c757d; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">Inactive</span>');
        
        const capacityPercent = section.max_capacity > 0 ? (section.current_count / section.max_capacity * 100) : 0;
        const capacityColor = capacityPercent >= 90 ? '#dc3545' : (capacityPercent >= 70 ? '#ffc107' : '#28a745');
        
        let html = `
          <div style="background: transparent; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
              <div>
                <div style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Section Name</div>
                <div style="color: #212529; font-weight: 600; font-size: 16px;">${section.section_name}</div>
              </div>
              <div>
                <div style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Grade Level</div>
                <div style="color: #212529; font-weight: 600; font-size: 16px;">Grade ${section.grade_level?.name || 'N/A'}</div>
              </div>
              <div>
                <div style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Strand</div>
                <div style="color: #212529; font-weight: 600; font-size: 16px;">${section.strand?.name || '-'}</div>
              </div>
              <div>
                <div style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Priority</div>
                <div style="color: #212529; font-weight: 600; font-size: 16px;">${section.section_priority}</div>
              </div>
              <div>
                <div style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Capacity</div>
                <div style="color: #212529; font-weight: 600; font-size: 16px;">${section.current_count}/${section.max_capacity}</div>
                <div style="background: #e9ecef; height: 6px; border-radius: 3px; margin-top: 6px; overflow: hidden;">
                  <div style="background: ${capacityColor}; height: 100%; width: ${capacityPercent}%; transition: width 0.3s;"></div>
                </div>
              </div>
              <div>
                <div style="color: #6c757d; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Status</div>
                <div>${statusBadge}</div>
              </div>
            </div>
          </div>
          
          <div style="background: transparent; border: 1px solid #e9ecef; border-radius: 10px; padding: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #e9ecef;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
              <strong style="color: #212529; font-size: 16px;">Enrolled Students (${students.length})</strong>
            </div>
        `;
        
        if (students.length > 0) {
          html += '<div style="max-height: 300px; overflow-y: auto;">';
          students.forEach((student, index) => {
            html += `
              <div style="padding: 12px 16px; background: ${index % 2 === 0 ? '#f8f9fa' : 'transparent'}; border-radius: 6px; margin-bottom: 4px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #7a222b, #922832); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                  ${student.fname.charAt(0)}${student.lname.charAt(0)}
                </div>
                <div style="flex: 1;">
                  <div style="font-weight: 600; color: #212529; font-size: 14px;">${student.lname}, ${student.fname} ${student.mname || ''}</div>
                  ${student.lrn ? `<div style="font-size: 12px; color: #6c757d;">LRN: ${student.lrn}</div>` : ''}
                </div>
              </div>
            `;
          });
          html += '</div>';
        } else {
          html += `
            <div style="padding: 40px 20px; text-align: center; color: #6c757d;">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px;">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
              <p style="margin: 0; font-style: italic;">No students enrolled yet.</p>
            </div>
          `;
        }
        
        html += '</div>';
        
        document.getElementById('sectionDetails').innerHTML = html;
        document.getElementById('viewModal').style.display = 'flex';
      }
    } catch (error) {
      showAlert('Failed to load section details', 'error');
    }
  }
  
  // Close view modal
  function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
  }
  
  // Delete section
  async function deleteSection(sectionId) {
    if (!confirm('Are you sure you want to delete this section? This action cannot be undone.')) {
      return;
    }
    
    try {
      const response = await fetch(`{{ url('admin/sections') }}/${sectionId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        }
      });
      
      const data = await response.json();
      
      if (data.success) {
        showAlert(data.message, 'success');
        setTimeout(() => location.reload(), 1000);
      } else {
        showAlert(data.message, 'error');
      }
    } catch (error) {
      showAlert('Failed to delete section', 'error');
    }
  }
  
  // Sync all counts
  async function syncAllCounts() {
    if (!confirm('This will sync all section student counts with actual database counts. Continue?')) {
      return;
    }
    
    try {
      const response = await fetch('{{ route("sections.sync-counts") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        }
      });
      
      const data = await response.json();
      
      if (data.success) {
        showAlert(data.message, 'success');
        setTimeout(() => location.reload(), 1000);
      } else {
        showAlert(data.message, 'error');
      }
    } catch (error) {
      showAlert('Failed to sync counts', 'error');
    }
  }
  
  // View capacity report
  async function viewCapacityReport() {
    try {
      const response = await fetch('{{ route("sections.report.capacity") }}');
      const data = await response.json();
      
      if (data.success) {
        displayCapacityReport(data.report);
      }
    } catch (error) {
      showAlert('Failed to load capacity report', 'error');
    }
  }
  
  // Display capacity report in modal
  function displayCapacityReport(report) {
    let html = '';
    
    if (report.length === 0) {
      html = '<div class="empty-state"><p>No sections found</p></div>';
    } else {
      report.forEach(item => {
        const fillPercentage = item.fill_percentage || 0;
        const allFull = item.all_full;
        
        html += '<div class="report-section">';
        
        // Header
        html += '<div class="report-header">';
        html += '<h3>';
        html += item.grade_level;
        if (item.strand) {
          html += ' - ' + item.strand;
        }
        if (allFull) {
          html += ' <span class="badge full" style="margin-left: 8px;">ALL FULL</span>';
        }
        html += '</h3>';
        html += '</div>';
        
        // Alert banner if full or nearly full
        if (allFull) {
          html += '<div class="danger-banner">';
          html += '⚠️ <strong>WARNING:</strong> All sections are full! No more students can be enrolled. ';
          html += 'Total capacity: ' + item.current_count + '/' + item.total_capacity + ' students.';
          html += '</div>';
        } else if (fillPercentage >= 90) {
          html += '<div class="warning-banner">';
          html += '⚠️ <strong>Notice:</strong> Sections are nearly full (' + fillPercentage.toFixed(1) + '%). ';
          html += 'Only ' + item.available_capacity + ' spots remaining.';
          html += '</div>';
        }
        
        // Summary stats
        html += '<div class="report-summary">';
        html += '<div class="report-stat">';
        html += '<div class="label">Total Sections</div>';
        html += '<div class="value" style="color: #3b82f6;">' + item.total_sections + '</div>';
        html += '</div>';
        html += '<div class="report-stat">';
        html += '<div class="label">Full Sections</div>';
        html += '<div class="value" style="color: #ef4444;">' + item.full_sections + '</div>';
        html += '</div>';
        html += '<div class="report-stat">';
        html += '<div class="label">Current Students</div>';
        html += '<div class="value" style="color: #1f2937;">' + item.current_count + '</div>';
        html += '</div>';
        html += '<div class="report-stat">';
        html += '<div class="label">Total Capacity</div>';
        html += '<div class="value" style="color: #6b7280;">' + item.total_capacity + '</div>';
        html += '</div>';
        html += '<div class="report-stat">';
        html += '<div class="label">Available Spots</div>';
        html += '<div class="value" style="color: #10b981;">' + item.available_capacity + '</div>';
        html += '</div>';
        html += '<div class="report-stat">';
        html += '<div class="label">Fill Rate</div>';
        html += '<div class="value" style="color: ' + (fillPercentage >= 100 ? '#ef4444' : fillPercentage >= 90 ? '#f59e0b' : '#10b981') + ';">' + fillPercentage.toFixed(1) + '%</div>';
        html += '</div>';
        html += '</div>';
        
        // Sections list
        if (item.sections && item.sections.length > 0) {
          html += '<div class="report-sections-list">';
          item.sections.forEach(section => {
            html += '<div class="report-section-item">';
            html += '<div class="section-item-name">' + section.name;
            if (section.is_full) {
              html += ' <span class="badge full" style="margin-left: 8px; font-size: 10px;">FULL</span>';
            }
            html += '</div>';
            html += '<div class="section-item-stats">';
            html += '<span>' + section.current_count + '/' + section.max_capacity + ' students</span>';
            html += '<span>' + section.fill_percentage.toFixed(0) + '%</span>';
            html += '<span style="color: #10b981;">' + section.available_capacity + ' spots left</span>';
            html += '</div>';
            html += '</div>';
          });
          html += '</div>';
        }
        
        html += '</div>'; // End report-section
      });
    }
    
    document.getElementById('capacityReportContent').innerHTML = html;
    document.getElementById('capacityReportModal').style.display = 'flex';
  }
  
  // Close capacity report modal
  function closeCapacityReportModal() {
    document.getElementById('capacityReportModal').style.display = 'none';
  }
  
  // Show alert
  function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    alertContainer.appendChild(alert);
    
    setTimeout(() => {
      alert.remove();
    }, 5000);
  }
  
  // Close modals when clicking outside
  document.getElementById('sectionModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });
  
  document.getElementById('viewModal').addEventListener('click', function(e) {
    if (e.target === this) closeViewModal();
  });
  
  document.getElementById('capacityReportModal').addEventListener('click', function(e) {
    if (e.target === this) closeCapacityReportModal();
  });
</script>
@endpush


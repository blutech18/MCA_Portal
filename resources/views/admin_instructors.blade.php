@extends('layouts.admin_base')

@section('title', 'Admin - Instructors')
@section('header', 'Manage Instructors')

@push('head')
  <link rel="stylesheet" href="{{ asset('css/styles_admin_instructors.css') }}">
  <link rel="stylesheet" href="{{ asset('css/add-student-modal.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .instructors-page .container-users{max-width:1200px;margin:0 auto;padding:12px;box-sizing:border-box;width:100%}
    .instructors-page .profile-box{width:100%}
    .instructors-page .instructors-table{width:100%}
    .instructors-page .table-container{width:100%;overflow:auto}
    .instructors-page #instructor-table{width:100%;border-collapse:collapse}
    
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
      z-index: 9999;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      max-width: 400px;
      width: 90%;
    }

    .confirm-btn, .cancel-btn {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin: 10px;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-size: 14px;
      font-weight: 500;
    }

    .confirm-btn {
      background: #dc3545;
      color: white;
    }

    .confirm-btn:hover {
      background: #c82333;
    }

    .cancel-btn {
      background: #6c757d;
      color: white;
    }

    .cancel-btn:hover {
      background: #5a6268;
    }
  </style>
@endpush

@section('content')
    <div class="instructors-page">

        <div class="container-users">
          <!-- Profile Box Section (Top) -->
          <section class="profile-box">
            <div class="profile-header">
              <h3>Instructor Profile</h3>
              <div class="profile-actions">
                <button class="btn edit-btn">Edit</button>
              </div>
            </div>
            <div class="profile-content">
              <!--<div class="profile-image">
                <img id="profile-pic" alt="Instructor Profile">
              </div>-->
              <div class="profile-details">
                <div class="profile-info-grid">
                  <div class="row">
                    <p><span class="label">Full Name:</span> <span id="profile-fullname">-------</span></p>
                    <p><span class="label">Address:</span> <span id="profile-address">-------</span></p>
                    <p><span class="label">Employment Status:</span> <span id="profile-status">-----</span></p>
                  </div>
                  <div class="row">
                    <p><span class="label">Email:</span> <span id="profile-email">---------</span></p>
                    <p><span class="label">Date of Birth:</span> <span id="profile-dob">---------</span></p>
                    <p><span class="label">Hire Date:</span> <span id="profile-hiredate">---------</span></p>
                  </div>
                  <div class="row">
                    <p><span class="label">Phone Number:</span> <span id="profile-phone">---------</span></p>
                    <p><span class="label">Gender:</span> <span id="profile-gender">---------</span></p>
                  </div>
                </div>
                <div class="credentials-card" style="margin-top:10px;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;padding:10px 12px;">
                  <div style="font-weight:600;color:#334155;margin-bottom:6px;">Login Credentials</div>
                  <div style="font-size:14px;color:#475569;display:flex;gap:20px;flex-wrap:wrap;align-items:center;">
                    <div>Username: <code id="profile-username" style="background:#eef2ff;padding:2px 6px;border-radius:4px;">---</code></div>
                    <div style="display:flex;align-items:center;gap:5px;">
                      Password: <code id="profile-password" style="background:#eef2ff;padding:2px 6px;border-radius:4px;">---</code>
                      <button type="button" id="toggle-password-visibility" style="background:none;border:none;cursor:pointer;padding:2px;border-radius:3px;" title="Toggle password visibility">
                        <svg id="eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;">
                          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                          <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-slash-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                          <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div style="font-size:12px;color:#64748b;margin-top:4px;">Format: username = lastname.instructorID, password = lastnamebirthyear</div>
                </div>
                <!-- Additional Action Buttons -->
                <div class="profile-extra-actions">
                  <button onclick="triggerScheduleModal()" class="btn schedule-btn">Work / Schedules</button>
                  <button class="btn classes-btn">Classes</button>
                </div>
              </div>
            </div>
          </section>
          
          <!-- Instructors Table Section (Below Profile Box) -->
          <section class="instructors-table" style="margin-top: 24px;">
            <div class="subject-box-title" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 20px 24px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(122,34,43,0.15);">
              <div style="display: flex; align-items: center; gap: 14px;">
                <div style="background: rgba(255,255,255,0.15); padding: 10px; border-radius: 8px; backdrop-filter: blur(10px);">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                  </svg>
                </div>
                <div>
                  <p style="margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.3px;">Instructor List</p>
                  <p style="margin: 4px 0 0 0; font-size: 13px; opacity: 0.9;">Manage all instructor accounts and assignments</p>
                </div>
              </div>
              <button class="add-instructor-btn" onclick="triggerAddInstructorModal()" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 8px; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="12" y1="5" x2="12" y2="19"></line>
                  <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Instructor
              </button>
            </div>

            @if(request('new_username') && request('new_password'))
              <div class="credentials-banner" style="margin:12px 0;padding:12px 14px;border:1px solid #bbf7d0;background:#f0fdf4;color:#065f46;border-radius:8px;">
                <strong>Instructor account created.</strong>
                <div style="margin-top:6px;font-size:14px;color:#064e3b;">
                  <div>Username: <code id="banner-username" style="background:#ecfeff;padding:2px 6px;border-radius:4px;">{{ request('new_username') }}</code></div>
                  <div style="display:flex;align-items:center;gap:5px;">
                    Password: <code id="banner-password" style="background:#ecfeff;padding:2px 6px;border-radius:4px;">{{ request('new_password') }}</code>
                    <button type="button" id="toggle-banner-password-visibility" style="background:none;border:none;cursor:pointer;padding:2px;border-radius:3px;" title="Toggle password visibility">
                      <svg id="banner-eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                      </svg>
                      <svg id="banner-eye-slash-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                      </svg>
                    </button>
                  </div>
                  <div style="margin-top:4px;color:#065f46;">Format: username = lastname.instructorID, password = lastnamebirthyear</div>
                </div>
              </div>
            @endif
          
            <div class="search-container" style="background: #fff; padding: 16px 24px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
              <div style="position: relative; max-width: 500px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6c757d" stroke-width="2" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                  <circle cx="11" cy="11" r="8"></circle>
                  <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input
                  type="text"
                  id="instructor-search"
                  class="search-bar2"
                  placeholder="Search by name, email, or ID..."
                  style="width: 100%; padding: 12px 16px 12px 44px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; transition: all 0.2s; background: #f8f9fa;"
                  onfocus="this.style.borderColor='#7a222b'; this.style.background='#fff'; this.style.boxShadow='0 0 0 3px rgba(122,34,43,0.1)'"
                  onblur="this.style.borderColor='#e9ecef'; this.style.background='#f8f9fa'; this.style.boxShadow='none'"
                >
              </div>
            </div>
          
            <div class="table-container" style="background: #fff; border: 1px solid #dee2e6; border-radius: 0 0 12px 12px; overflow: hidden;">
              <table id="instructor-table" style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef); position: sticky; top: 0; z-index: 5;">
                  <tr>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6;">Instructor ID</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6;">Full Name</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6;">Email</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6;">Status</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6;">Hire Date</th>
                  </tr>
                </thead>
                <tbody id="instructor-body">
                  @foreach($instructors as $instr)
                    @php
                      /*$fullname = $instr->first_name . ' ' . ($instr->middle_name ?? '') . ' ' . $instr->last_name . ($instr->suffix ? ', ' . $instr->suffix : '');*/
                      $first = $instr->first_name;
                      $middle= $instr->middle_name;
                      $last  = $instr->last_name;
                      $suf   = $instr->suffix;
                      $schedules = collect($instr->class_payload)
                        ->flatMap(fn($c) => $c['schedules'])
                        ->all();
                      
                    @endphp
                    <tr
                      onclick="populateProfile(this)"
                      data-instructor-id="{{ $instr->instructor_id }}"
                      data-first-name="{{ $first }}"
                      data-middle-name="{{ $middle }}"
                      data-last-name="{{ $last }}"
                      data-suffix="{{ $suf }}"
                      data-fullname="{{ trim($first . ' ' . $middle . ' ' . $last . ' ' . $suf) }}"
                      data-instructor-classes='@json($instr->class_payload)'
                      data-schedules='@json($schedules)'
                      data-email="{{ $instr->email }}"
                      data-status="{{ ucfirst($instr->status) }}"
                      data-hiredate="{{ $instr->job_start_date }}"
                      data-dob="{{ $instr->date_of_birth }}"
                      data-address="{{ $instr->address }}"
                      data-phone="{{ $instr->contact_number }}"
                      data-gender="{{ ucfirst($instr->gender) }}"
                      data-picture="{{ $instr->picture ? asset('storage/'.$instr->picture) : asset('images/default.png') }}"
                      data-username="{{ optional($instr->user)->username }}"
                      data-birthyear="{{ \Carbon\Carbon::parse($instr->date_of_birth)->format('Y') }}"
                      data-lastname="{{ strtolower(preg_replace('/[^a-zA-Z0-9]/','',$instr->last_name)) }}"
                      data-instructor-number="{{ optional($instr->schoolId)->instructor_number }}"
                      data-advisory-section-id="{{ $instr->advisory_section_id }}"
                      style="cursor: pointer; transition: all 0.2s; border-bottom: 1px solid #f1f3f5;"
                      onmouseover="this.style.background='#f8f9fa'; this.style.transform='scale(1.01)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'"
                      onmouseout="this.style.background='#fff'; this.style.transform='scale(1)'; this.style.boxShadow='none'"
                    >
                      <td style="padding: 16px; color: #495057; font-weight: 600; font-family: monospace; font-size: 13px;">
                        <span style="background: #e9ecef; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                          {{ $instr->schoolId->instructor_number ?? 'N/A' }}
                        </span>
                      </td>
                      <td style="padding: 16px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                          <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #7a222b, #922832); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                            {{ strtoupper(substr($first, 0, 1)) }}{{ strtoupper(substr($last, 0, 1)) }}
                          </div>
                          <div>
                            <div style="font-weight: 600; color: #212529; font-size: 14px;">{{ $instr->display_name }}</div>
                            <div style="font-size: 12px; color: #6c757d;">Instructor</div>
                          </div>
                        </div>
                      </td>
                      <td style="padding: 16px; color: #495057; font-size: 14px;">{{ $instr->email }}</td>
                      <td style="padding: 16px;">
                        @php
                          $statusColors = [
                            'active' => ['bg' => '#d1fae5', 'text' => '#065f46', 'icon' => 'check-circle'],
                            'on leave' => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'clock'],
                            'retired' => ['bg' => '#e0e7ff', 'text' => '#3730a3', 'icon' => 'award'],
                            'terminated' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => 'x-circle']
                          ];
                          $status = strtolower($instr->status);
                          $statusColor = $statusColors[$status] ?? ['bg' => '#f3f4f6', 'text' => '#4b5563', 'icon' => 'info'];
                        @endphp
                        <span style="background: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                          </svg>
                          {{ ucfirst($instr->status) }}
                        </span>
                      </td>
                      <td style="padding: 16px; color: #6c757d; font-size: 13px;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                          </svg>
                          {{ \Carbon\Carbon::parse($instr->job_start_date)->format('M d, Y') }}
                        </div>
                      </td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </section>

        </div>
       
        <!-- Schedule Modal -->
        <div id="schedules-overlay" class="overlay">
          <div class="schedule-form">
            <h3>Assign Work Schedules</h3>

            <div class="instructor-info">
              <strong>Instructor:</strong> <span id="schedule-instructor-name">N/A</span>
            </div>

            <!-- List of existing schedules -->
            <div id="existing-schedules-list" class="assigned-classes">
              <strong>Current Schedules:</strong>
              <ul id="schedule-items">
                <!-- Populated by JavaScript -->
              </ul>
            </div>

            <!-- Form to add schedule -->
            <form id="schedule-form" method="POST" action="/admin/instructors/schedules">
              @csrf
              <input type="hidden" name="instructor_id" id="schedule-instructor-id">

              <div class="form-group">
                <label for="schedule-instructor-class-id">Class</label>
                <select
                  name="instructor_class_id"
                  id="schedule-instructor-class-id"
                  required
                ></select>
              </div>

              <div class="form-group">
                <label for="day_of_week">Day of the Week:</label>
                <select name="day_of_week" id="day_of_week" required>
                  <option value="">Select</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                </select>
              </div>

              <div class="form-group">
                <label>Start Time:</label>
                <input type="time" name="start_time" required>
              </div>

              <div class="form-group">
                <label>End Time:</label>
                <input type="time" name="end_time" required>
              </div>

              <div class="form-group">
                <label>Room:</label>
                <input type="text" name="room" required>
              </div>

              <div class="button-group">
                <button type="submit" class="btn save-btn">Save Schedule</button>
                <button type="button" class="btn cancel-btn" id="cancel-schedule">Cancel</button>
              </div>
            </form>
          </div>
        </div>
        
        <div id="assign-classes-overlay" class="overlay" style="display:none">
          <div class="assign-classes-form" style="max-width: 900px; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 24px; border-radius: 12px 12px 0 0; position: relative;">
              <div style="display: flex; align-items: center; gap: 16px;">
                <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
                  <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                  </svg>
                </div>
                <div style="flex: 1;">
                  <h3 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; color: white;">Assign Classes to Instructor</h3>
                  <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">Select and assign classes for this instructor to teach</p>
                </div>
              </div>
              <button type="button" class="close-btn" onclick="document.getElementById('assign-classes-overlay').style.display='none'" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
            </div>

            <div style="padding: 24px; background: #fff;">
              <!-- Instructor Info Card -->
              <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; padding: 20px; margin-bottom: 24px; border-left: 4px solid #7a222b;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                  <strong style="color: #495057; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Instructor</strong>
                </div>
                <span id="instructor-name-display" style="color: #7a222b; font-weight: 700; font-size: 20px; display: block;">N/A</span>
              </div>

              <!-- Currently Assigned Classes Card -->
              <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 10px; padding: 20px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #e9ecef;">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                  </svg>
                  <strong style="color: #212529; font-size: 16px;">Currently Assigned Classes</strong>
                </div>
                <ul id="assigned-classes-list" style="list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto;">
                  <li style="padding: 12px; background: #f8f9fa; border-radius: 6px; color: #6c757d; text-align: center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 6px;">
                      <circle cx="12" cy="12" r="10"></circle>
                      <line x1="12" y1="16" x2="12" y2="12"></line>
                      <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    No classes assigned yet
                  </li>
                </ul>
              </div>

            <!-- Success/Error Notifications -->
            @if(session('success'))
                <div class="alert alert-success" id="assign-success-alert">
                    <button class="alert-close" onclick="closeAlert('assign-success-alert')">&times;</button>
                    <strong>Success!</strong> {!! htmlspecialchars(session('success'), ENT_QUOTES, 'UTF-8') !!}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error" id="assign-error-alert">
                    <button class="alert-close" onclick="closeAlert('assign-error-alert')">&times;</button>
                    <strong>Error!</strong> {!! htmlspecialchars(session('error'), ENT_QUOTES, 'UTF-8') !!}
                </div>
            @endif

            <form id="assign-classes-form" method="POST" action="{{ route('instructors.assign.classes') }}">
              @csrf
              <input type="hidden" name="instructor_id" id="modal-instructor-id">
        
              <div class="form-group">
                <!-- Core Subjects Section -->
                <div class="default-subjects-section" style="margin-bottom: 24px;">
                  <div style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 16px 20px; border-radius: 10px 10px 0 0; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                      </svg>
                      <div>
                        <h4 style="margin: 0; font-size: 18px; font-weight: 600;">Core Subjects</h4>
                        <p style="margin: 2px 0 0 0; font-size: 13px; opacity: 0.9;">Recommended essential classes</p>
                      </div>
                    </div>
                    <button type="button" id="select-all-default" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.2s; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                      </svg>
                      Select All
                    </button>
                  </div>
                  <div style="background: #fff; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 10px 10px; padding: 20px;">
                    <div class="default-subjects-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px;">
                    @php
                        $defaultSubjects = \App\Models\Subject::where('is_default', true)->get();
                        $defaultClassesQuery = \App\Models\SchoolClass::with(['subject','gradeLevel','strand','section']);
                        if ($defaultSubjects->count() > 0) {
                          $defaultClassesQuery->whereIn('subject_id', $defaultSubjects->pluck('id'));
                        }
                        $defaultClasses = $defaultClassesQuery->get();
                        if ($defaultClasses->isEmpty()) {
                          $defaultClasses = \App\Models\SchoolClass::with(['subject','gradeLevel','strand','section'])->get();
                        }
                        $defaultClasses = $defaultClasses->sortBy(function($class) {
                          return ($class->subject->is_default ?? false) ? 0 : 1;
                        });
                    @endphp
                      @forelse($defaultClasses as $course)
                        <label class="default-subject-option" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px; border: 2px solid #e9ecef; border-radius: 8px; cursor: pointer; background: #f8f9fa; transition: all 0.2s;" onmouseover="this.style.borderColor='#7a222b'; this.style.background='#fff'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.1)'" onmouseout="this.style.borderColor='#e9ecef'; this.style.background='#f8f9fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                          <input type="checkbox" name="class_ids[]" value="{{ $course->id }}" style="margin-top: 3px; width: 18px; height: 18px; cursor: pointer; accent-color: #7a222b;">
                          <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                              </svg>
                              <strong style="color: #212529; font-size: 15px;">{{ $course->subject->name ?? 'Unknown Subject' }}</strong>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;">
                              <span style="background: #e7f1ff; color: #0066cc; font-size: 12px; padding: 2px 8px; border-radius: 4px; font-weight: 500;">
                                {{ $course->section->section_name ?? 'N/A' }}
                              </span>
                              <span style="background: #fff4e6; color: #b45309; font-size: 12px; padding: 2px 8px; border-radius: 4px; font-weight: 500;">
                                Grade {{ $course->gradeLevel->name ?? 'Unknown' }}
                              </span>
                              @if($course->strand)
                                <span style="background: #f0fdf4; color: #15803d; font-size: 12px; padding: 2px 8px; border-radius: 4px; font-weight: 500;">
                                  {{ $course->strand->name }}
                                </span>
                              @endif
                            </div>
                          </div>
                        </label>
                      @empty
                        <div style="grid-column: 1 / -1; padding: 24px; text-align: center; background: #fff3cd; border: 1px dashed #ffc107; border-radius: 8px; color: #856404;">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 8px;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                          </svg>
                          <p style="margin: 0; font-weight: 500;">No classes available yet</p>
                          <small>Accept a student to auto-create default classes, or add classes under Admin Dashboard.</small>
                        </div>
                      @endforelse
                    </div>
                  </div>
                </div>
                
                <!-- All Subjects Section -->
                <div class="all-subjects-section">
                  <div style="background: linear-gradient(135deg, #495057 0%, #6c757d 100%); color: white; padding: 16px 20px; border-radius: 10px 10px 0 0; display: flex; align-items: center; gap: 12px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                      <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                      <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                      <line x1="10" y1="9" x2="16" y2="9"></line>
                      <line x1="10" y1="13" x2="16" y2="13"></line>
                    </svg>
                    <div>
                      <h4 style="margin: 0; font-size: 18px; font-weight: 600; color: white;">All Available Subjects</h4>
                      <p style="margin: 2px 0 0 0; font-size: 13px; opacity: 0.9; color: white;">Search and select additional classes (Select2 Dropdown)</p>
                    </div>
                  </div>
                  <div style="background: #fff; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 10px 10px; padding: 20px;">
                    <select id="class_ids" name="class_ids[]" multiple style="width:100%; height: 200px;">
                      @php
                        $allClasses = \App\Models\SchoolClass::with(['subject','gradeLevel','strand','section'])
                          ->get()
                          ->sortBy(function($class) {
                            if ($class->subject->is_default ?? false) {
                              return '0' . ($class->subject->name ?? 'Unknown');
                            }
                            return '1' . ($class->subject->name ?? 'Unknown');
                          });
                      @endphp
                      @foreach($allClasses as $course)
                        <option value="{{ $course->id }}" data-is-default="{{ $course->subject->is_default ?? false ? 'true' : 'false' }}">
                          {{ ($course->subject->is_default ?? false) ? '⭐ ' : '' }}{{ $course->name }} ({{ $course->section->section_name ?? 'N/A' }} —
                          {{ $course->subject->code ?? 'N/A' }} / {{ $course->gradeLevel->name ?? 'Unknown Grade' }}
                          @if($course->strand) / {{ $course->strand->name }} @endif)
                        </option>
                      @endforeach
                    </select>
                    <small style="display: block; margin-top: 10px; color: #6c757d;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                      </svg>
                      Hold Ctrl (Cmd on Mac) to select multiple classes. Use the search box to filter.
                    </small>
                  </div>
                </div>
              </div>
            </div>
        
              <!-- Enhanced Button Group -->
              <div style="background: #f8f9fa; padding: 20px 24px; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn cancel-btn" id="cancel-assign-classes" style="background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                  Cancel
                </button>
                <button type="submit" class="btn save-btn" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; border: none; padding: 10px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(122,34,43,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(122,34,43,0.2)'">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                  </svg>
                  Save Assignments
                </button>
              </div>

            </form>
          </div>
        </div>

        <!-- Notification System -->
        <div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000; max-width: 400px;"></div>

        <!-- Enhanced Add Instructor Modal -->
        <div id="add-instructor-overlay" class="overlay" style="display: none;">
          <div class="add-student-modal">
            <!-- Modal Header -->
            <div class="modal-header">
              <div class="header-content">
                <div class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                  </svg>
                </div>
                <div class="header-text">
                  <h2>Add New Instructor</h2>
                  <p>Register a new instructor in the system</p>
                </div>
              </div>
              <button type="button" class="close-btn" id="cancel-add-instructor">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              <form action="{{ route('admin_instructors.store') }}" method="POST" enctype="multipart/form-data" id="add-instructor-form">
                @csrf
                <div class="form-sections">
                  
                  <!-- Section 1: Personal Information -->
                  <div class="form-section">
                    <div class="section-header">
                      <h3>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                          <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Personal Information
                      </h3>
                    </div>
                    <div class="form-grid">
                      <div class="form-group">
                        <label class="required">Instructor ID</label>
                        <input type="text" value="Auto-generated (INS-YYYY-XXX)" readonly>
                        <small class="form-help">ID will be auto-generated upon submission</small>
                      </div>

                      <div class="form-group">
                        <label for="first_name" class="required">First Name</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required autocomplete="given-name" value="{{ old('first_name') }}">
                        @if(isset($errors) && $errors->has('first_name'))
                          <div class="error-message">{{ $errors->first('first_name') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" placeholder="Enter middle name (optional)" autocomplete="additional-name" value="{{ old('middle_name') }}">
                        @if(isset($errors) && $errors->has('middle_name'))
                          <div class="error-message">{{ $errors->first('middle_name') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="last_name" class="required">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required autocomplete="family-name" value="{{ old('last_name') }}">
                        @if(isset($errors) && $errors->has('last_name'))
                          <div class="error-message">{{ $errors->first('last_name') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="suffix">Suffix</label>
                        <select id="suffix" name="suffix">
                          <option value="">None</option>
                          <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                          <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                          <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                          <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                          <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                        </select>
                        @if(isset($errors) && $errors->has('suffix'))
                          <div class="error-message">{{ $errors->first('suffix') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label class="required">Gender</label>
                        <div class="radio-group">
                          <label class="radio-label">
                            <input type="radio" name="gender" value="male" required {{ old('gender') == 'male' ? 'checked' : '' }}>
                            <span class="radio-custom"></span>
                            Male
                          </label>
                          <label class="radio-label">
                            <input type="radio" name="gender" value="female" required {{ old('gender') == 'female' ? 'checked' : '' }}>
                            <span class="radio-custom"></span>
                            Female
                          </label>
                        </div>
                        @if(isset($errors) && $errors->has('gender'))
                          <div class="error-message">{{ $errors->first('gender') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="date_of_birth" class="required">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required autocomplete="bday" value="{{ old('date_of_birth') }}">
                        @if(isset($errors) && $errors->has('date_of_birth'))
                          <div class="error-message">{{ $errors->first('date_of_birth') }}</div>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Section 2: Contact Information -->
                  <div class="form-section">
                    <div class="section-header">
                      <h3>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Contact Information
                      </h3>
                    </div>
                    <div class="form-grid">
                      <div class="form-group">
                        <label for="email" class="required">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="instructor@example.com" required autocomplete="email" value="{{ old('email') }}">
                        @if(isset($errors) && $errors->has('email'))
                          <div class="error-message">{{ $errors->first('email') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label for="contact_number" class="required">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" placeholder="09XX XXX XXXX" required autocomplete="tel" value="{{ old('contact_number') }}">
                        @if(isset($errors) && $errors->has('contact_number'))
                          <div class="error-message">{{ $errors->first('contact_number') }}</div>
                        @endif
                      </div>

                      <div class="form-group full-width">
                        <label for="address" class="required">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter complete address" required autocomplete="street-address" value="{{ old('address') }}">
                        @if(isset($errors) && $errors->has('address'))
                          <div class="error-message">{{ $errors->first('address') }}</div>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Section 3: Employment Information -->
                  <div class="form-section">
                    <div class="section-header">
                      <h3>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                          <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        Employment Information
                      </h3>
                    </div>
                    <div class="form-grid">
                      <div class="form-group">
                        <label for="job_start_date" class="required">Job Start Date</label>
                        <input type="date" id="job_start_date" name="job_start_date" required value="{{ old('job_start_date') }}">
                        @if(isset($errors) && $errors->has('job_start_date'))
                          <div class="error-message">{{ $errors->first('job_start_date') }}</div>
                        @endif
                      </div>

                      <div class="form-group">
                        <label>Status</label>
                        <input type="text" value="Active" readonly>
                        <input type="hidden" name="status" value="active">
                        <small class="form-help">New instructors are set to active by default</small>
                      </div>

                      <div class="form-group">
                        <label for="advisory_section_id">Advisory Section (Optional)</label>
                        <select id="advisory_section_id" name="advisory_section_id">
                          <option value="">-- None --</option>
                          @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ old('advisory_section_id') == $section->id ? 'selected' : '' }}>
                              {{ $section->section_name }} 
                              (Grade {{ $section->gradeLevel->name ?? $section->grade_level_id }}
                              @if($section->strand) - {{ $section->strand->name }} @endif)
                            </option>
                          @endforeach
                        </select>
                        <small class="form-help">Assign this instructor as adviser to a specific section</small>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
              <div class="footer-info">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                  <path d="m9 12 2 2 4-4"></path>
                </svg>
                <span>Instructor credentials will be auto-generated upon submission</span>
              </div>
              <div class="footer-actions">
                <button type="button" class="btn btn-secondary" onclick="closeInstructorModal()">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                  Cancel
                </button>
                <button type="submit" form="add-instructor-form" class="btn btn-primary">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                  </svg>
                  Add Instructor
                </button>
              </div>
            </div>

          </div>
        </div>

        <!-- Enhanced Edit Instructor Modal -->
        <div id="editInstructorOverlay" class="overlay" style="display: none;">
          <div class="add-student-modal">
            <!-- Modal Header -->
            <div class="modal-header">
              <div class="header-content">
                <div class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </div>
                <div class="header-text">
                  <h2>Edit Instructor</h2>
                  <p>Update instructor information in the system</p>
                </div>
              </div>
              <button type="button" class="close-btn" id="cancel-edit-instructor">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              <form id="editInstructorForm" method="POST" action="">
                @csrf
                @method('PUT')

                {{-- we'll set this value via JS --}}
                <input type="hidden" name="instructor_id" id="edit_instructor_id">

                <div class="edit-instructor-info-container">
                  <div class="edit-info-container">
                    <div class="form-group1">
                      <label for="edit_first_name">First Name:</label>
                      <input type="text" id="edit_first_name" name="first_name" required>
                    </div>
                    <div class="form-group1">
                      <label for="edit_middle_name">Middle Name:</label>
                      <input type="text" id="edit_middle_name" name="middle_name">
                    </div>
                    <div class="form-group1">
                      <label for="edit_last_name">Last Name:</label>
                      <input type="text" id="edit_last_name" name="last_name" required>
                    </div>
                    <div class="form-group1">
                      <label for="edit_suffix">Suffix:</label>
                      <input type="text" id="edit_suffix" name="suffix">
                    </div>
      
                    <div class="form-group">
                      <label for="edit_email">Email:</label>
                      <input type="email" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_gender">Gender:</label>
                      <select id="edit_gender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="edit-info-container">
                    <div class="form-group">
                      <label for="edit_dob">Date of Birth:</label>
                      <input type="date" id="edit_dob" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_contact">Contact #:</label>
                      <input type="text" id="edit_contact" name="contact_number" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_address">Address:</label>
                      <input type="text" id="edit_address" name="address" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_hiredate">Hire Date:</label>
                      <input type="date" id="edit_hiredate" name="job_start_date" required>
                    </div>
                    <div class="form-group">
                      <label for="edit_status">Status:</label>
                      <select id="edit_status" name="status" required>
                        <option value="active">Active</option>
                        <option value="on leave">On Leave</option>
                        <option value="retired">Retired</option>
                        <option value="terminated">Terminated</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="edit_advisory_section_id">Advisory Section:</label>
                      <select id="edit_advisory_section_id" name="advisory_section_id">
                        <option value="">-- None --</option>
                        @foreach($sections as $section)
                          <option value="{{ $section->id }}">
                            {{ $section->section_name }}
                            (Grade {{ $section->gradeLevel->name ?? $section->grade_level_id }}
                            @if($section->strand) - {{ $section->strand->name }} @endif)
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="button-group">
                  <button type="submit" class="btn save-btn">Save Changes</button>
                  <button type="button" class="btn cancel-btn" id="cancel-edit-instructor-btn">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>

    </div>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal">
      <div class="modal-content">
          <p>Are you sure you want to log out?</p>
          <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
          <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    @if(request('new_username') && request('new_password'))
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Show only once per create action, then clean URL and set a session flag
        const shownKey = 'instructorAccountModalShown';
        if (!sessionStorage.getItem(shownKey)) {
          const modal = document.getElementById("accountModal");
          if (modal) {
            modal.style.display = "flex";
            sessionStorage.setItem(shownKey, '1');
            // Remove query params so refresh doesn't re-trigger
            if (window.history && window.history.replaceState) {
              const cleanUrl = window.location.origin + window.location.pathname;
              window.history.replaceState({}, document.title, cleanUrl);
            }
          }
        }
      });
    </script>

      <div id="accountModal" class="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div class="add-student-modal" style="max-width: 500px; width: 90%; margin: 0 auto;">
          <div class="modal-header">
            <div class="header-content">
              <div class="icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </div>
              <div class="header-text">
                <h2>Instructor Account Created</h2>
                <p>Credentials generated successfully</p>
              </div>
            </div>
            <button type="button" class="close-btn" onclick="document.getElementById('accountModal').style.display='none'; sessionStorage.removeItem('instructorAccountModalShown');">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </button>
          </div>

          <div class="modal-body">
            <div class="student-form" style="padding-top:0">
              <div class="form-sections">
                <div class="form-section" style="padding:0">
                  <div class="form-grid">
                    <div class="form-group">
                      <label>Username</label>
                      <code id="modal-username" style="background:#eef2ff;padding:6px 8px;border-radius:6px;display:inline-block;">{{ request('new_username') }}</code>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <div style="display:flex;align-items:center;gap:8px;">
                        <code id="modal-password" style="background:#eef2ff;padding:6px 8px;border-radius:6px;">{{ request('new_password') }}</code>
                        <button type="button" id="toggle-modal-password-visibility" class="btn btn-sm" title="Toggle password visibility" style="padding:6px 8px;">
                          <svg id="modal-eye-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                          </svg>
                          <svg id="modal-eye-slash-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                          </svg>
                        </button>
                        <button type="button" class="btn btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('modal-password').getAttribute('data-actual-password')||document.getElementById('modal-password').textContent)" title="Copy password" style="padding:6px 8px;">
                          Copy
                        </button>
                      </div>
                    </div>
                  </div>
                  <small class="form-help">Share these credentials securely with the instructor.</small>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <div class="footer-actions">
              <button type="button" class="btn btn-primary" onclick="document.getElementById('accountModal').style.display='none'; sessionStorage.removeItem('instructorAccountModalShown');">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endif


    <script>
      function displayInstructor(name, email, phone, address, dob, gender, status, hiredate, specialization, profilePic) {
        document.getElementById("profile-name").textContent = name;
        document.getElementById("profile-email").textContent = email;
        document.getElementById("profile-phone").textContent = phone;
        document.getElementById("profile-address").textContent = address;
        document.getElementById("profile-dob").textContent = dob;
        document.getElementById("profile-gender").textContent = gender;
        document.getElementById("profile-status").textContent = status;
        document.getElementById("profile-hiredate").textContent = hiredate;
        document.getElementById("profile-specialization").textContent = specialization;
        document.getElementById("profile-pic").src = profilePic;
      }
    </script>
      <script>
        function populateProfile(tr) {
          const fullname = `${tr.dataset.lastName ? (tr.dataset.lastName.charAt(0).toUpperCase()+tr.dataset.lastName.slice(1)) : ''}, ${tr.dataset.firstName || ''}`.trim();
          document.getElementById('profile-fullname').textContent = tr.getAttribute('data-first-name') + ' ' + (tr.getAttribute('data-middle-name')||'') + ' ' + tr.getAttribute('data-last-name');
          document.getElementById('profile-address').textContent = tr.getAttribute('data-address');
          document.getElementById('profile-status').textContent = tr.getAttribute('data-status');
          document.getElementById('profile-email').textContent = tr.getAttribute('data-email');
          document.getElementById('profile-dob').textContent = tr.getAttribute('data-dob');
          document.getElementById('profile-hiredate').textContent = tr.getAttribute('data-hiredate');
          document.getElementById('profile-phone').textContent = tr.getAttribute('data-phone');
          document.getElementById('profile-gender').textContent = tr.getAttribute('data-gender');

          // Credentials
          const uname = tr.getAttribute('data-username') || '';
          const lname = tr.getAttribute('data-lastname') || '';
          const byear = tr.getAttribute('data-birthyear') || '';
          const instructorNumber = tr.getAttribute('data-instructor-number') || '';
          
          // Use the actual username from database if available, otherwise construct it
          let displayUsername = '';
          if (uname && uname.trim() !== '') {
            // Use the actual username from the database (most reliable)
            displayUsername = uname;
          } else if (lname && instructorNumber && instructorNumber !== 'N/A') {
            // Fallback: construct username from parts
            displayUsername = lname + '.' + instructorNumber;
          } else {
            displayUsername = '---';
          }
          
          // Construct password: lastname + birthyear
          const pwd = lname && byear ? (lname + byear) : '';
          
          document.getElementById('profile-username').textContent = displayUsername;
          
          // Store the actual password and display masked version
          const passwordElement = document.getElementById('profile-password');
          passwordElement.textContent = pwd ? '••••••••' : '---';
          passwordElement.setAttribute('data-actual-password', pwd || '');
          
          // Reset password visibility to masked
          const eyeIcon = document.getElementById('eye-icon');
          const eyeSlashIcon = document.getElementById('eye-slash-icon');
          if (eyeIcon && eyeSlashIcon) {
            eyeIcon.style.display = 'inline';
            eyeSlashIcon.style.display = 'none';
          }
        }
      </script>
    <script>
      function toggleSubMenu(event) {
        event.preventDefault();
        const submenu = event.target.nextElementSibling;
        submenu.classList.toggle('hidden');
      }

      // Password visibility toggle functionality
      function togglePasswordVisibility(passwordElementId, eyeIconId, eyeSlashIconId) {
        const passwordElement = document.getElementById(passwordElementId);
        const eyeIcon = document.getElementById(eyeIconId);
        const eyeSlashIcon = document.getElementById(eyeSlashIconId);
        
        if (!passwordElement || !eyeIcon || !eyeSlashIcon) return;
        
        const actualPassword = passwordElement.getAttribute('data-actual-password') || '';
        
        if (passwordElement.textContent === '••••••••') {
          // Show password
          passwordElement.textContent = actualPassword;
          eyeIcon.style.display = 'none';
          eyeSlashIcon.style.display = 'inline';
        } else {
          // Hide password
          passwordElement.textContent = '••••••••';
          eyeIcon.style.display = 'inline';
          eyeSlashIcon.style.display = 'none';
        }
      }

      // Initialize password visibility toggles
      document.addEventListener('DOMContentLoaded', function() {
        // Profile password toggle
        const profileToggle = document.getElementById('toggle-password-visibility');
        if (profileToggle) {
          profileToggle.addEventListener('click', function() {
            togglePasswordVisibility('profile-password', 'eye-icon', 'eye-slash-icon');
          });
        }

        // Banner password toggle
        const bannerToggle = document.getElementById('toggle-banner-password-visibility');
        if (bannerToggle) {
          // Store the actual password for the banner
          const bannerPassword = document.getElementById('banner-password');
          if (bannerPassword) {
            const actualPassword = bannerPassword.textContent;
            bannerPassword.textContent = '••••••••';
            bannerPassword.setAttribute('data-actual-password', actualPassword);
            
            bannerToggle.addEventListener('click', function() {
              togglePasswordVisibility('banner-password', 'banner-eye-icon', 'banner-eye-slash-icon');
            });
          }
        }

        // If we were redirected with new_username/new_password, rebuild them from the table row to avoid any truncation
        const bannerUsernameEl = document.getElementById('banner-username');
        if (bannerUsernameEl) {
          const newUname = bannerUsernameEl.textContent.trim();
          const parts = newUname.split('.');
          if (parts.length === 2) {
            const instrNum = parts[1];
            const row = document.querySelector(`tr[data-instructor-number="${instrNum}"]`);
            if (row) {
              const lname = row.getAttribute('data-lastname') || '';
              const byear = row.getAttribute('data-birthyear') || '';
              // Rebuild username and password from reliable row data
              const rebuiltUsername = (lname && instrNum) ? `${lname}.${instrNum}` : newUname;
              const rebuiltPassword = (lname && byear) ? `${lname}${byear}` : (document.getElementById('banner-password').getAttribute('data-actual-password') || '');
              bannerUsernameEl.textContent = rebuiltUsername;
              const bannerPwdEl = document.getElementById('banner-password');
              if (bannerPwdEl) {
                bannerPwdEl.setAttribute('data-actual-password', rebuiltPassword);
              }
            }
          }
        }

        // Modal password toggle
        const modalToggle = document.getElementById('toggle-modal-password-visibility');
        if (modalToggle) {
          // Store the actual password for the modal
          const modalPassword = document.getElementById('modal-password');
          if (modalPassword) {
            const actualPassword = modalPassword.textContent;
            modalPassword.textContent = '••••••••';
            modalPassword.setAttribute('data-actual-password', actualPassword);
            
            modalToggle.addEventListener('click', function() {
              togglePasswordVisibility('modal-password', 'modal-eye-icon', 'modal-eye-slash-icon');
            });
          }
        }
      });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(function () {
        $('#class_ids').select2({
          closeOnSelect: false,
          placeholder: "Select classes",
          width: '100%'
        });
      });

      window.deleteScheduleUrl = "{{ route('instructors.schedule.delete', ['schedule' => '##ID##']) }}";
      window.updateInstructorUrl = @json(
        route('admin.instructors.update', ['instructor' => '__ID__'])
      );
      console.log("📍 template URL:", window.updateInstructorUrl);
          </script>

    <script src="{{ asset('js/script_admin_instructors.js') }}"></script>

    <!-- Logout Confirmation Modal -->
    <div id="confirm-modal" class="modal" style="display: none;">
      <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
        <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>
@endsection


@php
use Illuminate\Support\Facades\Storage;
@endphp

<style>
.enrollee-modal-wrapper {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  max-height: 85vh;
  display: flex;
  flex-direction: column;
}

.enrollee-modal-header {
  background: linear-gradient(135deg, #1f3f49, #2c5a6b);
  color: white;
  padding: 20px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 3px solid #f8d210;
}

.enrollee-modal-header h3 {
  margin: 0;
  font-size: 20px;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.enrollee-modal-body {
  padding: 24px;
  overflow-y: auto;
  max-height: calc(85vh - 80px);
}

.enrollee-section {
  margin-bottom: 24px;
  padding: 16px;
  background: #f8f9fa;
  border-radius: 8px;
  border-left: 4px solid #1f3f49;
}

.enrollee-section h4 {
  margin: 0 0 12px 0;
  font-size: 16px;
  font-weight: 700;
  color: #1f3f49;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.enrollee-section p {
  margin: 8px 0;
  padding: 4px 0;
  font-size: 14px;
  line-height: 1.6;
}

.enrollee-section p span.font-medium {
  font-weight: 600;
  color: #2c5a6b;
  display: inline-block;
  min-width: 150px;
}

/* Assessment Information Modal Styling */
.assessment-info-modal {
  background: #e8f4fd;
  border: 2px solid #3498db;
  border-radius: 8px;
  padding: 15px;
  margin: 10px 0;
}

.assessment-recommended-strand {
  background: #3498db;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-weight: 600;
  margin: 0 8px;
}

.strand-override-badge {
  background: #e74c3c;
  color: white;
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 12px;
  margin-left: 8px;
}

.strand-match-badge {
  background: #27ae60;
  color: white;
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 12px;
  margin-left: 8px;
}

.assessment-details {
  margin-top: 10px;
}

.assessment-details summary {
  cursor: pointer;
  font-weight: 600;
  color: #2c5a6b;
  padding: 5px 0;
}

.assessment-details ul {
  margin: 10px 0 0 20px;
  padding: 0;
}

.assessment-details li {
  margin: 5px 0;
  font-size: 14px;
}

.modal-close-button {
  background: rgba(255, 255, 255, 0.2);
  border: 2px solid white;
  color: white;
  padding: 8px 20px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 8px;
}

.modal-close-button:hover {
  background: white;
  color: #1f3f49;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.enrollee-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 20px;
}

.document-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 16px;
  margin-top: 16px;
}

.document-item {
  padding: 12px;
  background: white;
  border-radius: 6px;
  border: 1px solid #e5e7eb;
  text-align: center;
}

.document-item h5 {
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 8px;
  color: #374151;
}

.document-item a {
  color: #2563eb;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
}

.document-item a:hover {
  text-decoration: underline;
}
</style>

<div class="enrollee-modal-wrapper">
  {{-- Header --}}
  <div class="enrollee-modal-header">
    <h3>📋 New Student Enrollee Details</h3>
    <button class="modal-close modal-close-button" aria-label="Close">
      <span>✕</span>
      <span>Close</span>
    </button>
  </div>

  {{-- Body --}}
  <div class="enrollee-modal-body">
    <div class="enrollee-grid">
      {{-- Personal Information --}}
      <div class="enrollee-section">
        <h4>👤 Personal Information</h4>
        <p><span class="font-medium">Full Name:</span> {{ $enrollee->display_name }}</p>
        @php
          // Deterministic student number: yy + 5-digit enrollee ID
          $studentNumber = sprintf('%02d%05d', (int) now()->format('y'), (int) $enrollee->id);
        @endphp
        @if(($enrollee->status ?? 'pending') === 'accepted')
          <p><span class="font-medium">Student ID:</span> {{ $studentNumber }}</p>
        @endif
        <p><span class="font-medium">LRN:</span> {{ $enrollee->lrn }}</p>
        <p><span class="font-medium">Date of Birth:</span> {{ $enrollee->dob }}</p>
        <p><span class="font-medium">Gender:</span> {{ ucfirst($enrollee->gender) }}</p>
        <p><span class="font-medium">Nationality:</span> {{ $enrollee->nationality }}</p>
        <p><span class="font-medium">Religion:</span> {{ $enrollee->religion }}</p>
      </div>

      {{-- Contact & Address --}}
      <div class="enrollee-section">
        <h4>📞 Contact & Address</h4>
        <p><span class="font-medium">Contact No.:</span> {{ $enrollee->contact_no }}</p>
        <p><span class="font-medium">Email:</span> {{ $enrollee->email }}</p>
        <p><span class="font-medium">Address:</span> {{ $enrollee->address }}</p>
        <p><span class="font-medium">Living With:</span> {{ $enrollee->living_with }}</p>
      </div>

      {{-- Academic Information --}}
      <div class="enrollee-section">
        <h4>🎓 Academic Information</h4>
        <p><span class="font-medium">Strand:</span> {{ $enrollee->strand ?? '–' }}</p>
        @if($enrollee->assessmentResult)
        <div class="assessment-info-modal">
          <p><span class="font-medium">Assessment Recommendation:</span> 
            <span class="assessment-recommended-strand">{{ $enrollee->assessmentResult->recommended_strand }}</span>
            @if($enrollee->strand && $enrollee->strand !== $enrollee->assessmentResult->recommended_strand)
              <span class="strand-override-badge" title="Student chose different strand than recommended">⚠️ Override</span>
            @elseif($enrollee->strand)
              <span class="strand-match-badge" title="Student followed assessment recommendation">✅ Followed</span>
            @endif
          </p>
          <p><span class="font-medium">Assessment Score:</span> {{ $enrollee->assessmentResult->scores[$enrollee->assessmentResult->recommended_strand] }}/25 ({{ number_format($enrollee->assessmentResult->getScorePercentage(), 1) }}%)</p>
          <p><span class="font-medium">Assessment Date:</span> {{ $enrollee->assessmentResult->completed_at->format('M d, Y \a\t g:i A') }}</p>
          <details class="assessment-details">
            <summary>View All Strand Scores</summary>
            <ul style="margin-top: 10px; padding-left: 20px;">
              @foreach($enrollee->assessmentResult->getAllScorePercentages() as $strandName => $percentage)
              <li><strong>{{ $strandName }}:</strong> {{ $percentage }}%</li>
              @endforeach
            </ul>
          </details>
        </div>
        @endif
        <p><span class="font-medium">Semester:</span> {{ $enrollee->semester ?? '–' }}</p>
        <p><span class="font-medium">Former School:</span> {{ $enrollee->former_school }}</p>
        <p><span class="font-medium">Grade Level:</span> 
          @if($enrollee->shs_grade)
              {{ $enrollee->shs_grade }}
          @else
              {{ $enrollee->previous_grade }}
          @endif
        </p>
        <p><span class="font-medium">Last School Year:</span> {{ $enrollee->last_school_year }}</p>
        <p><span class="font-medium">School Type:</span> {{ $enrollee->school_type }}</p>
        <p><span class="font-medium">School Address:</span> {{ $enrollee->school_address }}</p>
        <p><span class="font-medium">Reason for Transfer:</span> {{ $enrollee->reason_transfer }}</p>
      </div>

      {{-- Family Information --}}
      <div class="enrollee-section">
        <h4>👨‍👩‍👧‍👦 Family Information</h4>
        <p><span class="font-medium">Father:</span> {{ $enrollee->father_name }} ({{ $enrollee->father_occupation }}) – {{ $enrollee->father_contact_no }}, {{ $enrollee->father_email }}</p>
        <p><span class="font-medium">Mother:</span> {{ $enrollee->mother_name }} ({{ $enrollee->mother_occupation }}) – {{ $enrollee->mother_contact_no }}, {{ $enrollee->mother_email }}</p>
        <p><span class="font-medium">Guardian:</span> {{ $enrollee->guardian_name }} ({{ $enrollee->guardian_occupation }}) – {{ $enrollee->guardian_contact_no }}, {{ $enrollee->guardian_email }}</p>
        <p><span class="font-medium">Siblings:</span> {{ $enrollee->siblings ?? '–' }}</p>
        <p><span class="font-medium">Working Student:</span> {{ $enrollee->working_student ? 'Yes' : 'No' }}</p>
        <p><span class="font-medium">Intend Working:</span> {{ $enrollee->intend_working_student ? 'Yes' : 'No' }}</p>
        <p><span class="font-medium">Club Member:</span> {{ $enrollee->club_member ? $enrollee->club_name : 'No' }}</p>
      </div>
    </div>

    {{-- Medical Information --}}
    <div class="enrollee-section">
      <h4>🏥 Medical Information</h4>
      <p><span class="font-medium">Medical History:</span> {{ $enrollee->medical_history ?? '–' }}</p>
      <p><span class="font-medium">Allergy:</span> {{ $enrollee->allergy_specify ?? '–' }}</p>
      <p><span class="font-medium">Other Conditions:</span> {{ $enrollee->others_specify ?? '–' }}</p>
    </div>

    {{-- Documents --}}
    <div class="enrollee-section">
      <h4>📄 Documents</h4>
      <div class="document-grid">
        @foreach([
          'report_card_path'       => 'Report Card',
          'good_moral_path'        => 'Good Moral',
          'birth_certificate_path' => 'Birth Certificate',
        ] as $field => $label)
          <div class="document-item">
            <h5>{{ $label }}</h5>
            @if($enrollee->$field && Storage::disk('public')->exists($enrollee->$field))
              <div style="display: flex; flex-direction: column; gap: 6px;">
                <button 
                  type="button"
                  onclick="viewDocument('{{ Storage::url($enrollee->$field) }}', '{{ $label }}')"
                  style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s;"
                  onmouseover="this.style.background='#2563eb'"
                  onmouseout="this.style.background='#3b82f6'"
                >👁️ View</button>
                <a 
                  href="{{ Storage::url($enrollee->$field) }}" 
                  download
                  style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; text-align: center; text-decoration: none; transition: all 0.2s; display: block;"
                  onmouseover="this.style.background='#059669'"
                  onmouseout="this.style.background='#10b981'"
                >📥 Download</a>
              </div>
            @elseif($enrollee->$field)
              <span style="color: #dc2626; font-size: 12px;">❌ File missing</span>
            @else
              <span style="color: #6b7280;">–</span>
            @endif
          </div>
        @endforeach

        {{-- ID Picture --}}
        <div class="document-item">
          <h5>ID Picture</h5>
          @if($enrollee->id_picture_path && Storage::disk('public')->exists($enrollee->id_picture_path))
            <div style="display: flex; flex-direction: column; gap: 6px; align-items: center;">
              <img 
                src="{{ Storage::url($enrollee->id_picture_path) }}"
                alt="ID Picture"
                style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 2px solid #e5e7eb;"
              >
              <button 
                type="button"
                onclick="viewDocument('{{ Storage::url($enrollee->id_picture_path) }}', 'ID Picture')"
                style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s; width: 100%;"
                onmouseover="this.style.background='#2563eb'"
                onmouseout="this.style.background='#3b82f6'"
              >👁️ View Full Size</button>
            </div>
          @elseif($enrollee->id_picture_path)
            <span style="color: #dc2626; font-size: 12px;">❌ Image missing</span>
          @else
            <span style="color: #6b7280;">–</span>
          @endif
        </div>
      </div>
    </div>

    {{-- Payment Info --}}
    <div class="enrollee-section">
      <h4>💳 Payment Information</h4>
      <p><span class="font-medium">Applicant Name:</span> {{ $enrollee->payment_applicant_name ?? '–' }}</p>
      <p><span class="font-medium">Reference #:</span> {{ $enrollee->payment_reference ?? '–' }}</p>
      <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <div>
          <span class="font-medium">Payment Status:</span>
          <form id="payment-status-form" onsubmit="return false;" style="display:inline-block; margin-left:8px;">
            <select id="payment-status-select" name="payment_status" style="padding:6px 8px; border:1px solid #d1d5db; border-radius:6px;">
              @php $ps = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification'); @endphp
              <option value="Pending Verification" {{ $ps === 'Pending Verification' ? 'selected' : '' }}>Pending Verification</option>
              <option value="Verified" {{ $ps === 'Verified' ? 'selected' : '' }}>Verified</option>
              <option value="Invalid" {{ $ps === 'Invalid' ? 'selected' : '' }}>Invalid</option>
              <option value="Rejected" {{ $ps === 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="button" id="save-payment-status" onclick="updatePaymentStatus('{{ $enrollee->id }}', 'new')" style="margin-left:8px; padding:6px 10px; background:#2563eb; color:#fff; border:none; border-radius:6px; cursor:pointer;">Save</button>
          </form>
        </div>
        <div id="payment-status-meta" style="font-size:12px; color:#6b7280;">
          @if($enrollee->payment_status_changed_at)
            Updated {{ $enrollee->payment_status_changed_at->diffForHumans() }} by {{ $enrollee->payment_status_changed_by ?? '—' }}
          @endif
        </div>
      </div>
      @if($enrollee->payment_receipt_path && Storage::disk('public')->exists($enrollee->payment_receipt_path))
        <p>
          <span class="font-medium">Receipt:</span>
          <div style="display: inline-flex; gap: 8px; margin-left: 8px;">
            <button 
              type="button"
              onclick="viewDocument('{{ Storage::url($enrollee->payment_receipt_path) }}', 'Payment Receipt')"
              style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s;"
              onmouseover="this.style.background='#2563eb'"
              onmouseout="this.style.background='#3b82f6'"
            >👁️ View</button>
            <a 
              href="{{ Storage::url($enrollee->payment_receipt_path) }}" 
              download
              style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none; transition: all 0.2s; display: inline-block;"
              onmouseover="this.style.background='#059669'"
              onmouseout="this.style.background='#10b981'"
            >📥 Download</a>
          </div>
        </p>
      @elseif($enrollee->payment_receipt_path)
        <p>
          <span class="font-medium">Receipt:</span>
          <span style="color: #dc2626; font-size: 13px;">❌ File missing</span>
        </p>
      @endif
      
      @php $isPaymentVerified = ($enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification')) === 'Verified'; @endphp
      @if(!$isPaymentVerified)
        <div style="margin-top: 12px; padding: 12px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 6px;">
          <p style="font-size: 13px; color: #92400e; margin: 0;">
            <strong>⚠ Payment Verification Required:</strong> This enrollee cannot be accepted until payment is verified.
          </p>
        </div>
      @endif
    </div>

    {{-- Status Info --}}
    <div class="enrollee-section">
      <h4>📊 Application Status</h4>
      <p><span class="font-medium">Status:</span> 
        <span class="status-badge status-{{ $enrollee->status ?? 'pending' }}">
          {{ ucfirst($enrollee->status ?? 'pending') }}
        </span>
      </p>
      @if($enrollee->decline_reason)
        <p><span class="font-medium">Decline Reason:</span> {{ $enrollee->decline_reason }}</p>
      @endif
      @if($enrollee->status_updated_at)
        <p><span class="font-medium">Status Updated:</span> {{ $enrollee->status_updated_at->format('F j, Y @ H:i') }}</p>
      @endif
    </div>

    {{-- Student Login Credentials (only show if accepted) --}}

    {{-- Section Assignment Info (only show if accepted) --}}
    @if(($enrollee->status ?? 'pending') === 'accepted')
    <div class="enrollee-section">
      <h4>🏫 Section Assignment</h4>
      
      @php
        // Get student section info if exists
        $student = \App\Models\Student::where('email', $enrollee->email)->first();
        $sectionInfo = '';
        $sectionCapacity = '';
        
        if ($student && $student->section) {
          $sectionInfo = $student->section->section_name;
          
          // Count students in this section
          $studentCount = \App\Models\Student::where('section_id', $student->section_id)
            ->where('grade_level_id', $student->grade_level_id)
            ->count();
          $sectionCapacity = "({$studentCount}/25 students)";
        }
      @endphp
      
      @if($sectionInfo)
        <div style="background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; padding: 16px; margin-top: 12px;">
            <p style="font-size: 14px; color: #1e40af; margin: 0 0 12px 0;"><strong>✓ Student automatically assigned to section!</strong></p>
            <div style="background: white; border-radius: 6px; border: 1px solid #93c5fd; padding: 12px;">
                <p style="font-weight: 600; color: #374151; margin: 8px 0;">Section: <span style="font-weight: 700;">{{ $sectionInfo }}</span></p>
                <p style="font-size: 13px; color: #6b7280; margin: 8px 0;">Capacity: {{ $sectionCapacity }}</p>
                <div style="font-size: 12px; color: #9ca3af; margin-top: 8px;">
                    <p style="margin: 4px 0;"><strong>Assignment Logic:</strong> First-come, first-served basis</p>
                    <p style="margin: 4px 0;"><strong>Capacity:</strong> Maximum 25 students per section</p>
                </div>
            </div>
        </div>
      @else
        <div style="background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 16px; margin-top: 12px;">
            <p style="font-size: 14px; color: #92400e; margin: 0;"><strong>⚠ Section assignment pending or failed.</strong></p>
            <p style="font-size: 12px; color: #b45309; margin: 8px 0 0 0;">Check logs for section capacity or availability issues.</p>
        </div>
      @endif
    </div>
    @endif

    {{-- Login Credentials for School Registrar (only show if accepted) --}}
    @if(($enrollee->status ?? 'pending') === 'accepted')
    <div class="enrollee-section">
      <h4>🔑 Student Login Credentials</h4>
      
      @php
        // Get generated credentials if student account exists
        // Try multiple ways to find the student record WITH user relationship
        $student = null;
        
        // First try by LRN (most reliable for new students)
        if (!empty($enrollee->lrn)) {
            $student = \App\Models\Student::with('user')->where('lrn', $enrollee->lrn)->first();
        }
        
        // If not found, try by email
        if (!$student && !empty($enrollee->email)) {
            $student = \App\Models\Student::with('user')->where('email', $enrollee->email)->first();
        }
        
        // If still not found, try by name match (last resort)
        if (!$student) {
            $student = \App\Models\Student::with('user')
                                          ->where('first_name', $enrollee->given_name)
                                          ->where('last_name', $enrollee->surname)
                                          ->first();
        }
        
        $username = '';
        $password = '';
        $userDebugInfo = '';
        
        // Debug info
        if ($student) {
            $userDebugInfo = 'Student found. User ID: ' . ($student->user_id ?? 'NULL');
            if ($student->user_id) {
                // Directly fetch the user from users table to verify
                $userRecord = \App\Models\User::where('user_id', $student->user_id)->first();
                if ($userRecord) {
                    $username = $userRecord->username;
                    $userDebugInfo .= ' | User found: ' . $username;
                } else {
                    $userDebugInfo .= ' | User NOT found in users table!';
                }
            }
        } else {
            $userDebugInfo = 'Student record not found';
        }
        
        if ($student && $username) {
          // Extract birth year from date of birth for password reconstruction
          $birthDate = $student->date_of_birth ?? '2000-01-01';
          $birthYear = date('Y', strtotime($birthDate));
          $lastnameForPassword = strtolower($student->last_name ?? 'student');
          $lastnameForPassword = preg_replace('/[^a-z0-9]/', '', $lastnameForPassword);
          $password = $lastnameForPassword . $birthYear;
        }
      @endphp
      
      @if($username && $password)
        <div style="background: #d1fae5; border: 2px solid #10b981; border-radius: 8px; padding: 20px; margin-top: 12px;">
          <p style="font-size: 16px; font-weight: 600; color: #065f46; margin: 0 0 16px 0;">✓ Student Login Credentials Ready</p>
          
          {{-- Credentials Box --}}
          <div style="background: white; border: 2px solid #6ee7b7; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
              <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">USERNAME</label>
                <div style="background: #dbeafe; border: 2px solid #3b82f6; border-radius: 6px; padding: 12px;">
                  <code style="font-size: 16px; font-weight: 700; color: #1e40af; font-family: monospace;">{{ $username }}</code>
                </div>
              </div>
              
              <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">PASSWORD</label>
                <div style="background: #dbeafe; border: 2px solid #3b82f6; border-radius: 6px; padding: 12px;">
                  <code style="font-size: 16px; font-weight: 700; color: #1e40af; font-family: monospace;">{{ $password }}</code>
                </div>
              </div>
            </div>

            {{-- Copy Buttons --}}
            <div style="display: flex; gap: 12px;">
              <button onclick="copyToClipboard('{{ $username }}')" 
                      style="flex: 1; background: #2563eb; color: white; font-weight: 600; padding: 10px 16px; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s ease;">
                📋 Copy Username
              </button>
              <button onclick="copyToClipboard('{{ $password }}')" 
                      style="flex: 1; background: #10b981; color: white; font-weight: 600; padding: 10px 16px; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s ease;">
                📋 Copy Password
              </button>
            </div>
          </div>

          {{-- Registrar Instructions --}}
          <div style="background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; padding: 16px; margin-top: 16px;">
            <h5 style="font-weight: 600; color: #1e40af; margin: 0 0 12px 0; font-size: 14px;">📋 Instructions for School Registrar:</h5>
            <div style="font-size: 13px; color: #1e3a8a;">
              <p style="margin: 6px 0;">• <strong>Provide these credentials physically</strong> to the student</p>
              <p style="margin: 6px 0;">• <strong>Username format:</strong> student surname + application number (e.g., {{ $username }})</p>
              <p style="margin: 6px 0;">• <strong>Password format:</strong> student surname + birth year (e.g., {{ $password }})</p>
              <p style="margin: 6px 0;">• <strong>No email notification needed</strong> - these are for physical distribution only</p>
              <p style="margin: 6px 0;">• Student can login at: <code style="background: #bfdbfe; padding: 2px 6px; border-radius: 4px; font-size: 11px;">school-portal.login.url</code></p>
            </div>
          </div>
        </div>
      @elseif($student)
        <div style="background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 20px; margin-top: 12px;">
          <p style="font-size: 16px; font-weight: 600; color: #92400e; margin: 0 0 8px 0;">⚠ Credentials Not Yet Available</p>
          <p style="font-size: 14px; color: #b45309; margin: 0 0 12px 0;">Student record exists but login credentials may still be generating. Please close and reopen this modal to refresh the data.</p>
          <div style="background: white; border-radius: 6px; padding: 12px; font-size: 12px; color: #78716c;">
            <p style="margin: 4px 0;"><strong>Debug Info:</strong></p>
            <p style="margin: 4px 0;">• Student Primary Key: {{ $student->student_id ?? 'N/A' }}</p>
            <p style="margin: 4px 0;">• Student Name: {{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}</p>
            <p style="margin: 4px 0;">• Student Email: {{ $student->email ?? 'N/A' }}</p>
            <p style="margin: 4px 0;">• Student LRN: {{ $student->lrn ?? 'N/A' }}</p>
            <p style="margin: 4px 0;">• User ID (FK): {{ $student->user_id ?? 'NULL' }}</p>
            <p style="margin: 4px 0;">• Debug: {{ $userDebugInfo }}</p>
            <p style="margin: 4px 0; color: #dc2626;"><strong>• Action Required:</strong> {{ $student->user_id ? 'User account linked but username not found - may be user_id=1 (admin)' : 'User account needs to be created' }}</p>
          </div>
        </div>
      @else
        <div style="background: #dbeafe; border: 2px solid #3b82f6; border-radius: 8px; padding: 20px; margin-top: 12px;">
          <p style="font-size: 16px; font-weight: 600; color: #1e40af; margin: 0 0 8px 0;">ℹ Student Record Not Found</p>
          <p style="font-size: 14px; color: #1e3a8a; margin: 0 0 12px 0;">The student record has not been created yet. This may happen if the acceptance process is still running.</p>
          <div style="background: white; border-radius: 6px; padding: 12px; font-size: 12px; color: #78716c;">
            <p style="margin: 4px 0;"><strong>What to check:</strong></p>
            <p style="margin: 4px 0;">1. Verify the enrollee has been accepted (status = accepted)</p>
            <p style="margin: 4px 0;">2. Check if payment has been verified</p>
            <p style="margin: 4px 0;">3. Close and reopen this modal to refresh</p>
            <p style="margin: 4px 0;">4. Check server logs for any errors during student creation</p>
          </div>
        </div>
      @endif
    </div>
    @endif
  </div>

    
</div>

<script>
  // Payment status update is now handled by the global updatePaymentStatus function
  // No additional JavaScript needed in this partial
  // Copy credentials to clipboard for easy distribution
  function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
      // Show success feedback
      const btn = event.target;
      const originalText = btn.textContent;
      btn.textContent = '✓ Copied!';
      btn.classList.add('bg-green-500');
      btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
      
      setTimeout(function() {
        btn.textContent = originalText;
        btn.classList.remove('bg-green-500');
        btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
      }, 2000);
    }).catch(function(err) {
      console.error('Could not copy text: ', err);
      alert('Failed to copy to clipboard. Please copy manually: ' + text);
    });
  }
</script>

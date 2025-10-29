
@php
use Illuminate\Support\Facades\Storage;
use App\Models\StudentDocument;
@endphp

<style>
.enrollee-modal-wrapper {
  background: white;
  border-radius: 12px;
  overflow-x: hidden;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  width: 1050px;
  max-width: 90vw;
  height: 85vh;
  max-height: 85vh;
  display: flex;
  flex-direction: column;
}

.enrollee-modal-header {
  background: linear-gradient(135deg, #7a222b 0%, #922832 100%);
  color: white;
  padding: 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  border-radius: 12px 12px 0 0;
  flex-shrink: 0;
}

.enrollee-modal-header h3 {
  margin: 0;
  font-size: 24px;
  font-weight: 700;
  letter-spacing: -0.5px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.enrollee-modal-body {
  padding: 16px 20px;
  overflow-y: auto;
  overflow-x: hidden;
  flex: 1;
}

.enrollee-section {
  margin-bottom: 14px;
  padding: 14px;
  background: #ffffff;
  border-radius: 8px;
  border: 1px solid #bd8c91;
  box-shadow: 0 2px 4px rgba(122, 34, 43, 0.1);
}

.enrollee-two-column-wrapper {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 14px;
  margin-bottom: 14px;
}

.enrollee-two-column-wrapper .enrollee-section {
  margin-bottom: 0;
}

.enrollee-section h4 {
  margin: 0 0 12px 0;
  padding-bottom: 8px;
  font-size: 14px;
  font-weight: 700;
  color: #7a222b;
  border-bottom: 2px solid #7a222b;
  display: flex;
  align-items: center;
  gap: 8px;
}

.enrollee-section p {
  margin: 6px 0;
  padding: 6px 0;
  font-size: 13px;
  line-height: 1.5;
  display: grid;
  grid-template-columns: 180px 1fr;
  gap: 12px;
  border-bottom: 1px solid #f4e9ea;
}

.enrollee-section p:last-child {
  border-bottom: none;
}

.enrollee-section p span.font-medium {
  font-weight: 600;
  color: #5a1a20;
}

.enrollee-section p span:not(.font-medium) {
  color: #212529;
}

/* Assessment Information Modal Styling */
.assessment-info-modal {
  background: #f9f1f2;
  border: 2px solid #7a222b;
  border-radius: 8px;
  padding: 15px;
  margin: 10px 0;
}

.assessment-recommended-strand {
  background: #7a222b;
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-weight: 600;
  margin: 0 8px;
}

.strand-override-badge {
  background: #dc2626;
  color: white;
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 12px;
  margin-left: 8px;
}

.strand-match-badge {
  background: #059669;
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
  color: #5a1a20;
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
  border: none;
  color: white;
  width: 36px;
  height: 36px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 20px;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(10px);
  padding: 0;
}

.modal-close-button:hover {
  background: rgba(255, 255, 255, 0.3);
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
  border: 1px solid #bd8c91;
  text-align: center;
  box-shadow: 0 1px 3px rgba(122, 34, 43, 0.1);
}

.document-item h5 {
  font-size: 13px;
  font-weight: 600;
  margin-bottom: 8px;
  color: #5a1a20;
}

.document-item a {
  color: #7a222b;
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
    <div style="display: flex; align-items: center; gap: 16px; flex: 1;">
      <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      </div>
      <div>
        <h3>New Student Enrollee Details</h3>
        <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">Complete application information and documents</p>
      </div>
    </div>
    <button class="modal-close modal-close-button" aria-label="Close" onclick="this.closest('.overlay').style.display='none'">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>

  {{-- Body --}}
  <div class="enrollee-modal-body">
    {{-- Two Column Layout for First Two Sections --}}
    <div class="enrollee-two-column-wrapper">
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
        @php
          // Parse the combined address field
          // Format: "House, Unit, City" or "House, City"
          $addressParts = !empty($enrollee->address) ? explode(', ', $enrollee->address) : [];
          $addressHouse = $addressParts[0] ?? '';
          $addressUnit = '';
          $addressCity = '';
          
          // List of known Philippine cities in Luzon (from the form dropdown)
          $knownCities = ['Metro Manila', 'Quezon City', 'Manila', 'Makati', 'Pasig', 'Taguig', 'Las Pinas', 'Muntinlupa', 'Paranaque', 'Parañaque', 'Pasay', 'Marikina', 'Mandaluyong', 'San Juan', 'Valenzuela', 'Malabon', 'Caloocan', 'Navotas', 'Calamba', 'Antipolo', 'Batangas City', 'Cabuyao', 'Laguna', 'Los Baños', 'San Pedro', 'Santa Rosa', 'Angeles', 'Olongapo', 'San Fernando (Pampanga)', 'Baguio', 'Dagupan', 'Baler', 'Ilagan', 'Tuguegarao', 'Naga', 'Iriga', 'Legazpi', 'Sorsogon City', 'Lucena', 'Tayabas', 'Calapan', 'Puerto Princesa'];
          
          if (count($addressParts) === 3) {
            // Format: "House, Unit, City"
            $addressHouse = $addressParts[0];
            $addressUnit = $addressParts[1];
            $addressCity = $addressParts[2];
          } elseif (count($addressParts) === 2) {
            // Format: "House, City" or "House, Unit"
            // Check if second part is a known city
            if (in_array($addressParts[1], $knownCities)) {
              $addressHouse = $addressParts[0];
              $addressCity = $addressParts[1];
            } else {
              // Second part might be unit (not in city list)
              $addressHouse = $addressParts[0];
              $addressUnit = $addressParts[1];
            }
          } elseif (count($addressParts) === 1) {
            // Only house number - no city or unit
            $addressHouse = $addressParts[0];
          }
        @endphp
        
        <p><span class="font-medium">House No. / Street:</span> {{ $addressHouse ?: 'N/A' }}</p>
        @if($addressUnit)
          <p><span class="font-medium">Apt., Suite, Unit:</span> {{ $addressUnit }}</p>
        @endif
        <p><span class="font-medium">City:</span> {{ $addressCity ?: 'N/A' }}</p>
        @if(empty($addressHouse) && empty($addressUnit) && empty($addressCity))
          {{-- Fallback to full address if parsing fails --}}
          <p><span class="font-medium">Complete Address:</span> {{ $enrollee->address }}</p>
        @endif
      </div>
    </div>

    <div class="enrollee-grid">
      {{-- Academic Information --}}
      <div class="enrollee-section">
        <h4>🎓 Academic Information</h4>
        @php
          // Determine grade level for JHS detection
          $gradeLevel = $enrollee->desired_grade ?? $enrollee->shs_grade ?? $enrollee->jhs_grade ?? $enrollee->previous_grade ?? 0;
          $isJHS = ($gradeLevel >= 7 && $gradeLevel <= 10);
          
          // Display strand based on grade level
          $displayStrand = '–';
          if ($isJHS) {
            $displayStrand = 'JHS';
          } elseif ($enrollee->strand) {
            $displayStrand = $enrollee->strand;
          }
        @endphp
        <p><span class="font-medium">Strand:</span> {{ $displayStrand }}</p>
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
          @php
            $gradeLevel = $enrollee->desired_grade ?? $enrollee->shs_grade ?? $enrollee->jhs_grade ?? $enrollee->previous_grade ?? 'N/A';
          @endphp
          {{ $gradeLevel }}
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
          'report_card' => 'Report Card',
          'good_moral' => 'Good Moral',
          'birth_certificate' => 'Birth Certificate',
        ] as $docType => $label)
          <div class="document-item">
            <h5>{{ $label }}</h5>
            @php
              $document = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)
                ->where('enrollment_type', 'new')
                ->where('document_type', $docType)
                ->first();
            @endphp
            @if($document)
              @php
                $docUrl = route('admin.documents.serve-by-id', ['id' => $document->id]);
              @endphp
              <div style="display: flex; flex-direction: column; gap: 6px;">
                <button 
                  type="button"
                  onclick="viewDocumentWithFallback('{{ $docUrl }}', '{{ $docUrl }}', '{{ $label }}')"
                  style="padding: 6px 12px; background: #7a222b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s;"
                  onmouseover="this.style.background='#5a1a20'"
                  onmouseout="this.style.background='#7a222b'"
                >👁️ View</button>
                <a 
                  href="{{ $docUrl }}" 
                  download
                  style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; text-align: center; text-decoration: none; transition: all 0.2s; display: block;"
                  onmouseover="this.style.background='#059669'"
                  onmouseout="this.style.background='#10b981'"
                  onclick="event.preventDefault(); downloadDocWithFallback('{{ $docUrl }}', '{{ $docUrl }}')"
                >📥 Download</a>
              </div>
            @else
              <span style="color: #6b7280;">–</span>
            @endif
          </div>
        @endforeach

        {{-- ID Picture --}}
        <div class="document-item">
          <h5>ID Picture</h5>
          @php
            $idPicDocument = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)
              ->where('enrollment_type', 'new')
              ->where('document_type', 'id_picture')
              ->first();
          @endphp
          @if($idPicDocument)
            @php
              $picUrl = route('admin.documents.serve-by-id', ['id' => $idPicDocument->id]);
              // file_data is already base64 encoded
              $picBase64 = 'data:' . $idPicDocument->mime_type . ';base64,' . $idPicDocument->file_data;
            @endphp
            <div style="display: flex; flex-direction: column; gap: 6px; align-items: center;">
              <img 
                src="{{ $picBase64 }}"
                alt="ID Picture"
                style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 2px solid #bd8c91;"
              >
              <button 
                type="button"
                onclick="viewDocumentWithFallback('{{ $picUrl }}', '{{ $picUrl }}', 'ID Picture')"
                style="padding: 6px 12px; background: #7a222b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s; width: 100%;"
                onmouseover="this.style.background='#5a1a20'"
                onmouseout="this.style.background='#7a222b'"
              >👁️ View Full Size</button>
            </div>
          @else
            <span style="color: #6b7280;">–</span>
          @endif
        </div>
      </div>
    </div>

    {{-- Payment Info --}}
    <div class="enrollee-section">
      <h4>💳 Payment Information</h4>
      <p><span class="font-medium">Payment Method:</span> 
        @if($enrollee->payment_applicant_name === 'Cash Payment')
          Cash Payment
        @elseif($enrollee->payment_applicant_name && $enrollee->payment_reference && !str_starts_with($enrollee->payment_reference, 'CASH-'))
          Digital Payment (GCash, PayMaya, etc.)
        @else
          {{ $enrollee->payment_applicant_name ?? '–' }}
        @endif
      </p>
      @if($enrollee->payment_applicant_name && $enrollee->payment_applicant_name !== 'Cash Payment')
        <p><span class="font-medium">Paid By:</span> {{ $enrollee->payment_applicant_name }}</p>
      @endif
      <p><span class="font-medium">Reference Number:</span> {{ $enrollee->payment_reference ?? '–' }}</p>
      
      {{-- Receipt Section --}}
      @if($enrollee->payment_receipt_path && Storage::disk('public')->exists($enrollee->payment_receipt_path))
        @php
          $receiptPath = ltrim($enrollee->payment_receipt_path, '/');
          $receiptPath = preg_replace('/^storage\//', '', $receiptPath);
          $directUrl = Storage::url($enrollee->payment_receipt_path);
          $fallbackUrl = route('admin.documents.serve', ['path' => $receiptPath]);
        @endphp
        <div style="margin: 12px 0; padding: 10px; background: #f9f1f2; border-radius: 6px; border-left: 3px solid #7a222b;">
          <div style="margin-bottom: 8px;">
            <strong style="color: #5a1a20; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Receipt</strong>
          </div>
          <div style="display: flex; gap: 8px;">
            <button 
              type="button"
              onclick="viewDocumentWithFallback('{{ $directUrl }}', '{{ $fallbackUrl }}', 'Payment Receipt')"
              style="padding: 8px 16px; background: #7a222b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;"
              onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'"
              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
            >
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
              View
            </button>
            <a 
              href="{{ $directUrl }}" 
              download
              style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 6px;"
              onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16,185,129,0.3)'"
              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
              onclick="event.preventDefault(); downloadDocWithFallback('{{ $directUrl }}', '{{ $fallbackUrl }}')"
            >
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
              </svg>
              Download
            </a>
          </div>
        </div>
      @elseif($enrollee->payment_receipt_path)
        <div style="margin: 12px 0; padding: 10px; background: #fee2e2; border-radius: 6px; border-left: 3px solid #dc2626;">
          <span style="color: #dc2626; font-size: 13px; font-weight: 600;">❌ Receipt file is missing from server</span>
        </div>
      @else
        @php
          // Handle DB-stored receipt (document_type = payment_receipt)
          $receiptDoc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)
            ->where('enrollment_type', 'new')
            ->where('document_type', 'payment_receipt')
            ->first();
        @endphp
        @if($receiptDoc)
          @php $receiptDocUrl = route('admin.documents.serve-by-id', ['id' => $receiptDoc->id]); @endphp
          <div style="margin: 12px 0; padding: 10px; background: #f9f1f2; border-radius: 6px; border-left: 3px solid #7a222b;">
            <div style="margin-bottom: 8px;">
              <strong style="color: #5a1a20; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Receipt</strong>
            </div>
            <div style="display: flex; gap: 8px;">
              <button 
                type="button"
                onclick="viewDocumentWithFallback('{{ $receiptDocUrl }}', '{{ $receiptDocUrl }}', 'Payment Receipt')"
                style="padding: 8px 16px; background: #7a222b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; gap: 6px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
              >
                View
              </button>
              <a 
                href="{{ $receiptDocUrl }}" 
                download
                style="padding: 8px 16px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 6px;"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16,185,129,0.3)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                onclick="event.preventDefault(); downloadDocWithFallback('{{ $receiptDocUrl }}', '{{ $receiptDocUrl }}')"
              >
                Download
              </a>
            </div>
          </div>
        @else
          <div style="margin: 12px 0; padding: 10px; background: #fff7ed; border-radius: 6px; border-left: 3px solid #f59e0b;">
            <div style="color: #92400e; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Receipt file not found.</div>
            <form action="{{ route('admin.documents.reupload') }}" method="POST" enctype="multipart/form-data" style="display:flex; gap:8px; align-items:center; flex-wrap: wrap;">
              @csrf
              <input type="hidden" name="enrollee_id" value="{{ $enrollee->id }}">
              <input type="hidden" name="enrollment_type" value="new">
              <input type="hidden" name="document_type" value="payment_receipt">
              <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required>
              <button type="submit" style="padding: 6px 12px; background: #7a222b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600;">Re-upload</button>
            </form>
          </div>
        @endif
      @endif
      
      {{-- Payment Status Section --}}
      <div style="margin-top: 16px; padding: 12px; background: #f9f1f2; border-radius: 6px; border-left: 3px solid #7a222b;">
        <div style="margin-bottom: 10px;">
          <strong style="color: #5a1a20; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Status</strong>
        </div>
        <form id="payment-status-form" onsubmit="return false;">
          <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <select id="payment-status-select" name="payment_status" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 13px; font-weight: 500; min-width: 180px; background: white;">
              @php $ps = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification'); @endphp
              <option value="Pending Verification" {{ $ps === 'Pending Verification' ? 'selected' : '' }}>⏳ Pending Verification</option>
              <option value="Verified" {{ $ps === 'Verified' ? 'selected' : '' }}>✅ Verified</option>
              <option value="Invalid" {{ $ps === 'Invalid' ? 'selected' : '' }}>❌ Invalid</option>
              <option value="Rejected" {{ $ps === 'Rejected' ? 'selected' : '' }}>🚫 Rejected</option>
            </select>
            <button type="button" id="save-payment-status" onclick="updatePaymentStatus('{{ $enrollee->id }}', 'new')" style="padding: 8px 16px; background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13px; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
              </svg>
              Update Status
            </button>
          </div>
        </form>
        @if($enrollee->payment_status_changed_at)
          <div id="payment-status-meta" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #bd8c91; font-size: 11px; color: #6c757d; font-style: italic;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            Last updated {{ $enrollee->payment_status_changed_at->diffForHumans() }} by <strong>{{ $enrollee->payment_status_changed_by ?? 'System' }}</strong>
          </div>
        @endif
      </div>
      
      {{-- Payment Verification Warning --}}
      @php $isPaymentVerified = ($enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification')) === 'Verified'; @endphp
      @if(!$isPaymentVerified)
        <div style="margin-top: 12px; padding: 12px 14px; background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 6px; display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" style="flex-shrink: 0;">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
          </svg>
          <div style="flex: 1;">
            <strong style="font-size: 13px; color: #92400e; font-weight: 700;">Payment Verification Required:</strong>
            <span style="font-size: 13px; color: #92400e;"> This enrollee cannot be accepted until payment is verified.</span>
          </div>
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
        <div style="background: #f9f1f2; border: 2px solid #7a222b; border-radius: 8px; padding: 16px; margin-top: 12px;">
            <p style="font-size: 14px; color: #5a1a20; margin: 0 0 12px 0;"><strong>✓ Student automatically assigned to section!</strong></p>
            <div style="background: white; border-radius: 6px; border: 1px solid #bd8c91; padding: 12px;">
                <p style="font-weight: 600; color: #5a1a20; margin: 8px 0;">Section: <span style="font-weight: 700;">{{ $sectionInfo }}</span></p>
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
        <div style="background: #f9f1f2; border: 2px solid #7a222b; border-radius: 8px; padding: 20px; margin-top: 12px;">
          <p style="font-size: 16px; font-weight: 600; color: #5a1a20; margin: 0 0 16px 0;">✓ Student Login Credentials Ready</p>
          
          {{-- Credentials Box --}}
          <div style="background: white; border: 2px solid #bd8c91; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(122, 34, 43, 0.1);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
              <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">USERNAME</label>
                <div style="background: #f4e9ea; border: 2px solid #7a222b; border-radius: 6px; padding: 12px;">
                  <code style="font-size: 16px; font-weight: 700; color: #7a222b; font-family: monospace;">{{ $username }}</code>
                </div>
              </div>
              
              <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">PASSWORD</label>
                <div style="background: #f4e9ea; border: 2px solid #7a222b; border-radius: 6px; padding: 12px;">
                  <code style="font-size: 16px; font-weight: 700; color: #7a222b; font-family: monospace;">{{ $password }}</code>
                </div>
              </div>
            </div>

            {{-- Copy Buttons --}}
            <div style="display: flex; gap: 12px;">
              <button onclick="copyToClipboard('{{ $username }}')" 
                      style="flex: 1; background: #7a222b; color: white; font-weight: 600; padding: 10px 16px; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s ease;">
                📋 Copy Username
              </button>
              <button onclick="copyToClipboard('{{ $password }}')" 
                      style="flex: 1; background: #10b981; color: white; font-weight: 600; padding: 10px 16px; border: none; border-radius: 6px; font-size: 13px; cursor: pointer; transition: all 0.3s ease;">
                📋 Copy Password
              </button>
            </div>
          </div>

          {{-- Distribution Options --}}
          <div style="background: linear-gradient(135deg, #f9f1f2 0%, #fff 100%); border: 1px solid #bd8c91; border-left: 4px solid #7a222b; border-radius: 8px; padding: 18px; margin-top: 16px; box-shadow: 0 2px 8px rgba(122, 34, 43, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #bd8c91;">
              <div style="background: #7a222b; padding: 8px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                  <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
              </div>
              <div>
                <h5 style="font-weight: 700; color: #5a1a20; margin: 0; font-size: 15px; letter-spacing: -0.2px;">📤 Distribute Credentials</h5>
                <p style="font-size: 11px; color: #6b7280; margin: 2px 0 0 0;">Choose your preferred distribution method</p>
              </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
              {{-- PDF Download Button --}}
              <a href="{{ route('admin.enrollees.credentials.pdf', $enrollee->id) }}" 
                 class="credential-action-btn"
                 style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; text-decoration: none; padding: 14px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; text-align: center; display: flex; flex-direction: column; gap: 6px; align-items: center; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(220, 38, 38, 0.3); position: relative; overflow: hidden;"
                 onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(220, 38, 38, 0.4)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(220, 38, 38, 0.3)'">
                <span style="font-size: 24px; display: block;">🖨️</span>
                <span>Generate PDF</span>
                <span style="font-size: 10px; font-weight: 400; opacity: 0.9; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 10px;">Printable Sheet</span>
              </a>
              
              {{-- Email Button --}}
              <button data-enrollee-id="{{ $enrollee->id }}" onclick="window.sendCredentialsEmail({{ $enrollee->id }})" 
                      class="credential-action-btn send-email-btn"
                      style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; padding: 14px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; flex-direction: column; gap: 6px; align-items: center; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);"
                      onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(16, 185, 129, 0.4)'"
                      onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(16, 185, 129, 0.3)'">
                <span style="font-size: 24px; display: block;">📧</span>
                <span>Send Email</span>
                <span style="font-size: 10px; font-weight: 400; opacity: 0.9; background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 10px;">To {{ $enrollee->email ?? 'student' }}</span>
              </button>
            </div>
            
            {{-- Alternative Options --}}
            <div style="margin-top: 14px; padding: 10px 12px; background: rgba(255, 255, 255, 0.8); border-radius: 6px; border-left: 3px solid #7a222b;">
              <div style="display: flex; align-items: start; gap: 8px;">
                <span style="font-size: 16px; flex-shrink: 0;">💡</span>
                <div style="flex: 1; font-size: 11px; color: #2b0f12; line-height: 1.5;">
                  <strong style="color: #5a1a20;">Quick Tip:</strong> You can also copy credentials above for manual distribution or use the "Generate PDF" button to create a printable document for in-person handouts.
                </div>
              </div>
            </div>
          </div>
          
          {{-- Credential Format Guide --}}
          <div style="background: linear-gradient(135deg, #f9f1f2 0%, #fff 100%); border: 1px solid #bd8c91; border-left: 4px solid #7a222b; border-radius: 8px; padding: 18px; margin-top: 16px; box-shadow: 0 2px 8px rgba(122, 34, 43, 0.08);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 2px solid #bd8c91;">
              <div style="background: #7a222b; padding: 8px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                  <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                  <polyline points="14 2 14 8 20 8"></polyline>
                  <line x1="16" y1="13" x2="8" y2="13"></line>
                  <line x1="16" y1="17" x2="8" y2="17"></line>
                  <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
              </div>
              <div>
                <h5 style="font-weight: 700; color: #5a1a20; margin: 0; font-size: 15px; letter-spacing: -0.2px;">📋 Credential Format Guide</h5>
                <p style="font-size: 11px; color: #6b7280; margin: 2px 0 0 0;">Quick reference for registrars</p>
              </div>
            </div>
            
            <div style="display: grid; gap: 12px;">
              {{-- Username Format --}}
              <div style="background: white; border: 1px solid #f4e9ea; border-radius: 6px; padding: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                  <span style="background: #f4e9ea; color: #7a222b; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 10px;">USERNAME</span>
                  <span style="font-size: 11px; color: #6b7280;">Format Pattern</span>
                </div>
                <div style="font-size: 13px; color: #2b0f12; font-weight: 500;">
                  lastname<span style="color: #7a222b; font-weight: 700;">.</span>studentnumber
                </div>
                <div style="margin-top: 6px; padding-top: 6px; border-top: 1px solid #f4e9ea;">
                  <span style="font-size: 11px; color: #6b7280;">Example: </span>
                  <code style="background: #f9f1f2; color: #7a222b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 700; font-family: 'Courier New', monospace;">{{ $username }}</code>
                </div>
              </div>
              
              {{-- Password Format --}}
              <div style="background: white; border: 1px solid #f4e9ea; border-radius: 6px; padding: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                  <span style="background: #f4e9ea; color: #7a222b; font-weight: 700; padding: 2px 8px; border-radius: 4px; font-size: 10px;">PASSWORD</span>
                  <span style="font-size: 11px; color: #6b7280;">Format Pattern</span>
                </div>
                <div style="font-size: 13px; color: #2b0f12; font-weight: 500;">
                  lastname<span style="color: #7a222b; font-weight: 700;">+</span>birthyear
                </div>
                <div style="margin-top: 6px; padding-top: 6px; border-top: 1px solid #f4e9ea;">
                  <span style="font-size: 11px; color: #6b7280;">Example: </span>
                  <code style="background: #f9f1f2; color: #7a222b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 700; font-family: 'Courier New', monospace;">{{ $password }}</code>
                </div>
              </div>
              
              {{-- Important Notes --}}
              <div style="background: #fff5f5; border-left: 3px solid #7a222b; border-radius: 4px; padding: 10px;">
                <div style="display: flex; align-items: start; gap: 8px;">
                  <span style="font-size: 14px;">⚠️</span>
                  <div style="flex: 1; font-size: 12px; color: #2b0f12; line-height: 1.5;">
                    <strong style="color: #5a1a20;">Important:</strong> Student <strong>must</strong> change password on first login for security.
                  </div>
                </div>
              </div>
              
              {{-- Login URL --}}
              <div style="display: flex; align-items: center; justify-content: space-between; background: #f9f1f2; border-radius: 6px; padding: 10px;">
                <span style="font-size: 12px; font-weight: 600; color: #5a1a20;">🔗 Login URL:</span>
                <code style="background: white; color: #7a222b; padding: 6px 12px; border-radius: 4px; font-size: 11px; font-weight: 600; font-family: 'Courier New', monospace; border: 1px solid #bd8c91;">{{ config('app.url') }}/login</code>
              </div>
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
        <div style="background: #f9f1f2; border: 2px solid #7a222b; border-radius: 8px; padding: 20px; margin-top: 12px;">
          <p style="font-size: 16px; font-weight: 600; color: #5a1a20; margin: 0 0 8px 0;">ℹ Student Record Not Found</p>
          <p style="font-size: 14px; color: #2b0f12; margin: 0 0 12px 0;">The student record has not been created yet. This may happen if the acceptance process is still running.</p>
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

  // sendCredentialsEmail is defined in admin_new_enrollees.blade.php
</script>

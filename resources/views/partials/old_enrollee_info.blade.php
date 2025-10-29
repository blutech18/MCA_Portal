{{-- resources/views/partials/old_enrollee_info.blade.php --}}
@php
use Illuminate\Support\Facades\Storage;
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
  border: 1px solid #dee2e6;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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
  border-bottom: 1px solid #f1f3f5;
}

.enrollee-section p:last-child {
  border-bottom: none;
}

.enrollee-section p strong {
  font-weight: 600;
  color: #495057;
}

.enrollee-section p span:not(strong) {
  color: #212529;
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
}

.modal-close-button:hover {
  background: rgba(255, 255, 255, 0.3);
}

.enrollee-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
  margin-bottom: 12px;
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
</style>

<div class="enrollee-modal-wrapper">
  <div class="enrollee-modal-header">
    <h3>📋 Old Student Enrollee Details</h3>
    <button class="modal-close modal-close-button" aria-label="Close" onclick="this.closest('.overlay').style.display='none'">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>

<div class="enrollee-modal-body">
  {{-- Two Column Layout for First Two Sections --}}
  <div class="enrollee-two-column-wrapper">
    {{-- Personal Information --}}
    <div class="enrollee-section">
      <h4>👤 Personal Information</h4>
      <p><strong>Full Name:</strong> {{ $enrollee->display_name }}</p>
      <p><strong>LRN:</strong> {{ $enrollee->lrn }}</p>
      <p><strong>Student ID #:</strong> {{ $enrollee->student_id }}</p>
      <p><strong>Applying Grade Level:</strong> {{ $enrollee->grade_level_applying }}</p>
      <p><strong>Semester:</strong> {{ ucfirst($enrollee->semester) }}</p>
    </div>

    {{-- Payment Information --}}
    <div class="enrollee-section">
      <h4>💳 Payment Information</h4>
      <p><strong>Payment Method:</strong> 
        @if($enrollee->payment_applicant_name === 'Cash Payment')
          Cash Payment
        @elseif($enrollee->payment_applicant_name && $enrollee->payment_reference && !str_starts_with($enrollee->payment_reference, 'CASH-'))
          Digital Payment (GCash, PayMaya, etc.)
        @else
          {{ $enrollee->payment_applicant_name ?? '–' }}
        @endif
      </p>
      @if($enrollee->payment_applicant_name && $enrollee->payment_applicant_name !== 'Cash Payment')
        <p><strong>Paid By:</strong> {{ $enrollee->payment_applicant_name }}</p>
      @endif
      <p><strong>Reference Number:</strong> {{ $enrollee->payment_reference ?? '–' }}</p>
      
      <div style="margin-top: 16px; padding: 12px; background: #f8f9fa; border-radius: 6px; border-left: 3px solid #7a222b;">
        <div style="margin-bottom: 10px;">
          <strong style="color: #495057; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Payment Status</strong>
        </div>
        <form id="payment-status-form-old" onsubmit="return false;">
          <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <select id="payment-status-select-old" name="payment_status" style="padding: 8px 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 13px; font-weight: 500; min-width: 180px; background: white;">
              @php $ps = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification'); @endphp
              <option value="Pending Verification" {{ $ps === 'Pending Verification' ? 'selected' : '' }}>⏳ Pending Verification</option>
              <option value="Verified" {{ $ps === 'Verified' ? 'selected' : '' }}>✅ Verified</option>
              <option value="Invalid" {{ $ps === 'Invalid' ? 'selected' : '' }}>❌ Invalid</option>
              <option value="Rejected" {{ $ps === 'Rejected' ? 'selected' : '' }}>🚫 Rejected</option>
            </select>
            <button type="button" id="save-payment-status-old" onclick="updatePaymentStatus('{{ $enrollee->id }}', 'old')" style="padding: 8px 16px; background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13px; transition: all 0.2s; display: flex; align-items: center; gap: 6px;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
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
          <div id="payment-status-meta-old" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #dee2e6; font-size: 11px; color: #6c757d; font-style: italic;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            Last updated {{ $enrollee->payment_status_changed_at->diffForHumans() }} by <strong>{{ $enrollee->payment_status_changed_by ?? 'System' }}</strong>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Terms Accepted --}}
  <div class="enrollee-section">
    <h4>📄 Terms & Conditions</h4>
    @php
      $terms = $enrollee->terms_accepted;
      if (! is_array($terms)) {
          $terms = json_decode($terms, true) ?: [];
      }
    @endphp
    <p><strong>Terms Accepted:</strong> {{ $terms ? implode(', ', $terms) : '–' }}</p>
  </div>

  {{-- Documents --}}
  <div class="enrollee-section">
    <h4>📂 Documents</h4>
    <p>
      <strong>Payment Receipt:</strong>
      @if($enrollee->payment_receipt_path && Storage::disk('public')->exists($enrollee->payment_receipt_path))
        @php
          $receiptPath = ltrim($enrollee->payment_receipt_path, '/');
          $receiptPath = preg_replace('/^storage\//', '', $receiptPath);
          $directUrl = Storage::url($enrollee->payment_receipt_path);
          $fallbackUrl = route('admin.documents.serve', ['path' => $receiptPath]);
        @endphp
        <div style="display: inline-flex; gap: 8px; margin-left: 8px;">
          <button 
            type="button"
            onclick="viewDocumentWithFallback('{{ $directUrl }}', '{{ $fallbackUrl }}', 'Payment Receipt')"
            style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s;"
            onmouseover="this.style.background='#2563eb'"
            onmouseout="this.style.background='#3b82f6'"
          >👁️ View</button>
          <a 
            href="{{ $directUrl }}" 
            download
            style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none; transition: all 0.2s; display: inline-block;"
            onmouseover="this.style.background='#059669'"
            onmouseout="this.style.background='#10b981'"
            onclick="event.preventDefault(); downloadDocWithFallback('{{ $directUrl }}', '{{ $fallbackUrl }}')"
          >📥 Download</a>
        </div>
      @elseif($enrollee->payment_receipt_path)
        <span style="color: #dc2626; font-size: 13px;">❌ File missing</span>
      @else
        @php
          $receiptDoc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)
            ->where('enrollment_type', 'old')
            ->where('document_type', 'payment_receipt')
            ->first();
        @endphp
        @if($receiptDoc)
          <a href="{{ route('admin.documents.serve-by-id', ['id' => $receiptDoc->id]) }}" target="_blank">📥 Download</a>
        @else
          <form action="{{ route('admin.documents.reupload') }}" method="POST" enctype="multipart/form-data" style="display:inline-flex; gap:8px; margin-left:8px;">
            @csrf
            <input type="hidden" name="enrollee_id" value="{{ $enrollee->id }}">
            <input type="hidden" name="enrollment_type" value="old">
            <input type="hidden" name="document_type" value="payment_receipt">
            <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required style="font-size:12px;">
            <button type="submit" style="padding: 4px 8px; background: #7a222b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600;">Re-upload</button>
          </form>
        @endif
      @endif
    </p>
    <p>
      <strong>Clearance:</strong>
      @if($enrollee->clearance_path && Storage::disk('public')->exists($enrollee->clearance_path))
        @php
          $clearancePath = ltrim($enrollee->clearance_path, '/');
          $clearancePath = preg_replace('/^storage\//', '', $clearancePath);
          $clearanceDirectUrl = Storage::url($enrollee->clearance_path);
          $clearanceFallbackUrl = route('admin.documents.serve', ['path' => $clearancePath]);
        @endphp
        <div style="display: inline-flex; gap: 8px; margin-left: 8px;">
          <button 
            type="button"
            onclick="viewDocumentWithFallback('{{ $clearanceDirectUrl }}', '{{ $clearanceFallbackUrl }}', 'Clearance Document')"
            style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s;"
            onmouseover="this.style.background='#2563eb'"
            onmouseout="this.style.background='#3b82f6'"
          >👁️ View</button>
          <a 
            href="{{ $clearanceDirectUrl }}" 
            download
            style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none; transition: all 0.2s; display: inline-block;"
            onmouseover="this.style.background='#059669'"
            onmouseout="this.style.background='#10b981'"
            onclick="event.preventDefault(); downloadDocWithFallback('{{ $clearanceDirectUrl }}', '{{ $clearanceFallbackUrl }}')"
          >📥 Download</a>
        </div>
      @elseif($enrollee->clearance_path)
        <span style="color: #dc2626; font-size: 13px;">❌ File missing</span>
      @else
        –
      @endif
    </p>
  </div>

  {{-- Application Status & Metadata --}}
  <div class="enrollee-section">
    <h4>📊 Application Status & Metadata</h4>
    <p><strong>Application #:</strong> {{ $enrollee->application_number }}</p>
    <p><strong>Status:</strong> 
      <span class="status-badge status-{{ $enrollee->status ?? 'pending' }}">
        {{ ucfirst($enrollee->status ?? 'pending') }}
      </span>
    </p>
    @if($enrollee->decline_reason)
      <p><strong>Decline Reason:</strong> {{ $enrollee->decline_reason }}</p>
    @endif
    <p><strong>Created:</strong> {{ $enrollee->created_at->format('F j, Y @ H:i') }}</p>
    <p><strong>Updated:</strong> {{ $enrollee->updated_at->format('F j, Y @ H:i') }}</p>
    @if($enrollee->status_updated_at)
      <p><strong>Status Updated:</strong> {{ $enrollee->status_updated_at->format('F j, Y @ H:i') }}</p>
    @endif
  </div>
  
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
</div>

<script>
  // Payment status update is now handled by the global updatePaymentStatus function
  // No additional JavaScript needed in this partial
</script>


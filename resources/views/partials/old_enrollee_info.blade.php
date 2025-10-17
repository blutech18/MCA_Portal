{{-- resources/views/partials/old_enrollee_info.blade.php --}}
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

.enrollee-section p strong {
  font-weight: 600;
  color: #2c5a6b;
  display: inline-block;
  min-width: 150px;
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
</style>

<div class="enrollee-modal-wrapper">
  <div class="enrollee-modal-header">
    <h3>📋 Old Student Enrollee Details</h3>
    <button class="modal-close modal-close-button" aria-label="Close">
      <span>✕</span>
      <span>Close</span>
    </button>
  </div>

<div class="enrollee-modal-body">
  <div class="enrollee-grid">
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
      <p><strong>Applicant Name:</strong> {{ $enrollee->payment_applicant_name ?? '–' }}</p>
      <p><strong>Reference #:</strong> {{ $enrollee->payment_reference ?? '–' }}</p>
      <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <div>
          <strong>Payment Status:</strong>
          <form id="payment-status-form-old" onsubmit="return false;" style="display:inline-block; margin-left:8px;">
            <select id="payment-status-select-old" name="payment_status" style="padding:6px 8px; border:1px solid #d1d5db; border-radius:6px;">
              @php $ps = $enrollee->payment_status ?? ($enrollee->paid ? 'Verified' : 'Pending Verification'); @endphp
              <option value="Pending Verification" {{ $ps === 'Pending Verification' ? 'selected' : '' }}>Pending Verification</option>
              <option value="Verified" {{ $ps === 'Verified' ? 'selected' : '' }}>Verified</option>
              <option value="Invalid" {{ $ps === 'Invalid' ? 'selected' : '' }}>Invalid</option>
              <option value="Rejected" {{ $ps === 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="button" id="save-payment-status-old" onclick="updatePaymentStatus('{{ $enrollee->id }}', 'old')" style="margin-left:8px; padding:6px 10px; background:#2563eb; color:#fff; border:none; border-radius:6px; cursor:pointer;">Save</button>
          </form>
        </div>
        <div id="payment-status-meta-old" style="font-size:12px; color:#6b7280;">
          @if($enrollee->payment_status_changed_at)
            Updated {{ $enrollee->payment_status_changed_at->diffForHumans() }} by {{ $enrollee->payment_status_changed_by ?? '—' }}
          @endif
        </div>
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
      @elseif($enrollee->payment_receipt_path)
        <span style="color: #dc2626; font-size: 13px;">❌ File missing</span>
      @else
        –
      @endif
    </p>
    <p>
      <strong>Clearance:</strong>
      @if($enrollee->clearance_path && Storage::disk('public')->exists($enrollee->clearance_path))
        <div style="display: inline-flex; gap: 8px; margin-left: 8px;">
          <button 
            type="button"
            onclick="viewDocument('{{ Storage::url($enrollee->clearance_path) }}', 'Clearance Document')"
            style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; transition: all 0.2s;"
            onmouseover="this.style.background='#2563eb'"
            onmouseout="this.style.background='#3b82f6'"
          >👁️ View</button>
          <a 
            href="{{ Storage::url($enrollee->clearance_path) }}" 
            download
            style="padding: 6px 12px; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none; transition: all 0.2s; display: inline-block;"
            onmouseover="this.style.background='#059669'"
            onmouseout="this.style.background='#10b981'"
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
    <div style="margin-top: 12px; padding: 12px; background: #fef3c7; border: 2px solid #f59e0b; border-radius: 6px;">
      <p style="font-size: 13px; color: #92400e; margin: 0;">
        <strong>⚠ Payment Verification Required:</strong> This enrollee cannot be accepted until payment is verified.
      </p>
    </div>
  @endif
</div>
</div>

<script>
  // Payment status update is now handled by the global updatePaymentStatus function
  // No additional JavaScript needed in this partial
</script>


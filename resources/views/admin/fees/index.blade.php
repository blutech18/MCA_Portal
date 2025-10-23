@extends('layouts.admin_base')

@section('title', 'Admin - Fee Management')
@section('header', 'Fee Management')

@push('head')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .admin-fees .container { max-width: 1200px; margin: 0 auto; padding: 12px; }
    .admin-fees .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .admin-fees .card { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:14px 16px; display:flex; flex-direction:column; gap:8px; }
    .admin-fees .card-title { display:flex; align-items:center; justify-content:space-between; }
    .admin-fees .card-title p { margin:0; font-weight:600; }
    .admin-fees .fee-amount { font-size:24px; font-weight:700; color:#059669; margin:8px 0; }
    .admin-fees .fee-info { font-size:12px; color:#6b7280; margin-bottom:12px; }
    .admin-fees .btn { padding:8px 16px; border:none; border-radius:6px; cursor:pointer; font-size:12px; font-weight:500; }
    .admin-fees .btn-primary { background:#3b82f6; color:white; }
    .admin-fees .btn-primary:hover { background:#2563eb; }
    .admin-fees .btn-success { background:#10b981; color:white; margin-bottom:16px; }
    .admin-fees .btn-success:hover { background:#059669; }
    
    /* Modal Styles */
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
      z-index: 1000;
    }

    .modal-content {
      background: white;
      border-radius: 8px;
      padding: 20px;
      max-width: 500px;
      width: 90%;
    }

    .modal h2 {
      margin: 0 0 20px 0;
      font-size: 18px;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .form-group label {
      display: block;
      margin-bottom: 4px;
      font-weight: 500;
    }

    .form-group input {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #d1d5db;
      border-radius: 4px;
    }

    .modal-actions {
      display: flex;
      gap: 8px;
      justify-content: flex-end;
      margin-top: 20px;
    }

    .btn-secondary {
      background: #6b7280;
      color: white;
    }

    .btn-secondary:hover {
      background: #4b5563;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 6px;
      margin-bottom: 16px;
      font-size: 14px;
    }

    .alert-success {
      background-color: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }

    .alert-error {
      background-color: #fee2e2;
      color: #991b1b;
      border: 1px solid #fca5a5;
    }
    
    /* Logout Modal Styles */
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
<div class="admin-fees">
  <div class="container">
    <!-- Alert Messages -->
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">
        {{ session('error') }}
      </div>
    @endif

    <!-- History Button -->
    <a href="{{ route('admin.fees.history') }}" class="btn btn-success">Fee History</a>

    <!-- Fees Grid -->
    <div class="grid">
      @foreach($currentFees as $type => $data)
        <div class="card">
          <div class="card-title">
            <p>{{ $data['label'] }}</p>
          </div>
          
          @if($data['fee'])
            <div class="fee-amount">{{ $data['fee']->formatted_amount }}</div>
            <div class="fee-info">
              Effective: {{ $data['fee']->effective_date->format('M d, Y') }}<br>
              Last updated: {{ $data['fee']->updated_at->diffForHumans() }}
            </div>
          @else
            <div class="fee-amount">₱0.00</div>
            <div class="fee-info">
              No fee set for this category
            </div>
          @endif

          <button class="btn btn-primary" onclick="openEditModal('{{ $type }}', '{{ $data['label'] }}', {{ $data['fee'] ? $data['fee']->amount : 0 }})">
            Edit Fee
          </button>
        </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Edit Fee Modal -->
<div id="editFeeModal" class="modal" style="display: none;">
  <div class="modal-content" style="max-width: 600px; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.15);">
    <div class="modal-header" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; padding: 24px; border-radius: 12px 12px 0 0; position: relative; margin: -20px -20px 20px -20px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 10px; backdrop-filter: blur(10px);">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <line x1="12" y1="1" x2="12" y2="23"></line>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
          </svg>
        </div>
        <div style="flex: 1;">
          <h3 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; color: white;">Edit Enrollment Fee</h3>
          <p style="margin: 4px 0 0 0; font-size: 14px; color: rgba(255,255,255,0.85); font-weight: 400;">Update fee amount and effective date</p>
        </div>
      </div>
      <button type="button" class="close-btn" onclick="closeEditModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.2); border: none; color: white; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; backdrop-filter: blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <form id="editFeeForm">
      @csrf
      <input type="hidden" id="feeType" name="fee_type">
      <input type="hidden" id="currentAmount" name="current_amount">
      
      <div class="form-group" style="margin-bottom: 24px;">
        <label style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-weight: 600; color: #495057; font-size: 13px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
          Fee Type
        </label>
        <input type="text" id="feeTypeLabel" readonly style="width: 100%; padding: 10px 14px; border: 1px solid #dee2e6; border-radius: 6px; font-size: 14px; background-color: #f8f9fa; color: #495057; cursor: not-allowed;">
      </div>
      
      <div class="form-group" style="margin-bottom: 24px;">
        <label for="newAmount" style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-weight: 600; color: #495057; font-size: 13px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
            <line x1="12" y1="1" x2="12" y2="23"></line>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
          </svg>
          New Fee Amount
        </label>
        <div style="position: relative;">
          <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6c757d; font-weight: 600; font-size: 14px;">₱</span>
          <input type="number" id="newAmount" name="amount" step="0.01" min="0" required placeholder="0.00" style="width: 100%; padding: 10px 14px 10px 32px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; transition: all 0.2s ease; background-color: #fff;" onfocus="this.style.borderColor='#7a222b'; this.style.boxShadow='0 0 0 3px rgba(122,34,43,0.1)'" onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
        </div>
        <small style="color: #6c757d; font-size: 11px; display: block; margin-top: 6px; font-style: italic;">Current: <span id="currentAmountDisplay" style="font-weight: 600; color: #7a222b;">₱0.00</span></small>
      </div>
      
      <div class="form-group" style="margin-bottom: 24px;">
        <label for="effectiveDate" style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; font-weight: 600; color: #495057; font-size: 13px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7a222b" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
          </svg>
          Effective Date
        </label>
        <input type="date" id="effectiveDate" name="effective_date" required style="width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; transition: all 0.2s ease; background-color: #fff;" onfocus="this.style.borderColor='#7a222b'; this.style.boxShadow='0 0 0 3px rgba(122,34,43,0.1)'" onblur="this.style.borderColor='#ced4da'; this.style.boxShadow='none'">
      </div>
      
      <div style="background: #f8f9fa; padding: 20px 24px; border-radius: 0 0 12px 12px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #dee2e6; margin: 20px -20px -20px -20px;">
        <button type="button" class="btn btn-secondary" onclick="closeEditModal()" style="background: #fff; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 24px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#fff'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
          Cancel
        </button>
        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #7a222b 0%, #922832 100%); color: white; border: none; padding: 10px 32px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(122,34,43,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(122,34,43,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(122,34,43,0.2)'">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
          </svg>
          Update Fee
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Logout Modal -->
<div id="confirm-modal" class="modal" style="display: none;">
  <div class="modal-content">
    <p>Are you sure you want to log out?</p>
    <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
    <button class="cancel-btn" onclick="closeModal()">Cancel</button>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Set today's date as minimum for effective date
  document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('effectiveDate').min = today;
    document.getElementById('effectiveDate').value = today;
  });

  function openEditModal(feeType, feeTypeLabel, currentAmount) {
    document.getElementById('feeType').value = feeType;
    document.getElementById('feeTypeLabel').value = feeTypeLabel;
    document.getElementById('currentAmount').value = currentAmount;
    document.getElementById('currentAmountDisplay').textContent = '₱' + parseFloat(currentAmount).toFixed(2);
    document.getElementById('newAmount').value = currentAmount;
    
    document.getElementById('editFeeModal').style.display = 'flex';
  }

  function closeEditModal() {
    document.getElementById('editFeeModal').style.display = 'none';
    document.getElementById('editFeeForm').reset();
  }

  // Handle form submission
  document.getElementById('editFeeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const currentAmount = parseFloat(document.getElementById('currentAmount').value);
    const newAmount = parseFloat(formData.get('amount'));
    
    // Confirmation dialog
    if (newAmount !== currentAmount) {
      const confirmed = confirm(
        `Are you sure you want to change the enrollment fee from ₱${currentAmount.toFixed(2)} to ₱${newAmount.toFixed(2)}?\n\nThis change will be effective on ${formData.get('effective_date')}.`
      );
      
      if (!confirmed) {
        return;
      }
    }
    
    try {
      const response = await fetch('{{ route("admin.fees.update") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          fee_type: formData.get('fee_type'),
          amount: newAmount,
          effective_date: formData.get('effective_date')
        })
      });
      
      const data = await response.json();
      
      if (data.success) {
        alert('✅ ' + data.message);
        location.reload(); // Refresh to show updated fees
      } else {
        alert('❌ ' + data.message);
      }
    } catch (error) {
      console.error('Error updating fee:', error);
      alert('❌ An error occurred while updating the fee. Please try again.');
    }
  });

  // Close modal when clicking outside
  document.getElementById('editFeeModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeEditModal();
    }
  });
</script>

<script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush

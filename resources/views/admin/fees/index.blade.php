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
<div id="editFeeModal" class="modal">
  <div class="modal-content">
    <h2>Edit Enrollment Fee</h2>
    
    <form id="editFeeForm">
      @csrf
      <input type="hidden" id="feeType" name="fee_type">
      <input type="hidden" id="currentAmount" name="current_amount">
      
      <div class="form-group">
        <label>Fee Type</label>
        <input type="text" id="feeTypeLabel" readonly style="background-color: #f9fafb;">
      </div>
      
      <div class="form-group">
        <label for="newAmount">New Fee Amount</label>
        <input type="number" id="newAmount" name="amount" step="0.01" min="0" required>
        <small style="color: #6b7280; font-size: 12px;">Current: <span id="currentAmountDisplay">₱0.00</span></small>
      </div>
      
      <div class="form-group">
        <label for="effectiveDate">Effective Date</label>
        <input type="date" id="effectiveDate" name="effective_date" required>
      </div>
      
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Fee</button>
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

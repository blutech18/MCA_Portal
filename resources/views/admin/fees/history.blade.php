@extends('layouts.admin_base')

@section('title', 'Admin - Fee History')
@section('header', 'Fee History')

@push('head')
  <style>
    .admin-fee-history .container { max-width: 1200px; margin: 0 auto; padding: 12px; }
    .admin-fee-history .btn { padding:8px 16px; border:none; border-radius:6px; cursor:pointer; font-size:12px; font-weight:500; margin-bottom:16px; }
    .admin-fee-history .btn-secondary { background:#6b7280; color:white; text-decoration:none; display:inline-block; }
    .admin-fee-history .btn-secondary:hover { background:#4b5563; }
    .admin-fee-history .card { background:#fff; border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:16px; }
    .admin-fee-history .card h3 { margin:0 0 12px 0; font-size:16px; font-weight:600; padding-bottom:8px; border-bottom:1px solid #e5e7eb; }
    .admin-fee-history table { width:100%; border-collapse:collapse; }
    .admin-fee-history th, .admin-fee-history td { padding:8px 12px; text-align:left; border-bottom:1px solid #e5e7eb; font-size:13px; }
    .admin-fee-history th { background:#f9fafb; font-weight:600; }
    .admin-fee-history tbody tr:hover { background:#f9fafb; }
    .admin-fee-history .fee-amount { font-weight:600; color:#059669; }
    .admin-fee-history .status-badge { padding:2px 6px; border-radius:4px; font-size:11px; font-weight:500; }
    .admin-fee-history .status-active { background:#d1fae5; color:#065f46; }
    .admin-fee-history .status-inactive { background:#fee2e2; color:#991b1b; }
    .admin-fee-history .creator-info { color:#6b7280; font-size:12px; }
    .admin-fee-history .empty-state { text-align:center; padding:32px 16px; color:#6b7280; }
    .admin-fee-history .empty-state h3 { color:#374151; font-size:16px; font-weight:600; margin:0 0 8px 0; }
    .admin-fee-history .empty-state p { margin:0; font-size:13px; }
    
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
<div class="admin-fee-history">
  <div class="container">
    <!-- Back Button -->
    <a href="{{ route('admin.fees') }}" class="btn btn-secondary">
      ← Back to Fee Management
    </a>

    @forelse($feeHistory as $feeType => $fees)
        <div class="card">
            <h3>
                @switch($feeType)
                    @case('new_jhs')
                        New Student - JHS
                        @break
                    @case('new_shs')
                        New Student - SHS
                        @break
                    @case('old_jhs')
                        Old Student - JHS
                        @break
                    @case('old_shs')
                        Old Student - SHS
                        @break
                    @default
                        {{ $feeType }}
                @endswitch
            </h3>

            <table>
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Effective Date</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                        <tr>
                            <td class="fee-amount">{{ $fee->formatted_amount }}</td>
                            <td>{{ $fee->effective_date->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge {{ $fee->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $fee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="creator-info">
                                {{ $fee->creator->username ?? $fee->creator->name ?? 'Unknown' }}
                            </td>
                            <td>{{ $fee->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="card">
            <div class="empty-state">
                <h3>No Fee History Found</h3>
                <p>No enrollment fees have been set up yet. <a href="{{ route('admin.fees') }}">Go to Fee Management</a> to set up initial fees.</p>
            </div>
        </div>
    @endforelse
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
<script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush

{{-- resources/views/partials/old_enrollee_info.blade.php --}}
<div class="modal-header flex justify-end border-b p-2">
  <button
    class="modal-close bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
    aria-label="Close"
  >✕</button>
</div>

<div class="modal-body p-4 overflow-y-auto max-h-[80vh] space-y-4">
  <h3 class="text-lg font-bold mb-4">Old-Student Enrollee Details</h3>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Personal --}}
    <div>
      <h4 class="font-semibold border-b pb-1">Personal</h4>
      <p><strong>Full Name:</strong>
         {{ $enrollee->surname }}, {{ $enrollee->given_name }} {{ $enrollee->middle_name }}
      </p>
      <p><strong>LRN:</strong> {{ $enrollee->lrn }}</p>
      <p><strong>Student ID #:</strong> {{ $enrollee->student_id }}</p>
      <p><strong>Applying Grade Level:</strong> {{ $enrollee->grade_level_applying }}</p>
      <p><strong>Semester:</strong> {{ ucfirst($enrollee->semester) }}</p>
    </div>

    {{-- Terms & Payment --}}
    <div>
      <h4 class="font-semibold border-b pb-1">Terms & Payment</h4>
      @php
        $terms = $enrollee->terms_accepted;
        if (! is_array($terms)) {
            // if for some reason it's a JSON string, decode
            $terms = json_decode($terms, true) ?: [];
        }
      @endphp
      <p>
        <strong>Terms Accepted:</strong>
        {{ $terms ? implode(', ', $terms) : '–' }}
      </p>
      <p><strong>Applicant Name:</strong>
         {{ $enrollee->payment_applicant_name ?? '–' }}
      </p>
      <p><strong>Reference #:</strong>
         {{ $enrollee->payment_reference ?? '–' }}
      </p>
      <p><strong>Paid:</strong> {{ $enrollee->paid ? 'Yes' : 'No' }}</p>
    </div>

    {{-- Files --}}
    <div>
      <h4 class="font-semibold border-b pb-1">Files</h4>
      <p>
        <strong>Payment Receipt:</strong>
        @if($enrollee->payment_receipt_path)
          <a href="{{ Storage::url($enrollee->payment_receipt_path) }}" target="_blank">
            Download
          </a>
        @else
          –
        @endif
      </p>
      <p>
        <strong>Clearance:</strong>
        @if($enrollee->clearance_path)
          <a href="{{ Storage::url($enrollee->clearance_path) }}" target="_blank">
            Download
          </a>
        @else
          –
        @endif
      </p>
    </div>

    {{-- Meta --}}
    <div>
      <h4 class="font-semibold border-b pb-1">Meta</h4>
      <p><strong>Application #:</strong> {{ $enrollee->application_number }}</p>
      <p>
        <strong>Created:</strong>
        {{ $enrollee->created_at->format('F j, Y @ H:i') }}
      </p>
      <p>
        <strong>Updated:</strong>
        {{ $enrollee->updated_at->format('F j, Y @ H:i') }}
      </p>
    </div>
  </div>
</div>

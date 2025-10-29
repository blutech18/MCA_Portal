
@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Enrollee Details')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Enrollee Details</h1>

```
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-2">
        <h2 class="font-bold">Personal Information</h2>
        <p><strong>Full Name:</strong> {{ $enrollee->display_name }}</p>
        <p><strong>LRN:</strong> {{ $enrollee->lrn }}</p>
        <p><strong>Date of Birth:</strong> {{ $enrollee->dob }}</p>
        <p><strong>Gender:</strong> {{ ucfirst($enrollee->gender) }}</p>
        <p><strong>Nationality:</strong> {{ $enrollee->nationality }}</p>
        <p><strong>Religion:</strong> {{ $enrollee->religion }}</p>
    </div>

    <div class="space-y-2">
        <h2 class="font-bold">Contact & Address</h2>
        <p><strong>Contact No.:</strong> {{ $enrollee->contact_no }}</p>
        <p><strong>Email:</strong> {{ $enrollee->email }}</p>
        <p><strong>Address:</strong> {{ $enrollee->address }}</p>
        <p><strong>Living With:</strong> {{ $enrollee->living_with }}</p>
    </div>

    <div class="space-y-2">
        <h2 class="font-bold">Academic Information</h2>
        <p><strong>Strand:</strong> {{ $enrollee->strand ?? '–' }}</p>
        <p><strong>Semester:</strong> {{ $enrollee->semester ?? '–' }}</p>
        <p><strong>Former School:</strong> {{ $enrollee->former_school }}</p>
        <p><strong>Grade Level:</strong> 
          @if($enrollee->shs_grade)
              {{ $enrollee->shs_grade }}
          @else
              {{ $enrollee->previous_grade }}
          @endif
        </p>
        <p><strong>Last School Year:</strong> {{ $enrollee->last_school_year }}</p>
        <p><strong>School Type:</strong> {{ $enrollee->school_type }}</p>
        <p><strong>School Address:</strong> {{ $enrollee->school_address }}</p>
        <p><strong>Reason for Transfer:</strong> {{ $enrollee->reason_transfer }}</p>
    </div>

    <div class="space-y-2">
        <h2 class="font-bold">Family Information</h2>
        <p><strong>Father:</strong> {{ $enrollee->father_name }} ({{ $enrollee->father_occupation }}) – {{ $enrollee->father_contact_no }}, {{ $enrollee->father_email }}</p>
        <p><strong>Mother:</strong> {{ $enrollee->mother_name }} ({{ $enrollee->mother_occupation }}) – {{ $enrollee->mother_contact_no }}, {{ $enrollee->mother_email }}</p>
        <p><strong>Guardian:</strong> {{ $enrollee->guardian_name }} ({{ $enrollee->guardian_occupation }}) – {{ $enrollee->guardian_contact_no }}, {{ $enrollee->guardian_email }}</p>
        <p><strong>Siblings:</strong> {{ $enrollee->siblings ?? '–' }}</p>
        <p><strong>Working Student:</strong> {{ $enrollee->working_student ? 'Yes' : 'No' }}</p>
        <p><strong>Intend Working:</strong> {{ $enrollee->intend_working_student ? 'Yes' : 'No' }}</p>
        <p><strong>Club Member:</strong> {{ $enrollee->club_member ? $enrollee->club_name : 'No' }}</p>
    </div>

    <div class="space-y-2 md:col-span-2">
        <h2 class="font-bold">Medical & Documents</h2>
        <p><strong>Medical History:</strong> {{ $enrollee->medical_history ?? '–' }}</p>
        <p><strong>Allergy:</strong> {{ $enrollee->allergy_specify ?? '–' }}</p>
        <p><strong>Other Conditions:</strong> {{ $enrollee->others_specify ?? '–' }}</p>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3>Report Card</h3>
                @php
                  $doc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)->where('enrollment_type','new')->where('document_type','report_card')->first();
                @endphp
                @if($doc)
                  <a href="{{ route('admin.documents.serve-by-id', ['id' => $doc->id]) }}" target="_blank">Download</a>
                @elseif($enrollee->report_card_path && Storage::disk('public')->exists($enrollee->report_card_path))
                  <a href="{{ Storage::url($enrollee->report_card_path) }}" target="_blank">Download</a>
                @elseif($enrollee->report_card_path)
                  <span class="text-red-500 text-sm">File missing</span>
                  <form action="{{ route('admin.documents.reupload') }}" method="POST" enctype="multipart/form-data" class="mt-2 flex gap-2 items-center">
                    @csrf
                    <input type="hidden" name="enrollee_id" value="{{ $enrollee->id }}">
                    <input type="hidden" name="enrollment_type" value="new">
                    <input type="hidden" name="document_type" value="report_card">
                    <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required class="text-sm">
                    <button type="submit" class="px-3 py-1 bg-red-700 text-white text-xs rounded">Re-upload</button>
                  </form>
                @else
                  <span>–</span>
                @endif
            </div>
            <div>
                <h3>Good Moral</h3>
                @php
                  $doc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)->where('enrollment_type','new')->where('document_type','good_moral')->first();
                @endphp
                @if($doc)
                  <a href="{{ route('admin.documents.serve-by-id', ['id' => $doc->id]) }}" target="_blank">Download</a>
                @elseif($enrollee->good_moral_path && Storage::disk('public')->exists($enrollee->good_moral_path))
                  <a href="{{ Storage::url($enrollee->good_moral_path) }}" target="_blank">Download</a>
                @elseif($enrollee->good_moral_path)
                  <span class="text-red-500 text-sm">File missing</span>
                  <form action="{{ route('admin.documents.reupload') }}" method="POST" enctype="multipart/form-data" class="mt-2 flex gap-2 items-center">
                    @csrf
                    <input type="hidden" name="enrollee_id" value="{{ $enrollee->id }}">
                    <input type="hidden" name="enrollment_type" value="new">
                    <input type="hidden" name="document_type" value="good_moral">
                    <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required class="text-sm">
                    <button type="submit" class="px-3 py-1 bg-red-700 text-white text-xs rounded">Re-upload</button>
                  </form>
                @else
                  <span>–</span>
                @endif
            </div>
            <div>
                <h3>Birth Certificate</h3>
                @php
                  $doc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)->where('enrollment_type','new')->where('document_type','birth_certificate')->first();
                @endphp
                @if($doc)
                  <a href="{{ route('admin.documents.serve-by-id', ['id' => $doc->id]) }}" target="_blank">Download</a>
                @elseif($enrollee->birth_certificate_path && Storage::disk('public')->exists($enrollee->birth_certificate_path))
                  <a href="{{ Storage::url($enrollee->birth_certificate_path) }}" target="_blank">Download</a>
                @elseif($enrollee->birth_certificate_path)
                  <span class="text-red-500 text-sm">File missing</span>
                  <form action="{{ route('admin.documents.reupload') }}" method="POST" enctype="multipart/form-data" class="mt-2 flex gap-2 items-center">
                    @csrf
                    <input type="hidden" name="enrollee_id" value="{{ $enrollee->id }}">
                    <input type="hidden" name="enrollment_type" value="new">
                    <input type="hidden" name="document_type" value="birth_certificate">
                    <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required class="text-sm">
                    <button type="submit" class="px-3 py-1 bg-red-700 text-white text-xs rounded">Re-upload</button>
                  </form>
                @else
                  <span>–</span>
                @endif
            </div>
            <div>
                <h3>ID Picture</h3>
                @php
                  $doc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)->where('enrollment_type','new')->where('document_type','id_picture')->first();
                @endphp
                @if($doc)
                  <img src="{{ 'data:' . $doc->mime_type . ';base64,' . $doc->file_data }}" alt="ID Picture" class="w-24 h-24 object-cover">
                @elseif($enrollee->id_picture_path && Storage::disk('public')->exists($enrollee->id_picture_path))
                  <img src="{{ Storage::url($enrollee->id_picture_path) }}" alt="ID Picture" class="w-24 h-24 object-cover">
                @elseif($enrollee->id_picture_path)
                  <span class="text-red-500 text-sm">Image missing</span>
                @else
                  <span>–</span>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-2 md:col-span-2">
        <h2 class="font-bold">Payment Info</h2>
        <p><strong>Applicant Name:</strong> {{ $enrollee->payment_applicant_name ?? '–' }}</p>
        <p><strong>Reference #:</strong> {{ $enrollee->payment_reference ?? '–' }}</p>
        <p><strong>Paid:</strong> {{ $enrollee->paid ? 'Yes' : 'No' }}</p>
        @php
          $receiptDoc = \App\Models\StudentDocument::where('enrollment_id', $enrollee->id)->where('enrollment_type','new')->where('document_type','payment_receipt')->first();
        @endphp
        @if($receiptDoc)
          <a href="{{ route('admin.documents.serve-by-id', ['id' => $receiptDoc->id]) }}" target="_blank">Download Receipt</a>
        @elseif($enrollee->payment_receipt_path && Storage::disk('public')->exists($enrollee->payment_receipt_path))
          <a href="{{ Storage::url($enrollee->payment_receipt_path) }}" target="_blank">Download Receipt</a>
        @elseif($enrollee->payment_receipt_path)
          <span class="text-red-500 text-sm">Receipt file missing</span>
          <form action="{{ route('admin.documents.reupload') }}" method="POST" enctype="multipart/form-data" class="mt-2 flex gap-2 items-center">
            @csrf
            <input type="hidden" name="enrollee_id" value="{{ $enrollee->id }}">
            <input type="hidden" name="enrollment_type" value="new">
            <input type="hidden" name="document_type" value="payment_receipt">
            <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required class="text-sm">
            <button type="submit" class="px-3 py-1 bg-red-700 text-white text-xs rounded">Re-upload</button>
          </form>
        @else
          <span>–</span>
        @endif
    </div>

</div>

<a href="{{ route('admin.enrollees') }}" class="mt-6 inline-block btn-secondary">Back to List</a>
```

</div>
@endsection

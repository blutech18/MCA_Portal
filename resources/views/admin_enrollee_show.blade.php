
@extends('layouts.admin')

@section('title', 'Enrollee Details')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Enrollee Details</h1>

```
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-2">
        <h2 class="font-bold">Personal Information</h2>
        <p><strong>Full Name:</strong> {{ $enrollee->surname }}, {{ $enrollee->given_name }} {{ $enrollee->middle_name }}</p>
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
        <p><strong>Previous Grade:</strong> {{ $enrollee->previous_grade }}</p>
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
                @if($enrollee->report_card_path)
                    <a href="{{ Storage::url($enrollee->report_card_path) }}" target="_blank">Download</a>
                @else
                    <span>–</span>
                @endif
            </div>
            <div>
                <h3>Good Moral</h3>
                @if($enrollee->good_moral_path)
                    <a href="{{ Storage::url($enrollee->good_moral_path) }}" target="_blank">Download</a>
                @else
                    <span>–</span>
                @endif
            </div>
            <div>
                <h3>Birth Certificate</h3>
                @if($enrollee->birth_certificate_path)
                    <a href="{{ Storage::url($enrollee->birth_certificate_path) }}" target="_blank">Download</a>
                @else
                    <span>–</span>
                @endif
            </div>
            <div>
                <h3>ID Picture</h3>
                @if($enrollee->id_picture_path)
                    <img src="{{ Storage::url($enrollee->id_picture_path) }}" alt="ID Picture" class="w-24 h-24 object-cover">
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
        @if($enrollee->payment_receipt_path)
            <a href="{{ Storage::url($enrollee->payment_receipt_path) }}" target="_blank">Download Receipt</a>
        @endif
    </div>

</div>

<a href="{{ route('admin.enrollees') }}" class="mt-6 inline-block btn-secondary">Back to List</a>
```

</div>
@endsection

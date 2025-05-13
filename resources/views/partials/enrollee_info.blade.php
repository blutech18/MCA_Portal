
<div class="bg-white rounded-lg overflow-hidden shadow-lg">
  {{-- Header --}}
  <div class="flex justify-between items-center bg-gray-100 px-4 py-2 border-b">
    
    <button
    class="modal-close bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded shadow-md transition duration-200 ml-auto"
    aria-label="Close"
    >
    Hide Info
    </button>
  </div>

  {{-- Body --}}
  <div class="p-4 max-h-[70vh] overflow-y-auto space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      {{-- Personal Information --}}
      <div class="space-y-2">
        <h4 class="font-bold text-gray-700">Personal Information</h4>
        <p><span class="font-medium">Full Name:</span> {{ $enrollee->surname }}, {{ $enrollee->given_name }} {{ $enrollee->middle_name }}</p>
        <p><span class="font-medium">LRN:</span> {{ $enrollee->lrn }}</p>
        <p><span class="font-medium">Date of Birth:</span> {{ $enrollee->dob }}</p>
        <p><span class="font-medium">Gender:</span> {{ ucfirst($enrollee->gender) }}</p>
        <p><span class="font-medium">Nationality:</span> {{ $enrollee->nationality }}</p>
        <p><span class="font-medium">Religion:</span> {{ $enrollee->religion }}</p>
      </div>

      {{-- Contact & Address --}}
      <div class="space-y-2">
        <h4 class="font-bold text-gray-700">Contact & Address</h4>
        <p><span class="font-medium">Contact No.:</span> {{ $enrollee->contact_no }}</p>
        <p><span class="font-medium">Email:</span> {{ $enrollee->email }}</p>
        <p><span class="font-medium">Address:</span> {{ $enrollee->address }}</p>
        <p><span class="font-medium">Living With:</span> {{ $enrollee->living_with }}</p>
      </div>

      {{-- Academic Information --}}
      <div class="space-y-2">
        <h4 class="font-bold text-gray-700">Academic Information</h4>
        <p><span class="font-medium">Strand:</span> {{ $enrollee->strand ?? '–' }}</p>
        <p><span class="font-medium">Semester:</span> {{ $enrollee->semester ?? '–' }}</p>
        <p><span class="font-medium">Former School:</span> {{ $enrollee->former_school }}</p>
        <p><span class="font-medium">Previous Grade:</span> {{ $enrollee->previous_grade }}</p>
        <p><span class="font-medium">Last School Year:</span> {{ $enrollee->last_school_year }}</p>
        <p><span class="font-medium">School Type:</span> {{ $enrollee->school_type }}</p>
        <p><span class="font-medium">School Address:</span> {{ $enrollee->school_address }}</p>
        <p><span class="font-medium">Reason for Transfer:</span> {{ $enrollee->reason_transfer }}</p>
      </div>

      {{-- Family Information --}}
      <div class="space-y-2">
        <h4 class="font-bold text-gray-700">Family Information</h4>
        <p><span class="font-medium">Father:</span> {{ $enrollee->father_name }} ({{ $enrollee->father_occupation }}) – {{ $enrollee->father_contact_no }}, {{ $enrollee->father_email }}</p>
        <p><span class="font-medium">Mother:</span> {{ $enrollee->mother_name }} ({{ $enrollee->mother_occupation }}) – {{ $enrollee->mother_contact_no }}, {{ $enrollee->mother_email }}</p>
        <p><span class="font-medium">Guardian:</span> {{ $enrollee->guardian_name }} ({{ $enrollee->guardian_occupation }}) – {{ $enrollee->guardian_contact_no }}, {{ $enrollee->guardian_email }}</p>
        <p><span class="font-medium">Siblings:</span> {{ $enrollee->siblings ?? '–' }}</p>
        <p><span class="font-medium">Working Student:</span> {{ $enrollee->working_student ? 'Yes' : 'No' }}</p>
        <p><span class="font-medium">Intend Working:</span> {{ $enrollee->intend_working_student ? 'Yes' : 'No' }}</p>
        <p><span class="font-medium">Club Member:</span> {{ $enrollee->club_member ? $enrollee->club_name : 'No' }}</p>
      </div>
    </div>

    {{-- Documents --}}
    <div class="border-t pt-4 space-y-4">
      <h4 class="font-bold text-gray-700">Medical & Documents</h4>
      <p><span class="font-medium">Medical History:</span> {{ $enrollee->medical_history ?? '–' }}</p>
      <p><span class="font-medium">Allergy:</span> {{ $enrollee->allergy_specify ?? '–' }}</p>
      <p><span class="font-medium">Other Conditions:</span> {{ $enrollee->others_specify ?? '–' }}</p>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
          'report_card_path'       => 'Report Card',
          'good_moral_path'        => 'Good Moral',
          'birth_certificate_path' => 'Birth Certificate',
        ] as $field => $label)
          <div class="space-y-1">
            <h5 class="font-medium">{{ $label }}</h5>
            @if($enrollee->$field)
              <a 
                href="{{ Storage::url($enrollee->$field) }}" 
                target="_blank"
                class="text-blue-600 hover:underline"
              >Download</a>
            @else
              <span class="text-gray-500">–</span>
            @endif
          </div>
        @endforeach

        {{-- ID Picture --}}
        <div class="space-y-1">
          <h5 class="font-medium">ID Picture</h5>
          @if($enrollee->id_picture_path)
            <img 
              src="{{ Storage::url($enrollee->id_picture_path) }}"
              alt="ID Picture"
              class="w-16 h-16 object-cover rounded border"
            >
          @else
            <span class="text-gray-500">–</span>
          @endif
        </div>
      </div>
    </div>

    {{-- Payment Info --}}
    <div class="border-t pt-4 space-y-2">
      <h4 class="font-bold text-gray-700">Payment Info</h4>
      <p><span class="font-medium">Applicant Name:</span> {{ $enrollee->payment_applicant_name ?? '–' }}</p>
      <p><span class="font-medium">Reference #:</span> {{ $enrollee->payment_reference ?? '–' }}</p>
      <p><span class="font-medium">Paid:</span> {{ $enrollee->paid ? 'Yes' : 'No' }}</p>
      @if($enrollee->payment_receipt_path)
        <div>
          <a 
            href="{{ Storage::url($enrollee->payment_receipt_path) }}" 
            target="_blank"
            class="text-blue-600 hover:underline"
          >Download Receipt</a>
        </div>
      @endif
    </div>
  </div>
</div>

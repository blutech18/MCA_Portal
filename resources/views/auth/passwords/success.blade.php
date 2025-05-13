@extends('layouts.login_extend')

@section('content')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Password Changed!',
        text: 'Your password has been successfully updated.',
        icon: 'success',
        confirmButtonText: 'Go to Login'
    }).then(() => {
        window.location.href = "{{ route('login') }}";
    });
</script>
@endsection

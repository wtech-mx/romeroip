@php
    $validationMessages = collect($errors->all())->values();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Swal) {
            return;
        }

        const alertConfig = {
            confirmButtonColor: '#FF7F11',
            background: '#fff',
        };

        @if (session('trademark_saved'))
            Swal.fire({
                background: '#fff',
                icon: 'success',
                title: 'Trademark record saved',
                text: 'Review the saved information here. Choose Edit to make changes, or Back to return to Search.',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true,
            });
        @endif

        @if (session('success'))
            Swal.fire({
                ...alertConfig,
                icon: 'success',
                title: 'Saved successfully',
                text: @json(session('success')),
            });
        @endif

        @if (session('edit'))
            Swal.fire({
                ...alertConfig,
                icon: 'success',
                title: 'Updated successfully',
                text: @json(session('edit')),
            });
        @endif

        @if (session('delete'))
            Swal.fire({
                ...alertConfig,
                icon: 'success',
                title: 'Deleted successfully',
                text: @json(session('delete')),
            });
        @endif

        @if (session('swal_error'))
            Swal.fire({
                ...alertConfig,
                icon: 'error',
                title: 'Something went wrong',
                text: @json(session('swal_error')),
            });
        @endif

        @if (session('info'))
            Swal.fire({
                ...alertConfig,
                icon: 'info',
                title: 'Notice',
                text: @json(session('info')),
            });
        @endif

        @if ($validationMessages->isNotEmpty())
            Swal.fire({
                ...alertConfig,
                icon: 'warning',
                title: 'Please review the form',
                html: `
                    <div class="text-start">
                        @foreach ($validationMessages as $message)
                            <div class="mb-2">
                                <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                {{ $message }}
                            </div>
                        @endforeach
                    </div>
                `,
            });
        @endif
    });
</script>

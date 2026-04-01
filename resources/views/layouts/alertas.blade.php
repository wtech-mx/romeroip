@if (Session::has('success'))
<script>
    Swal.fire({
        title: 'Exito!!',
        html: 'Se ha <b>agragado</b> </br> ',
        imageUrl: '{{ asset('img/icon/checked.png') }}',
        background: '#fff',
        imageWidth: 150,
        imageHeight: 150,
    })

</script>
@endif

@if (Session::has('edit'))
<script>
    Swal.fire({
        title: 'Exito!!',
        html: 'Se ha <b>editado</b> </br>',
        imageUrl: '{{ asset('img/icon/edit.png') }}',
        background: '#fff',
        imageWidth: 150,
        imageHeight: 150,
    })

</script>
@endif

@if (Session::has('delete'))
<script>
    Swal.fire({
        title: 'Exito!!',
        html: 'Se ha <b>eliminado</b> </br>',
        imageUrl: '{{ asset('img/icon/delete.png') }}',
        background: '#fff',
        imageWidth: 150,
        imageHeight: 150,
    })

</script>
@endif
@if(session('swal_error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Search error',
            text: @json(session('swal_error')),
            confirmButtonColor: '#FF7F11'
        });
    });
</script>
@endif

@if(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'info',
            title: 'No results',
            text: @json(session('info')),
            confirmButtonColor: '#FF7F11'
        });
    });
</script>
@endif

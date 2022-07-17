{{-- Message --}}
@if (Session::has('success'))
      <div class="alert alert-success" role="alert">
          <strong>Success!</strong> {{ session('success') }}
      </div>
@endif

@if (Session::has('error'))
  <div class="alert alert-danger" role="alert">
      <strong>Danger!</strong>  {{ session('error') }}
  </div>
@endif

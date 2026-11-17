@extends('layouts.app')
@section('template_title', 'Edit Owner')
@section('content')
<div class="owner-page">
    <form id="owner-form" action="{{ route('update.holder', $holder->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <header class="owner-heading"><h1>Edit Owner</h1><div><a class="tm-btn" href="{{ route('index.holder') }}">Back</a><button class="tm-btn tm-btn-primary" type="submit">Update</button></div></header>
        @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @include('holder._form', ['owner' => $holder, 'addresses' => $address_holder])
    </form>
</div>
@endsection
@section('js_custom')
<script src="{{ asset('assets/js/trademark-dates.js') }}?v={{ filemtime(public_path('assets/js/trademark-dates.js')) }}"></script>
<script src="{{ asset('assets/js/owner-form.js') }}?v={{ filemtime(public_path('assets/js/owner-form.js')) }}"></script>
@endsection

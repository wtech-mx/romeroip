@extends('layouts.app')
@section('template_title', 'New Owner')
@section('content')
<div class="owner-page">
    <form data-owner-type="{{ old('owner_type', 'Company') ?: 'Company' }}" id="owner-form" action="{{ route('store.holder') }}" method="POST">
        @csrf

        <header class="owner-heading"><h1>New Owner</h1><div><a class="tm-btn" href="{{ route('index.holder') }}">Back</a><button class="tm-btn tm-btn-primary" type="submit">Save</button></div></header>
        @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @include('holder._form', ['owner' => null, 'addresses' => collect()])
    </form>
</div>
@endsection
@section('js_custom')
<script src="{{ asset('assets/js/trademark-dates.js') }}?v={{ filemtime(public_path('assets/js/trademark-dates.js')) }}"></script>
<script src="{{ asset('assets/js/owner-form.js') }}?v={{ filemtime(public_path('assets/js/owner-form.js')) }}"></script>
@endsection

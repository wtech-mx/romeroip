@extends('layouts.app')
@section('template_title', $editing ? 'Account Settings' : 'My Profile')
@section('content')
<div class="card account-panel">
    <div class="card-header"><h1>{{ $editing ? 'Account Settings' : 'My Profile' }}</h1></div>
    <div class="card-body">
        @if(session('account_saved'))<p role="status">Account settings saved.</p>@endif
        @if($editing)
        <form action="{{ route('account.update') }}" method="POST">
            @csrf @method('PATCH')
            <label for="account-name">Name</label><input id="account-name" name="name" class="form-control" value="{{ old('name', $account->name) }}" required maxlength="255">
            @error('name')<p role="alert">{{ $message }}</p>@enderror
            <label for="account-email">Email</label><input id="account-email" name="email" type="email" class="form-control" value="{{ old('email', $account->email) }}" required maxlength="255">
            @error('email')<p role="alert">{{ $message }}</p>@enderror
            <label for="account-locale">Language</label><select id="account-locale" name="locale" class="form-control"><option value="en" @selected(old('locale', session('locale', 'en')) === 'en')>English</option><option value="es" @selected(old('locale', session('locale')) === 'es')>Español</option></select>
            <button class="btn btn-primary mt-3" type="submit">Save</button>
        </form>
        @else
        <dl><dt>Name</dt><dd>{{ $account->name }}</dd><dt>Email</dt><dd>{{ $account->email }}</dd></dl>
        <a class="btn" href="{{ route('account.settings') }}">Account Settings</a>
        @endif
    </div>
</div>
@endsection

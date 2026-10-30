@extends('layouts.app')
@section('template_title', $editing ? 'Account Settings' : 'My Profile')
@section('content')
<div class="card account-panel">
    <div class="card-header"><h1>{{ $editing ? 'Account Settings' : 'My Profile' }}</h1></div>
    <div class="card-body">
        @if(session('account_saved'))<p role="status">Account settings saved.</p>@endif
        <div class="account-photo">
            @if($account->getAttribute('profile_photo_path'))
                <img class="legal-profile-avatar" src="{{ asset($account->profile_photo_path) }}" alt="Profile photograph">
            @else
                <span class="legal-profile-avatar">{{ collect(preg_split('/\s+/u', trim($account->name)))->take(2)->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('') }}</span>
            @endif
            <form action="{{ route('account.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="profile-photo">Profile photograph</label>
                <input class="form-control" id="profile-photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" required>
                @error('photo')<p role="alert">{{ $message }}</p>@enderror
                <button class="btn mt-2" type="submit">{{ $account->getAttribute('profile_photo_path') ? 'Replace photo' : 'Upload photo' }}</button>
            </form>
            @if($account->getAttribute('profile_photo_path'))
            <form action="{{ route('account.photo.remove') }}" method="POST">@csrf @method('DELETE')<button class="btn" type="submit">Remove photo</button></form>
            @endif
        </div>
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

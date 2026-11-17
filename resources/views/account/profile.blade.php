@extends('layouts.app')
@section('template_title', $editing ? 'Account Settings' : 'My Profile')
@section('content')
<div class="card account-panel">
    <div class="card-header"><h1>{{ $editing ? 'Account Settings' : 'My Profile' }}</h1></div>
    <div class="card-body">
        @if(session('account_saved'))<p role="status">Account settings saved.</p>@endif
        <div class="account-photo">
            @include('shared.profile-avatar', ['user' => $account, 'avatarClass' => 'account-profile-avatar'])
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
        <form action="{{ $editing ? route('account.update') : route('account.profile.update') }}" method="POST">
            @csrf @method('PATCH')
            <label for="account-name">Display Name</label><input id="account-name" name="name" class="form-control" value="{{ old('name', $account->name) }}" required maxlength="255">
            @error('name')<p role="alert">{{ $message }}</p>@enderror
            <label for="account-job-title">Job Title / Position</label><input id="account-job-title" name="job_title" class="form-control" maxlength="255" value="{{ old('job_title', $account->job_title) }}">
            @error('job_title')<p role="alert">{{ $message }}</p>@enderror
            <label for="account-email">Email</label><input id="account-email" name="email" type="email" class="form-control" value="{{ old('email', $account->email) }}" required maxlength="255">
            @error('email')<p role="alert">{{ $message }}</p>@enderror
            @if($editing)
            <label for="account-locale">Language</label><select id="account-locale" name="locale" class="form-control"><option value="en" @selected(old('locale', $account->preferred_locale ?: session('locale', 'en')) === 'en')>English</option><option value="es" @selected(old('locale', $account->preferred_locale ?: session('locale')) === 'es')>Español</option></select>
            @endif
            @if($account->profile_photo_path)
            <fieldset class="mt-3" data-photo-position>
                <legend class="h6">Center profile photo</legend>
                <span class="account-avatar-frame"><img data-photo-preview src="{{ asset($account->profile_photo_path) }}" alt="Profile photo preview"></span>
                @foreach(['x' => 'Horizontal position', 'y' => 'Vertical position', 'zoom' => 'Zoom'] as $axis => $label)
                <label for="photo-{{ $axis }}">{{ $label }}</label>
                <input id="photo-{{ $axis }}" type="range" name="profile_photo_{{ $axis }}" min="{{ $axis === 'zoom' ? 1 : 0 }}" max="{{ $axis === 'zoom' ? 3 : 100 }}" step="{{ $axis === 'zoom' ? '0.05' : 1 }}" value="{{ old('profile_photo_'.$axis, $account->getAttribute('profile_photo_'.$axis) ?? ($axis === 'zoom' ? 1 : 50)) }}">
                @endforeach
                <button type="button" class="btn btn-sm" data-photo-center>Center</button>
            </fieldset>
            @endif
            <button class="btn btn-primary mt-3" type="submit">Save</button>
        </form>
        @if($editing)
        <section class="mt-4"><h2 class="h5">Results preferences</h2>
            @include('trademark._column-preferences')
        </section>
        @endif
    </div>
</div>
@endsection

@section('js_custom')
@if($editing) @include('trademark._column-config') @endif
<script src="{{ asset('assets/js/profile-position.js') }}?v={{ filemtime(public_path('assets/js/profile-position.js')) }}"></script>
@endsection

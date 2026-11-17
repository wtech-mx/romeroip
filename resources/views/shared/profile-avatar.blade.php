@php
    $avatarPhoto = $user->getAttribute('profile_photo_path') ? asset($user->profile_photo_path) : ($user->getAttribute('profile_photo_url') ?: $user->getAttribute('avatar_url'));
    $avatarInitials = collect(preg_split('/\s+/u', trim($user->name)))->take(2)->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
@endphp
<span class="legal-avatar-crop {{ $avatarClass ?? '' }}" aria-hidden="true">
    @if($avatarPhoto)
    <img src="{{ $avatarPhoto }}" alt="" style="object-position:{{ $user->profile_photo_x ?? 50 }}% {{ $user->profile_photo_y ?? 50 }}%;transform:scale({{ $user->profile_photo_zoom ?? 1 }});transform-origin:{{ $user->profile_photo_x ?? 50 }}% {{ $user->profile_photo_y ?? 50 }}%">
    @else
    <span class="legal-avatar-initials">{{ $avatarInitials }}</span>
    @endif
</span>

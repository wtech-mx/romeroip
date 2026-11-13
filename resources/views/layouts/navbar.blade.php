@php
    $isTrademarkModule = Request::is('trademarks*');
    $isOpenFile = Route::is('show.trademarks', 'edit.trademarks') && isset($trademark);
    $isFileSearch = Route::is('show.trademarks', 'edit.trademarks', 'create.trademarks');
    $isFileEdit = Route::is('edit.trademarks');
    $signedUser = Auth::user();
    $initials = collect(preg_split('/\s+/u', trim($signedUser->name)))->take(2)->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
    $profilePhoto = $signedUser->getAttribute('profile_photo_path') ? asset($signedUser->profile_photo_path) : ($signedUser->getAttribute('profile_photo_url') ?: $signedUser->getAttribute('avatar_url'));
@endphp
<nav aria-label="Main navigation" class="legal-navbar legal-topbar legal-topbar-global" id="navbarBlur">
    <div class="legal-topbar-left">
        <button type="button" class="legal-menu-toggle" id="legalMobileSidebarToggle" data-sidebar-toggle aria-label="Toggle sidebar" aria-controls="sidenav-main" aria-expanded="true"><i class="bi bi-list" aria-hidden="true"></i></button>
        <nav aria-label="Breadcrumb"><ol class="legal-breadcrumb">
            <li><a href="{{ $isTrademarkModule ? route('index.trademarks') : route('dashboard') }}">{{ $isTrademarkModule ? 'Trademarks' : 'Dashboard' }}</a></li>
            @if($isOpenFile)
            <li>@if($isFileEdit)<a href="{{ route('show.trademarks', $trademark->id) }}" data-breadcrumb-reference>File {{ $trademark->our_ref ?: '—' }}</a>@else<span data-breadcrumb-reference>File {{ $trademark->our_ref ?: '—' }}</span>@endif</li>
            @if($isFileEdit)<li aria-current="page">Edit</li>@endif
            @elseif(Route::is('create.trademarks'))<li aria-current="page">New Trademark</li>@endif
        </ol></nav>
    </div>
    <div class="legal-header-tools">
    <form class="legal-global-search" data-global-search data-search-mode="{{ $isFileSearch ? 'file' : 'global' }}" data-live-results="{{ route('advance_search', ['status' => 'Live']) }}" action="{{ $isFileSearch ? route('trademarks.quick-search') : route('trademarks.global-search') }}" method="GET" role="search" novalidate>
        <button type="submit" aria-label="Global Search"><i class="bi bi-search" aria-hidden="true"></i></button>
        <input id="global-search-query" name="q" aria-label="Global Search" placeholder="{{ $isFileSearch ? 'Search by file, application or registration number...' : 'Search by trademark, reference, number, owner or client...' }}" value="{{ Route::is('index.trademarks', 'advance_search') ? request('q') : '' }}" autocomplete="off" required>
        <button type="button" data-global-clear aria-label="Clear search"><i class="bi bi-x" aria-hidden="true"></i></button>
        <span class="legal-global-status" role="status" aria-live="polite" hidden></span>
    </form>
    <div class="dropdown legal-new">
        <button class="legal-new-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">+ New <span class="legal-chevron" aria-hidden="true"></span></button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('create.trademarks') }}">New Trademark</a></li>
            <li><a class="dropdown-item" href="{{ route('create.holder') }}">New Owner</a></li>
            <li><a class="dropdown-item" href="{{ route('create.clients') }}">New Client</a></li>
            <li><a class="dropdown-item" href="{{ route('tasks.create') }}">New Task</a></li>
            <li><a class="dropdown-item" href="{{ route('events.create') }}">New Event</a></li>
        </ul>
    </div>
    <div class="dropdown">
        <button class="legal-header-icon" type="button" aria-label="Notifications" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-bell" aria-hidden="true"></i></button>
        <div class="dropdown-menu dropdown-menu-end p-3"><p class="mb-0 text-sm">No notifications.</p></div>
    </div>
    <div class="dropdown legal-profile">
        <button class="legal-profile-button" type="button" id="legalProfileButton" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ $signedUser->name }}" title="{{ $signedUser->name }}">
            @if($profilePhoto)<span class="legal-avatar-crop"><img class="legal-profile-avatar" src="{{ $profilePhoto }}" alt="" style="object-position:{{ $signedUser->profile_photo_x ?? 50 }}% {{ $signedUser->profile_photo_y ?? 50 }}%;transform:scale({{ $signedUser->profile_photo_zoom ?? 1 }});transform-origin:{{ $signedUser->profile_photo_x ?? 50 }}% {{ $signedUser->profile_photo_y ?? 50 }}%"></span>@else<span class="legal-profile-avatar" aria-hidden="true">{{ $initials }}</span>@endif
            <span class="legal-chevron" aria-hidden="true"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="legalProfileButton">
            <li><a class="dropdown-item" href="{{ route('account.profile') }}">My Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('account.settings') }}">Account Settings</a></li>
            <li><form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item">Sign Out</button></form></li>
        </ul>
    </div>
    </div>
</nav>
<dialog class="legal-search-results" aria-labelledby="quick-search-results-title">
    <div class="legal-search-results-heading"><h2 id="quick-search-results-title">Search Results</h2><button type="button" data-close-search aria-label="Close search results"><i class="bi bi-x-lg" aria-hidden="true"></i></button></div>
    <p data-result-count></p><div data-result-list></div>
</dialog>

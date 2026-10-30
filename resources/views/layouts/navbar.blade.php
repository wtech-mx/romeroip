@php
    $isTrademarkModule = Request::is('trademarks*');
    $isOpenFile = Route::is('show.trademarks', 'edit.trademarks') && isset($trademark);
    $isFileEdit = Route::is('edit.trademarks');
    $signedUser = Auth::user();
    $initials = collect(preg_split('/\s+/u', trim($signedUser->name)))->take(2)->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
    $profilePhoto = $signedUser->getAttribute('profile_photo_path') ? asset($signedUser->profile_photo_path) : ($signedUser->getAttribute('profile_photo_url') ?: $signedUser->getAttribute('avatar_url'));
@endphp
<nav aria-label="Main navigation" class="legal-navbar legal-topbar {{ !$isOpenFile ? 'legal-topbar-no-search' : '' }}" id="navbarBlur">
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
    @if($isOpenFile)
    <form class="legal-quick-search" data-quick-search action="{{ route('trademarks.quick-search') }}" method="GET" role="search" novalidate>
        <button type="submit" aria-label="Quick Search"><i class="bi bi-search" aria-hidden="true"></i></button>
        <input name="number" aria-label="Quick Search" placeholder="Search by case, application or registration number..." inputmode="numeric" autocomplete="off" required>
        <p class="legal-search-status" role="status" aria-live="polite" hidden></p>
    </form>
    @endif
    <div class="dropdown legal-profile">
        <button class="legal-profile-button" type="button" id="legalProfileButton" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ $signedUser->name }}" title="{{ $signedUser->name }}">
            @if($profilePhoto)<img class="legal-profile-avatar" src="{{ $profilePhoto }}" alt="">@else<span class="legal-profile-avatar" aria-hidden="true">{{ $initials }}</span>@endif
            <span class="legal-profile-name">{{ $signedUser->name }}</span><span class="legal-chevron" aria-hidden="true"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="legalProfileButton">
            <li><a class="dropdown-item" href="{{ route('account.profile') }}">My Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('account.settings') }}">Account Settings</a></li>
            <li><form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item">Sign Out</button></form></li>
        </ul>
    </div>
</nav>
<dialog class="legal-search-results" aria-labelledby="quick-search-results-title">
    <div class="legal-search-results-heading"><h2 id="quick-search-results-title">Search Results</h2><button type="button" data-close-search aria-label="Close search results"><i class="bi bi-x-lg" aria-hidden="true"></i></button></div>
    <p data-result-count></p><div data-result-list></div>
</dialog>

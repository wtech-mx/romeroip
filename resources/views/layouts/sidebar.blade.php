<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 my-3 fixed-start ms-4 legal-sidenav" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
      <img src="{{ asset('logo/'.$configuracion->logo) }}" class="navbar-brand-img h-100" alt="main_logo">
    </a>
  </div>

  <hr class="horizontal dark mt-0">

  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Menu</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <span class="nav-link-text ms-1">Home</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('trademarks*') ? 'active' : '' }}" href="{{ route('index.trademarks') }}">
          <span class="nav-link-text ms-1">Trademarks</span>
        </a>
      </li>
      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Patents</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Copyrights</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Domain Names</span></a></li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Contacts</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('clients*') ? 'active' : '' }}" href="{{ route('index.clients') }}">
          <span class="nav-link-text ms-1">Clients</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('holder*') ? 'active' : '' }}" href="{{ route('index.holder') }}">
          <span class="nav-link-text ms-1">Owners</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Communications</h6>
      </li>

      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Chat</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Calendar</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Tasks</span></a></li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Business</h6>
      </li>

      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Financial</span></a></li>
      <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-text ms-1">Marketing</span></a></li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">System</h6>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('roles*') || Request::is('users*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
          <span class="nav-link-text ms-1">Roles and Permissions</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('configuracion*') ? 'active' : '' }}" href="{{ route('index.configuracion') }}">
          <span class="nav-link-text ms-1">Settings</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="legal-sidebar-profile px-4 pb-4 mt-auto">
    <div class="legal-sidebar-name">Roberto Romero, Jr.</div>
    <div class="legal-sidebar-role">Partner / Administrator</div>
  </div>
</aside>

  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('dashboard') }}" target="">
        <img src="{{asset('logo/'.$configuracion->logo) }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold"></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link {{ (Request::is('dashboard*') ? 'active' : '') }}" href="{{ route('dashboard') }}" target="">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
             <i class="ni ni-shop text-primary text-sm opacity-10" style="color: {{$configuracion->color_iconos_sidebar}}"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ (Request::is('clients*') ? 'active' : '') }}" href="{{ route('clients.index') }}" target="">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
             <i class="ni ni-circle-08 text-sm opacity-10" style="color: {{$configuracion->color_iconos_sidebar}}"></i>
            </div>
            <span class="nav-link-text ms-1">Clientes</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ (Request::is('especialists*') ? 'active' : '') }}" href="{{ route('clients.index') }}" target="">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
             <i class="fa fa-user-md text-sm opacity-10" style="color: {{$configuracion->color_iconos_sidebar}}"></i>
            </div>
            <span class="nav-link-text ms-1">Titular</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ (Request::is('trademark*') ? 'active' : '') }}" href="/trademark" target="">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
             <i class="fa fa-user-md text-sm opacity-10" style="color: {{$configuracion->color_iconos_sidebar}}"></i>
            </div>
            <span class="nav-link-text ms-1">Trademark</span>
          </a>
        </li>

        <li class="nav-item mt-3">
          <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Modulos</h6>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#pagesExamples" class="nav-link {{ (Request::is('users*') ? 'active' : '') }}{{ (Request::is('roles*') ? 'active' : '') }}" aria-controls="pagesExamples" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <i class="ni ni-settings text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Roles y Permisos</span>
          </a>
          <div class="collapse " id="pagesExamples">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link {{ (Request::is('users*') ? 'show' : '') }}" href="{{ route('users.index') }}">
                  <span class="sidenav-mini-icon"> P </span>
                  <span class="sidenav-normal">Users</span>
                </a>

                <a class="nav-link {{ (Request::is('roles*') ? 'show' : '') }}" href="{{ route('roles.index') }}">
                  <span class="sidenav-mini-icon"> P </span>
                  <span class="sidenav-normal">Role</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item mt-3">
          <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Confuración</h6>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#sistem" class="nav-link {{ (Request::is('users*') ? 'active' : '') }}{{ (Request::is('roles*') ? 'active' : '') }}" aria-controls="sistem" role="button" aria-expanded="false">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <i class="ni ni-settings-gear-65  text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Sistema</span>
          </a>
          <div class="collapse " id="sistem">
            <ul class="nav ms-4">
              <li class="nav-item ">
                <a class="nav-link {{ (Request::is('configuracion*') ? 'show' : '') }}" href="{{ route('index.configuracion') }}">
                  <span class="sidenav-mini-icon">U</span>
                  <span class="sidenav-normal">Custom </span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <div class="icon icon-shape icon-sm text-center  me-2 d-flex align-items-center justify-content-center">
             <i class="fa fa-arrow-right text-dark" style="color: {{$configuracion->color_iconos_sidebar}}"></i>
            </div>
            <span class="nav-link-text ms-1">{{ __('Logout') }}</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </li>

      </ul>

    </div>

  </aside>

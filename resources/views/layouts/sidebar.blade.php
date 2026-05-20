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

      <li class="nav-item">
        <a data-bs-toggle="collapse" href="#financialMenu" class="nav-link" aria-controls="financialMenu" role="button" aria-expanded="false">
          <span class="nav-link-text ms-1">Financial</span>
        </a>
        <div class="collapse" id="financialMenu">
          <ul class="nav flex-column legal-submenu">
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialDashboard" class="nav-link legal-submenu-title" aria-controls="financialDashboard" role="button" aria-expanded="false">Dashboard</a>
              <div class="collapse" id="financialDashboard">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Revenue Overview</a></li>
                  <li><a class="nav-link" href="#">Pending Payments</a></li>
                  <li><a class="nav-link" href="#">Overdue Invoices</a></li>
                  <li><a class="nav-link" href="#">Monthly Billing</a></li>
                  <li><a class="nav-link" href="#">Annual Billing</a></li>
                  <li><a class="nav-link" href="#">Government Fees</a></li>
                  <li><a class="nav-link" href="#">Professional Fees</a></li>
                  <li><a class="nav-link" href="#">Total Revenue</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialInvoices" class="nav-link legal-submenu-title" aria-controls="financialInvoices" role="button" aria-expanded="false">Invoices</a>
              <div class="collapse" id="financialInvoices">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Create Invoice</a></li>
                  <li><a class="nav-link" href="#">Draft Invoices</a></li>
                  <li><a class="nav-link" href="#">Sent Invoices</a></li>
                  <li><a class="nav-link" href="#">Paid Invoices</a></li>
                  <li><a class="nav-link" href="#">Pending Invoices</a></li>
                  <li><a class="nav-link" href="#">Overdue Invoices</a></li>
                  <li><a class="nav-link" href="#">Cancelled Invoices</a></li>
                  <li><a class="nav-link" href="#">Invoice History</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialPayments" class="nav-link legal-submenu-title" aria-controls="financialPayments" role="button" aria-expanded="false">Payments</a>
              <div class="collapse" id="financialPayments">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Payment Tracking</a></li>
                  <li><a class="nav-link" href="#">Outstanding Balances</a></li>
                  <li><a class="nav-link" href="#">Payment History</a></li>
                  <li><a class="nav-link" href="#">Client Balances</a></li>
                  <li><a class="nav-link" href="#">Foreign Associate Payments</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialReports" class="nav-link legal-submenu-title" aria-controls="financialReports" role="button" aria-expanded="false">Reports</a>
              <div class="collapse" id="financialReports">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Revenue by Country</a></li>
                  <li><a class="nav-link" href="#">Revenue by Client</a></li>
                  <li><a class="nav-link" href="#">Revenue by Year</a></li>
                  <li><a class="nav-link" href="#">Revenue by Practice Area</a></li>
                  <li><a class="nav-link" href="#">Top Clients</a></li>
                  <li><a class="nav-link" href="#">Government Fees Report</a></li>
                  <li><a class="nav-link" href="#">Professional Fees Report</a></li>
                  <li><a class="nav-link" href="#">Total Billing Report</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialAnalytics" class="nav-link legal-submenu-title" aria-controls="financialAnalytics" role="button" aria-expanded="false">Analytics</a>
              <div class="collapse" id="financialAnalytics">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Monthly Charts</a></li>
                  <li><a class="nav-link" href="#">Annual Charts</a></li>
                  <li><a class="nav-link" href="#">Growth Metrics</a></li>
                  <li><a class="nav-link" href="#">Workload Metrics</a></li>
                  <li><a class="nav-link" href="#">Billing Trends</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialReminders" class="nav-link legal-submenu-title" aria-controls="financialReminders" role="button" aria-expanded="false">Automatic Reminders</a>
              <div class="collapse" id="financialReminders">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Pending Invoice Reminder</a></li>
                  <li><a class="nav-link" href="#">Overdue Invoice Reminder</a></li>
                  <li><a class="nav-link" href="#">Upcoming Declaration of Use</a></li>
                  <li><a class="nav-link" href="#">Upcoming Renewal</a></li>
                  <li><a class="nav-link" href="#">Payment Confirmation</a></li>
                  <li><a class="nav-link" href="#">Quote Follow-up</a></li>
                  <li><a class="nav-link" href="#">Foreign Associate Payment Reminder</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialDocuments" class="nav-link legal-submenu-title" aria-controls="financialDocuments" role="button" aria-expanded="false">Documents</a>
              <div class="collapse" id="financialDocuments">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">Trademark Fee Schedule</a></li>
                  <li><a class="nav-link" href="#">Patent Fee Schedule</a></li>
                  <li><a class="nav-link" href="#">Copyright Fee Schedule</a></li>
                  <li><a class="nav-link" href="#">Government Fees</a></li>
                  <li><a class="nav-link" href="#">Foreign Associate Rates</a></li>
                  <li><a class="nav-link" href="#">Quotes / Estimates</a></li>
                  <li><a class="nav-link" href="#">Financial Templates</a></li>
                  <li><a class="nav-link" href="#">Internal Financial Documents</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#financialExport" class="nav-link legal-submenu-title" aria-controls="financialExport" role="button" aria-expanded="false">Export</a>
              <div class="collapse" id="financialExport">
                <ul class="nav flex-column legal-submenu-items">
                  <li><a class="nav-link" href="#">PDF</a></li>
                  <li><a class="nav-link" href="#">Excel</a></li>
                  <li><a class="nav-link" href="#">CSV</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </li>
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

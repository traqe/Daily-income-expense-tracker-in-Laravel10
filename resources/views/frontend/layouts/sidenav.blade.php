<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
      <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <i class="fas fa-tachometer-alt menu-icon"></i>
              <span class="menu-title">Dashboard</span>
          </a>
      </li>

      <li class="nav-item">
          <a href="{{ route('categories') }}" class="nav-link {{ request()->routeIs('categories') ? 'active' : '' }}">
              <i class="fas fa-list-alt menu-icon"></i>
              <span class="menu-title">Categories</span>
          </a>
      </li>

      <li class="nav-item">
          <a href="{{ route('transactions') }}" class="nav-link {{ request()->routeIs('transactions') ? 'active' : '' }}">
              <i class="fas fa-exchange-alt menu-icon"></i>
              <span class="menu-title">Transactions</span>
          </a>
      </li>

      <li class="nav-item">
          <a href="{{ route('monthlyData') }}" class="nav-link {{ request()->routeIs('monthlyData') ? 'active' : '' }}">
              <i class="fas fa-calendar menu-icon"></i>
              <span class="menu-title">Monthly Data</span>
          </a>
      </li>

      <li class="nav-item">
          <a href="{{ route('dailyData') }}" class="nav-link {{ request()->routeIs('dailyData') ? 'active' : '' }}">
              <i class="fas fa-calendar menu-icon"></i>
              <span class="menu-title">Daily Data</span>
          </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('currencies.index') }}" class="nav-link {{ request()->routeIs('currencies.index') ? 'active' : '' }}">
            <i class="fas fa-dollar menu-icon"></i>
            <span class="menu-title">Currencies</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('pdf-report') }}" class="nav-link {{ request()->routeIs('pdf-report') ? 'active' : '' }}">
            <i class="fas fa-file-lines menu-icon"></i>
            <span class="menu-title">Reports</span>
        </a>
      </li>
  </ul>
</nav>

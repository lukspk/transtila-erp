@auth
  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon">
        {{-- Transtila --}}
        {{-- <img src="assets/images/logo-icon.png" class="logo-img" alt=""> --}}
      </div>
      <div class="logo-name flex-grow-1">
        <h5 class="mb-0">Transtila</h5>
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav">
      <!--navigation-->
      <ul class="metismenu" id="sidenav">

        <li>
          <a href="{{ route('dashboard')  }}">
            <div class="parent-icon"><i class="material-icons-outlined">home</i>
            </div>
            <div class="menu-title">Dashboard</div>
          </a>
        </li>
        <li>
          <a href="{{ route('users.index')  }}">
            <div class="parent-icon"><i class="material-icons-outlined">people</i>
            </div>
            <div class="menu-title">Usuários</div>
          </a>
        </li>
        <li>
          <a href="{{ route('entregas.index')  }}">
            <div class="parent-icon"><i class="material-icons-outlined">directions_car</i>
            </div>
            <div class="menu-title">Entregas</div>
          </a>
        </li>
        <li>
          <a href="{{ route('financeiro.index')  }}">
            <div class="parent-icon"><i class="material-icons-outlined">account_balance_wallet</i>
            </div>
            <div class="menu-title">Financeiro</div>
          </a>
        </li>
      </ul>
      <!--end navigation-->
    </div>
  </aside>
@endauth
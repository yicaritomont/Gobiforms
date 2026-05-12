<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img src="{{ url('assets/images/faces-clipart/pic-1.png') }}" alt="profile image">
          </div>
          <div class="text-wrapper">
            <p class="profile-name"></p>
            <div class="dropdown" data-display="static">
              <a href="#" class="nav-link d-flex user-switch-dropdown-toggler" id="UsersettingsDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted"> {{ Auth::user()->rolUsuario->name }}</small>
                <span class="status-indicator online"></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="UsersettingsDropdown">
                <a class="dropdown-item"> Cambiar Contraseña </a>
                <a class="dropdown-item" href="{{ url('/logout') }}">Cerrar sesión</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>
    @if(Auth::user()->rol_id == 1)
    <li class="nav-item {{ active_class(['/']) }}">
      <a class="nav-link" href="{{ url('/dashBoardAdmin') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ active_class(['basic-ui/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#basic-ui" aria-expanded="{{ is_active_route(['basic-ui/*']) }}" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-ghost"></i>
        <span class="menu-title">Parametrización</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['basic-ui/*']) }}" id="basic-ui">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['basic-ui/buttons']) }}">
            <a class="nav-link" href="{{ route('roles.index') }}">Roles de usuario</a>
          </li>
          <li class="nav-item {{ active_class(['basic-ui/typography']) }}">
            <a class="nav-link" href="{{ route('madurityLevel.index') }}">Niveles de madurez</a>
          </li>
          <li class="nav-item {{ active_class(['basic-ui/dropdowns']) }}">
            <a class="nav-link" href="{{ route('factor.index') }}">Factores</a>
          </li>
          <li class="nav-item {{ active_class(['basic-ui/dropdowns']) }}">
            <a class="nav-link" href="{{ route('dimension.index') }}">Dimensiones</a>
          </li>
          <li class="nav-item {{ active_class(['basic-ui/typography']) }}">
            <a class="nav-link" href="{{ route('dimensionScore.index') }}">Puntaje por dimensión</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ active_class(['user-pages/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#user-pages" aria-expanded="{{ is_active_route(['user-pages/*']) }}" aria-controls="user-pages">
        <i class="menu-icon mdi mdi-lock-outline"></i>
        <span class="menu-title">Gestión de formularios</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['user-pages/*']) }}" id="user-pages">
        <ul class="nav flex-column sub-menu">
         <li class="nav-item {{ active_class(['user-pages/login']) }}">
            <a class="nav-link"href="{{ route('form.index') }}">Formularios</a>
          </li>
          <li class="nav-item {{ active_class(['user-pages/login']) }}">
            <a class="nav-link" href="{{ route('question.index') }}">Preguntas</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ active_class(['user-pages/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="{{ is_active_route(['reports/*']) }}" aria-controls="reports">
      <i class="menu-icon mdi mdi-chart-line"></i>
        <span class="menu-title">Reportes</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse {{ show_class(['user-pages/*']) }}" id="reports">
        <ul class="nav flex-column sub-menu">
         <li class="nav-item {{ active_class(['user-pages/login']) }}">
            <a class="nav-link" href="{{ route('completedMedition')}}">Reporte mediciones Completas</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item {{ active_class(['user-pages/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="{{ is_active_route(['reports/*']) }}" aria-controls="reports">
      <i class="menu-icon mdi mdi-account"></i>
        <span class="menu-title">Usuarios</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['user-pages/*']) }}" id="users">
        <ul class="nav flex-column sub-menu">
         <li class="nav-item {{ active_class(['user-pages/login']) }}">
            <a class="nav-link" href="{{ route('users.index')}}">Listado de usuarios</a>
          </li>
        </ul>
      </div>
    </li>
    @endif

    @if(Auth::user()->rol_id != 1)
    <li class="nav-item {{ active_class(['/']) }}">
      <a class="nav-link" href="{{ url('/dashBoardUser') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard User</span>
      </a>
    </li>

    <li class="nav-item {{ active_class(['user-pages/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#user-pages" aria-expanded="{{ is_active_route(['user-pages/*']) }}" aria-controls="user-pages">
        <i class="menu-icon mdi mdi-lock-outline"></i>
        <span class="menu-title">Cuestionarios</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['user-pages/*']) }}" id="user-pages">
        <ul class="nav flex-column sub-menu">
         <li class="nav-item {{ active_class(['user-pages/login']) }}">
            <a class="nav-link" href="{{ url('/dashBoardUser') }}">Mis Cuestionarios</a>
          </li>
        </ul>
      </div>
    </li>
    @endif


    
  </ul>
</nav>
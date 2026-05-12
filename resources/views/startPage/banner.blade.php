
<nav class="navbar-menu-dark navbar navbar-dark bg-dark navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    
    <div class="container">
      <a class="navbar-brand brand-logo" href="{{ url('/') }}"><br>
      <h1>GobiForms</h1></a>
    </div>
    <ul class="navbar-nav navbar-nav-left header-links">
      @guest
        @if(Route::currentRouteName() != "login")
        <li class="nav-item d-none d-xl-flex">
            <a href="{{ url('login') }}" class="btn btn-dark btn-rounded btn-fw btn-index">Iniciar Sesión</a>
        </li>
        @endif
        <li class="nav-item d-none d-lg-flex"> &nbsp;&nbsp;&nbsp;</li>
        @if(Route::currentRouteName() != 'register')
        <li class="nav-item d-none d-lg-flex">
            <a href="{{ url('register') }}" class="btn btn-dark btn-rounded btn-fw btn-index">Registrarse</a>
        </li>
        @endif
      @else
        <li class="nav-item d-none d-lg-flex"> <a href="{{ url('home') }}" class="btn btn-dark btn-rounded btn-fw btn-index">Ir al sitio</a></li>
      @endguest
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu icon-menu"></span>
    </button>
  </div>
</nav>
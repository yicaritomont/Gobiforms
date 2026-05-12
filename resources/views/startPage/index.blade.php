
<!DOCTYPE html>
<html>
<head>
  <title>Gobi Forms</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/icon.ico') }}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
  <!-- plugin css -->
  {!! Html::style('assets/plugins/@mdi/font/css/materialdesignicons.min.css') !!}
  {!! Html::style('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') !!}
  <!-- end plugin css -->

  <!-- plugin css -->
  @stack('plugin-styles')
  <!-- end plugin css -->

  <!-- common css -->
  {!! Html::style('css/app.css') !!}
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}"  style="background-color:#EFEFF1') }}); background-size: cover;">

  <div class="container-scroller" id="app">
    <div class="container">
      @yield('content')
    </div>
  </div>
  <!-- base js -->
  {!! Html::script('js/app.js') !!}
  <!-- end base js -->

  <!-- plugin js -->
  @stack('plugin-scripts')
  <!-- end plugin js -->

  <br><br>
  @extends('startPage.banner')

  @stack('custom-scripts')
  <div class="container">
    <div class="content-wrapper">
      <div class="row">
        <div class="jumbotron jumbotron-fluid col-12">
          <div class="col-md-12 col-xl-12 grid-margin stretch-card">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="8"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block" width="95%" src="{{ asset('assets/images/carousel/banner_1.jpeg') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block" width="95%" src="{{ asset('assets/images/carousel/banner_2.jpeg') }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block" width="95%" src="{{ asset('assets/images/carousel/banner_3.jpeg') }}" alt="Third slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block" width="95%" src="{{ asset('assets/images/carousel/banner_4.jpeg') }}" alt="Third slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block" width="95%" src="{{ asset('assets/images/carousel/banner_5.jpeg') }}" alt="Third slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block" width="95%" src="{{ asset('assets/images/carousel/banner_6.jpeg') }}" alt="Third slide">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <a href="https://wa.me/573112223654?text=Hola%20tengo%20dudas%20sobre" target="_blank" class="btn-flotante">Contáctenos</a>
    </div>
  </div>
</body>
</html>
@extends('layouts.master')

@push('plugin-styles')
  <!-- {!! Html::style('/assets/plugins/plugin.css') !!} -->
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 text-right">
            <a href="{{ route('consolidatedReport') }}" class="btn btn-primary btn-lg font-weight-bold">
                <i class="mdi mdi-chart-areaspline"></i> Ver Consolidado General y Análisis Estadístico
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
            <div class="card-body">
                <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                <div class="float-left">
                    <i class="mdi mdi-account-multiple text-danger icon-lg"></i>
                </div>
                <div class="float-right">
                    <p class="mb-0 text-right">Total Usuarios registrados</p>
                    <div class="fluid-container">
                    <h3 class="font-weight-medium text-right mb-0">{{$totalAllUser}} usuarios</h3>
                    </div>
                </div>
                </div>
                <hr>
                <i class="mdi mdi-information mr-1" aria-hidden="true"></i> Tenemos {{$totalAllUser}} usuarios registrados, con los siguientes roles:
                <ul>
                    <li><b>Administradores:</b> {{$totalAdminRegistered}}</li>
                    <li><b>Usuarios:</b> {{$totalUserRegistered}}</li>
                </ul>
            </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
            <div class="card-body">
                <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                <div class="float-left">
                    <i class="mdi mdi-receipt text-warning icon-lg"></i>
                </div>
                <div class="float-right">
                    <p class="mb-0 text-right"> Cuestrionarios terminados</p>
                    <div class="fluid-container">
                    <h3 class="font-weight-medium text-right mb-0">{{$totalIntentsDone}}</h3>
                    </div>
                </div>
                </div>
                <hr>
                <i class="mdi mdi-information mr-1" aria-hidden="true"></i> Los Cuestrionariosque los usuarios han contestado en su totalidad.
            </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
            <div class="card-body">
                <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                <div class="float-left">
                    <i class="mdi mdi-poll-box text-success icon-lg"></i>
                </div>
                <div class="float-right">
                    <p class="mb-0 text-right"> Cuestionarios sin terminar</p>
                    <div class="fluid-container">
                    <h3 class="font-weight-medium text-right mb-0">{{$totalIntentsProgress}}</h3>
                    </div>
                </div>
                </div>
                <hr>
                <i class="mdi mdi-information mr-1" aria-hidden="true"></i> Los cuestionarios que los usuarios aún no terminan de completar.
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h2 class="card-title mb-0">Cuestionarios terminados Vs Incompletos</h2>
                    <div class="wrapper d-flex">
                        <div class="d-flex align-items-center mr-3">
                            <span class="dot-indicator bg-success"></span>
                            <p class="mb-0 ml-2 text-muted">Terminados</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="dot-indicator bg-primary"></span>
                            <p class="mb-0 ml-2 text-muted">Incompletos</p>
                        </div>
                    </div>
                    </div>
                    <div class="chart-container" >
                        <input type="hidden" id="dashboard-data-intents" value="{{ json_encode($dataGraphIntents) }}">
                        <canvas id="dashboard-area-chart" height="80" ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-5 d-flex align-items-center">
                        <input type="hidden" id="info-user-admin" value="{{$totalAdminRegistered}}">
                        <input type="hidden" id="info-user-general" value="{{$totalUserRegistered}}">
                        <canvas id="UsersDoughnutChart" class="400x160 mb-4 mb-md-0" height="200"></canvas>
                    </div>
                    <div class="col-md-7">
                        <h4 class="card-title font-weight-medium mb-0 d-none d-md-block">USUARIOS</h4>
                        <div class="wrapper mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                            <p class="mb-0 font-weight-medium">{{$totalAdminRegistered}}</p>
                            <small class="text-muted ml-2">Usuarios Administradores</small>
                            </div>
                            <p class="mb-0 font-weight-medium">{{round(($totalAdminRegistered*100)/$totalAllUser)}}%</p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{round(($totalAdminRegistered*100)/$totalAllUser)}}%" aria-valuenow="{{round(($totalAdminRegistered*100)/$totalAllUser)}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                        <div class="wrapper mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="d-flex align-items-center">
                            <p class="mb-0 font-weight-medium">{{$totalUserRegistered}}</p>
                            <small class="text-muted ml-2">Generales</small>
                            </div>
                            <p class="mb-0 font-weight-medium">{{round(($totalUserRegistered*100)/$totalAllUser)}}%</p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{round(($totalUserRegistered*100)/$totalAllUser)}}%" aria-valuenow="{{round(($totalUserRegistered*100)/$totalAllUser)}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="row">
                <div class="col-md-2">
                    <h4 class="card-title font-weight-medium mb-3">Zonas registradas</h4>
                </div>
                <div class="col-md-10 d-flex align-items-end mt-4 mt-md-0">
                    <input type="hidden" id="info-user-organization-size" value="{{json_encode($usersCountByOrganizationSize)}}">
                    <canvas id="conversionBarChart" height="150"></canvas>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
  {!! Html::script('/assets/plugins/chartjs/chart.min.js') !!}
  {!! Html::script('/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}
@endpush

@push('custom-scripts')
  {!! Html::script('/assets/js/dashboard.js') !!}
@endpush
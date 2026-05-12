@extends('layouts.master')
@section('content')
@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
<!--begin::Card-->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card card-custom gutter-b">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">
                Mediciones Terminadas 100% 
                <span class="d-block text-muted pt-2 font-size-sm">Este listado le permite visualizar los usuarios que han completado a totalidad la medición de madurez.</span>
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('consolidatedReport') }}" class="btn btn-primary font-weight-bolder">
                <i class="la la-chart-bar"></i>Ver Consolidado General
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('completedMedition') }}" method="GET" class="row g-3 align-items-end mb-5">
            <div class="col-md-4">
                <label for="subregion" class="form-label">Filtrar por Subregión</label>
                <select name="subregion" id="subregion" class="form-select">
                    <option value="">Todas las subregiones</option>
                    <option value="SNOR" {{ $subregion == 'SNOR' ? 'selected' : '' }}>Subregión Norte</option>
                    <option value="SNEV" {{ $subregion == 'SNEV' ? 'selected' : '' }}>Subregión Nevados</option>
                    <option value="SCEN" {{ $subregion == 'SCEN' ? 'selected' : '' }}>Subregión Ibagué (centro)</option>
                    <option value="SORI" {{ $subregion == 'SORI' ? 'selected' : '' }}>Subregión Oriente</option>
                    <option value="SURO" {{ $subregion == 'SURO' ? 'selected' : '' }}>Subregión Sur-Oriente</option>
                    <option value="SSUR" {{ $subregion == 'SSUR' ? 'selected' : '' }}>Subregión Sur</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
            </div>
        </form>

        <!--begin: Datatable-->
        <table class="table table-bordered table-checkable" id="kt_datatable">
            <thead>
                <tr>                        
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Empresa</th>
                    <th>#Intento</th>
                    <th>Contacto</th>
                    <th>Fecha Realización</th>
                    <th>Visualizar</th>
                </tr>
                </thead>
                    <tbody>
                        @foreach($attempts as $attemp)
                        <tr>
                            <td>{{$attemp->id}}</td>
                            <td>{{$attemp->user->name}} {{$attemp->user->last_name}}</td>
                            <td>{{$attemp->user->name_organization}}</td>
                            <td>{{$attemp->attemp_number}}</td>
                            <td>{{$attemp->user->phone_number}} / {{$attemp->user->email}}</td>
                            <td>{{$attemp->created_at}}</td>
                            <td>
                                <a href="{{route('showResume', $attemp->id)}}" class="btn btn-dark" target="_blank">Ver Medición</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        <!--end: Datatable-->
    </div>
</div>
<!--end::Card-->


@endsection
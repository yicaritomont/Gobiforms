@extends('layouts.paint')
@section('content')
@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
<!--begin::Card-->
<div class="card card-custom gutter-b">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><a  href="{{ url('/') }}" style=" width: 53% !important;
  height: 100% !important;
  border-radius: 0 !important;
}" class="navbar-brand brand-logo"><img src="{{ url('/') }}" alt="logo"></a> </th>
                            <th><h3 class="card-label"> Resumen General</h3></th>
                        </tr>
                       
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="jumbotron letter_jumbotrom">
            @foreach($result as $key => $attemp)
                @php
                    $dataIndividual =  json_encode($attemp['DimensionsGraph']);
                @endphp
                <h1 class="display-4"><b>Resultados Intento #{{$key}}</b></h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Persona: </th>
                                <th>Organización: </th>
                                <th>Tamaño Organización: </th>
                                <th>Correo Electrónico: </th>
                                <th>Teléfono de Contacto: </th>
                                <th>Fecha Registro:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$attemp['Info']->name}} {{$attemp['Info']->last_name}}</td>
                                <td>{{$attemp['Info']->name_organization}} </td>
                                <td>{{$attemp['Info']->size_organization}} </td>
                                <td>{{$attemp['Info']->email}} </td>
                                <td>{{$attemp['Info']->phone_number}} </td>
                                <td>{{$attemp['Attemp']->created_at}} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="lead"></p>
                <hr class="my-4">                
                <div class="col-md-12">
                    <div class="card cardGray">
                        <div class="card-body">
                            <h2><b>¡Felicitaciones!,tu nivel es {{$attemp['Level']->visible_name}}</b></h2>
                            <div class="media">
                                <i class="mdi mdi-white-balance-sunny icon-md text-info d-flex align-self-start mr-3"></i> 
                                <div class="media-body">
                                    <p class="card-text">{!!$attemp['Recomendations']->congrats !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card cardGray">
                        <div class="card-body">
                            <h2><b>¿Qué significa {{$attemp['Level']->visible_name}} ? </b></h2>
                            <p class="card-text"> >{{$attemp['Level']->description}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card cardGray">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p> Este resultado se obtuvo de la sumatoria por cada dimensión, a continuación conoceras tus resultados individales : </p>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Dimensión</th>
                                                    <th>Puntaje Obtenido</th>
                                                    <th>Puntaje Esperado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($attemp['DimensionScore'] as $key => $byDimension)
                                                @php
                                                    $percentage = ($byDimension->total_points / $byDimension->max_range) * 100;

                                                    if ($percentage >= 50) {
                                                        $colorClass = 'text-success'; // Verde
                                                    } elseif ($percentage >= 30) {
                                                        $colorClass = 'text-warning'; // Amarillo
                                                    } else {
                                                        $colorClass = 'text-danger'; // Rojo
                                                    }
                                                @endphp
                                                    <tr>
                                                        <td>{{$byDimension->name}}</td>
                                                        <td class="{{ $colorClass }}"><b>{{$byDimension->total_points}}</b></td>
                                                        <td class="text-success"><b>{{$byDimension->max_range}}<b></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="col-8">
                                            <input type="hidden" id="result_dimension" value="{{json_encode($dimensions)}}">
                                            <input type="hidden" id="result_dimension_dataset_individual" value="{{json_encode($attemp['DimensionsGraph'])}}">
                                            <canvas id="myChartModal" class="chart-50"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card cardGray">
                        <div class="card-body">
                            <p class="card-text"> {!!$attemp['Recomendations']->remark !!}</p>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card cardGray">
                        <div class="card-body">
                            <h1><b>¿Qué te recomendamos?</b></h1> 
                            <div class="media">
                                <div class="media-body">
                                    <p class="card-text">{!!$attemp['Recomendations']->recomendations !!}</p>
                                </div>
                                <i class="mdi mdi-human-greeting icon-md text-info d-flex align-self-start mr-3"></i> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card cardGray">
                        <div class="card-body">
                            <h1><b>¡No te detengas!</b></h1>
                            <p class="card-description">{!!$attemp['Recomendations']->best_practices !!}</p>
                            <p class="card-description">{!!$attemp['Recomendations']->conclusions !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            <button onclick="window.print()" class="btn btn-primary mt-3">Imprimir</button>
            </div>
        </div>
    </div>
</div>
<!--end::Card-->

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.onload = function() {
         
    const ctxModal = document.getElementById('myChartModal');
    var informationchart = JSON.parse($("#result_dimension").val());
    var result_dimension_dataset_individual =  JSON.parse($("#result_dimension_dataset_individual").val());
    const dataIndividual = {
        labels: informationchart,
        datasets: result_dimension_dataset_individual
    };
    new Chart(ctxModal, {
        type: 'radar',
        data: dataIndividual,
        options: {
            elements: {
                line: {
                    borderWidth: 3
                }
            }
        }
    });

    
}
</script>

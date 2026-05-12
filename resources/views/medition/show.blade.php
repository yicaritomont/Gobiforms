@extends('layouts.master')

@section('content')
@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white">
                    <h3 class="card-title mb-0">Mis Resultados de Madurez Digital</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Aquí puedes ver el resumen de tus intentos y el detalle de tus respuestas.</p>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th># Intento</th> 
                                    <th>Progreso / Puntaje</th> 
                                    <th>Nivel Alcanzado</th> 
                                    <th class="text-center">Acciones</th> 
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach($result as $key => $attemp)
                                <tr>
                                    <td><strong>Intento #{{ $attemp['attempt'] }}</strong></td>
                                    <td style="width: 30%;">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                                 role="progressbar" 
                                                 style="width: {{$attemp['TotalScore']}}%;" 
                                                 aria-valuenow="{{$attemp['TotalScore']}}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{$attemp['TotalScore']}}%
                                            </div>
                                        </div>
                                    </td> 
                                    <td>
                                        <span class="badge bg-primary px-3 py-2" style="font-size: 0.9rem;">
                                            {{$attemp['Level']->visible_name}}
                                        </span>
                                    </td> 
                                    <td class="text-center"> 
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="collapse" data-bs-target="#Detail{{$attemp['attempt']}}">
                                            <i class="mdi mdi-eye"></i> Ver Detalle de Respuestas
                                        </button>
                                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#ModalAttemp{{$attemp['attempt']}}">
                                            <i class="mdi mdi-chart-bar"></i> Ver Análisis Gráfico
                                        </button>
                                    </td> 
                                </tr>
                                <tr>
                                    <td colspan="4" class="p-0 border-0">
                                        <div class="collapse" id="Detail{{$attemp['attempt']}}">
                                            <div class="card card-body bg-light m-3 shadow-sm">
                                                <h5 class="text-primary border-bottom pb-2">Desglose de Preguntas - Intento #{{ $attemp['attempt'] }}</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered bg-white table-striped">
                                                        <thead class="bg-secondary text-white">
                                                            <tr>
                                                                <th style="width: 60%;">Pregunta</th>
                                                                <th>Tu Respuesta</th>
                                                                <th class="text-center">Puntos</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($attemp['DetailedAnswers'] as $detail)
                                                            <tr>
                                                                <td>{{ $detail->question->statement }}</td>
                                                                <td>{{ $detail->anwser->option }}</td>
                                                                <td class="text-center">
                                                                    <span class="badge bg-success">{{ $detail->anwser->points }}</span>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal para Gráficos -->
                                <div class="modal fade" id="ModalAttemp{{$attemp['attempt']}}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark text-white">
                                                <h5 class="modal-title">Análisis de Madurez - Intento #{{$attemp['attempt']}}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="font-weight-bold">Interpretación del Nivel: {{$attemp['Level']->visible_name}}</h5>
                                                        <p class="text-justify">{{$attemp['Level']->description}}</p>
                                                        
                                                        <h6 class="mt-4 font-weight-bold">Puntaje por Dimensiones:</h6>
                                                        <table class="table table-sm table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Dimensión</th>
                                                                    <th class="text-center">Puntos</th>
                                                                    <th class="text-center">Esperado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($attemp['DimensionScore'] as $byDimension)
                                                                <tr>
                                                                    <td>{{$byDimension->name}}</td>
                                                                    <td class="text-center font-weight-bold">{{$byDimension->total_points}}</td>
                                                                    <td class="text-center text-muted">{{$byDimension->max_range}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <canvas id="myChartModal_{{$attemp['attempt']}}"></canvas>
                                                        <input type="hidden" id="result_dimension_dataset_individual_{{$attemp['attempt']}}" value="{{ json_encode($attemp['DimensionsGraph']) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparativa General de Intentos -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light"><strong>Evolución por Dimensión (Todos los intentos)</strong></div>
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                    <input type="hidden" id="result_dimension" value="{{json_encode($dimensions)}}">
                    <input type="hidden" id="result_dimension_dataset" value="{{json_encode($dataGraph)}}">
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light"><strong>Niveles de Madurez Alcanzados</strong></div>
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
                    <input type="hidden" id="result_levels" value="{{json_encode($result_levels)}}">
                    <input type="hidden" id="result_dimension_level" value="{{json_encode($dataLevelGraph)}}">
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
window.addEventListener('load', function() {
    const informationchart = JSON.parse(document.getElementById('result_dimension').value);
    const informationLevels = JSON.parse(document.getElementById('result_levels').value);
    const informationchartdataset = JSON.parse(document.getElementById('result_dimension_dataset').value);
    const result_dimension_level = JSON.parse(document.getElementById('result_dimension_level').value);
    
    // Gráficos de los Modales
    const modalCharts = document.querySelectorAll('[id^="myChartModal_"]');
    modalCharts.forEach(element => {
        const id = element.id.replace('myChartModal_', '');
        const dataset = JSON.parse(document.getElementById('result_dimension_dataset_individual_' + id).value);
        
        new Chart(element, {
            type: 'radar',
            data: {
                labels: informationchart,
                datasets: dataset
            },
            options: {
                scales: { r: { suggestedMin: 0 } }
            }
        });
    });

    // Gráfico General 1
    new Chart(document.getElementById('myChart'), {
        type: 'radar',
        data: {
            labels: informationchart,
            datasets: informationchartdataset
        },
        options: {
            scales: { r: { suggestedMin: 0 } }
        }
    });

    // Gráfico General 2
    new Chart(document.getElementById('myChart2'), {
        type: 'radar',
        data: {
            labels: informationLevels,
            datasets: result_dimension_level
        },
        options: {
            scales: { r: { suggestedMin: 0 } }
        }
    });
});
</script>
@endpush
@endsection

@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <!-- FILTROS -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Panel de Control Consolidado y Cubo de Información</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('consolidatedReport') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="subregion" class="form-label font-weight-bold">Subregión</label>
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
                        <div class="col-md-4">
                            <label for="search" class="form-label font-weight-bold">Buscar Usuario (Nombre o Documento)</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Ej: 123456 o Juan Perez" value="{{ $search }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('consolidatedReport') }}" class="btn btn-secondary w-100">Limpiar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIS Y MADUREZ -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center mb-4 border-primary shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Muestra Filtrada</h5>
                    <h2 class="display-4 text-primary">{{ $totalAttempts }}</h2>
                    <p class="text-muted">Formularios seleccionados</p>
                    <hr>
                    <small>Total Global en Sistema: {{ $totalGlobalAttempts }}</small>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm h-100">
                <div class="card-header font-weight-bold bg-light">Ranking Madurez por Subregión</div>
                <div class="card-body">
                    <canvas id="regionalBenchmarkChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-4 shadow-sm h-100">
                <div class="card-header font-weight-bold bg-light">Distribución de Niveles (Selección Actual)</div>
                <div class="card-body">
                    <canvas id="maturityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- RADAR COMPARATIVO -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm border-info">
                <div class="card-header bg-info text-white font-weight-bold text-center">Análisis Comparativo por Dimensión: Selección vs Global</div>
                <div class="card-body">
                    <canvas id="dimensionChart" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TOTALIZADO SEGREGADO POR PREGUNTA -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Totalizado por Pregunta con Segregación Regional</h4>
                    <span class="badge badge-light text-dark">Gráficos de Frecuencia Visual</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($questionBreakdown as $q_id => $data)
                        <div class="col-md-12 mb-5">
                            <div class="p-3 border rounded bg-light border-left-success" style="border-left-width: 5px !important;">
                                <h6 class="font-weight-bold border-bottom pb-2">Pregunta {{ $loop->iteration }}: {{ $data['statement'] }}</h6>
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <div class="row">
                                            @foreach($data['options'] as $optionText => $optionData)
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100 border shadow-none bg-white">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-dark text-white text-wrap" style="max-width: 70%;">{{ $optionText }}</span>
                                                            <span class="badge bg-primary">Total: {{ $optionData['total'] }}</span>
                                                        </div>
                                                        <ul class="list-group list-group-flush" style="font-size: 0.75rem;">
                                                            @foreach($optionData['subregions'] as $regCode => $count)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center p-1 border-0">
                                                                <span>{{ App\Http\Helpers\Equivalencias::whichZone($regCode) }}</span>
                                                                <span class="badge badge-pill badge-light border">{{ $count }}</span>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card border shadow-sm">
                                            <div class="card-body p-2">
                                                <canvas id="qChart_{{ $q_id }}" height="180"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted">No hay datos disponibles para mostrar la segregación.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CUBO DE INFORMACIÓN 1X1 -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm border-dark">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Cubo de Información: Detalle de Respuestas 1 a 1</span>
                    <span class="badge badge-light text-dark">Mostrando {{ $detailedResponses->count() }} registros</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Documento</th>
                                    <th>Subregión</th>
                                    <th>Pregunta</th>
                                    <th>Respuesta</th>
                                    <th class="text-center">Puntos</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($detailedResponses as $response)
                                <tr>
                                    <td><strong>{{ $response->user->name }} {{ $response->user->last_name }}</strong></td>
                                    <td>{{ $response->user->document }}</td>
                                    <td>
                                        <span class="badge bg-info text-white">
                                            {{ App\Http\Helpers\Equivalencias::whichZone($response->user->size_organization) }}
                                        </span>
                                    </td>
                                    <td><small>{{ $response->question->statement }}</small></td>
                                    <td>{{ $response->anwser->option }}</td>
                                    <td class="text-center"><span class="badge bg-success">{{ $response->anwser->points }}</span></td>
                                    <td><small>{{ $response->created_at->format('d/m/Y H:i') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No se encontraron respuestas con los filtros seleccionados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    {{ $detailedResponses->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
    // 1. Regional Benchmark Chart
    const regCtx = document.getElementById('regionalBenchmarkChart').getContext('2d');
    new Chart(regCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($regionalLabels) !!},
            datasets: [{
                label: 'Puntaje Promedio',
                data: {!! json_encode($regionalData) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: { indexAxis: 'y', scales: { x: { beginAtZero: true } } }
    });

    // 2. Maturity Level Chart
    const maturityCtx = document.getElementById('maturityChart').getContext('2d');
    new Chart(maturityCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(collect($levelCounts)->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode(collect($levelCounts)->pluck('count')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 
                    'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ]
            }]
        }
    });

    // 3. Dimension Radar Chart
    const dimensionCtx = document.getElementById('dimensionChart').getContext('2d');
    new Chart(dimensionCtx, {
        type: 'radar',
        data: {
            labels: {!! json_encode(collect($dimensionStats)->pluck('name')) !!},
            datasets: [
                {
                    label: 'Selección Actual',
                    data: {!! json_encode(collect($dimensionStats)->pluck('filtered_avg')) !!},
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgb(255, 99, 132)',
                    zIndex: 10
                },
                {
                    label: 'Promedio Global',
                    data: {!! json_encode(collect($dimensionStats)->pluck('global_avg')) !!},
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderDash: [5, 5],
                    zIndex: 5
                }
            ]
        },
        options: { scales: { r: { suggestedMin: 0 } } }
    });

    // 4. Question Breakdown Charts
    @foreach($questionBreakdown as $q_id => $data)
    (function() {
        const ctx = document.getElementById('qChart_{{ $q_id }}').getContext('2d');
        const options = {!! json_encode(array_keys($data['options'])) !!};
        const datasets = [];
        
        // Colores para las subregiones
        const regColors = {
            'SNOR': 'rgba(255, 99, 132, 0.7)',
            'SNEV': 'rgba(54, 162, 235, 0.7)',
            'SCEN': 'rgba(255, 206, 86, 0.7)',
            'SORI': 'rgba(75, 192, 192, 0.7)',
            'SURO': 'rgba(153, 102, 255, 0.7)',
            'SSUR': 'rgba(255, 159, 64, 0.7)'
        };
        const regNames = {
            'SNOR': 'Norte', 'SNEV': 'Nevados', 'SCEN': 'Ibagué', 
            'SORI': 'Oriente', 'SURO': 'Sur-Oriente', 'SSUR': 'Sur'
        };

        ['SNOR', 'SNEV', 'SCEN', 'SORI', 'SURO', 'SSUR'].forEach(regCode => {
            const data = [];
            options.forEach(opt => {
                const qData = {!! json_encode($data['options']) !!};
                data.push(qData[opt]['subregions'][regCode] || 0);
            });
            
            datasets.push({
                label: regNames[regCode],
                data: data,
                backgroundColor: regColors[regCode]
            });
        });

        new Chart(ctx, {
            type: 'bar',
            data: { labels: options, datasets: datasets },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false }, title: { display: true, text: 'Distribución por Región' } },
                scales: { x: { stacked: true }, y: { stacked: true } }
            }
        });
    })();
    @endforeach
</script>
@endpush
@endsection

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
                DSECRIPCION DEL FORMULARIO / CUESTIONARIO
            </h3>
            <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa saepe ut doloribus illo placeat dignissimos non aut doloremque provident possimus minus praesentium fuga rem, iusto voluptatibus quae eum sint repudiandae?.
            </p>
        </div>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ route('startForm.store') }}" >
         @csrf
        <!--<pre>{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>-->
        <div class="accordion" id="accordionExample">
            @php
                $antes = "";
            @endphp
            @foreach ($result as $key => $valor)
                @if ($antes != $valor['factor'])
                <h3 class="card card-revenue">{{$valor['factor']}}</h3>
                @endif
                <div class="accordion-item">
                    <h4 class="accordion-header" id="heading{{$key}}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                        <h5><b>{{$valor['dimension']}}</b></h5> &nbsp;&nbsp;&nbsp;
                        @if(isset($valor['forms']) && isset($valor['forms']['questions']) && !empty($valor['forms']['questions']))
                            <h5 class="text-info" id="counter_{{ $valor['dimension_id'] }}"> {{$valor['answerAnswered']}} /  {{count($valor['forms']['questions'])}}</h5>                                                    
                        @else
                            <span class="badge badge-dark">Sin Preguntas</span>
                        @endif
                        </button>
                    </h4>
                    <div id="collapse{{$key}}" class="accordion-collapse collapse " aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                        <div class="alert alert-dark text-center" role="alert">
                            <b>{!!$valor['description']!!}</b>
                        </div>
                        @if(isset($valor['forms']) && !empty($valor['forms']))
                            <div class="alert alert-secondary text-center" role="alert">
                                <i>{{$valor['forms']['form_description']}}</i>
                             </div>
                        @endif
                        <div class="accordion-body">
                            @if(isset($valor['forms']) && isset($valor['forms']['questions']) && !empty($valor['forms']['questions']))
                                <div class="row">
                                    
                                    @foreach ($valor['forms']['questions'] as $idQuestion => $valueQuestion)
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card">
                                            <div class="card card-statistics">
                                                <div class="card-body">
                                                    <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                                                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="{{$valueQuestion['helpText']}}">
                                                            <h3 class="card-title mb-1" style="text-transform: none;">{{$valueQuestion['question']}}</h3>
                                                            <i class="mdi mdi-help-circle"></i>
                                                        </button>
                                                    </div>
                                                
                                                    <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
                                                        @if(isset($valueQuestion['answers']) && !empty($valueQuestion['answers']))
                                                            <ul style="list-style-type:none">
                                                                @foreach ($valueQuestion['answers'] as $idAnswer => $valueAnswer)
                                                                    <li> 
                                                                        <input type="radio" name="answers_{{$valueQuestion['question_id']}}[]" 
                                                                        id="answers{{$valor['dimension_id']}}" 
                                                                        value="{{$valor['dimension_id']}}_{{$valueQuestion['question_id']}}_{{$valueAnswer['answer_id']}}_{{$valueAnswer['points']}}" 
                                                                        onclick="countAnswer({{ $valueQuestion['question_id'] }}, {{ $valor['dimension_id'] }}, {{count($valor['forms']['questions'])}})"
                                                                        @if($valueAnswer['answer_id'] == $valueAnswer['selected']) checked @endif  
                                                                        > {{$valueAnswer['option']}}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                        <div class="alert alert-warning" role="alert">
                                                            <h4 class="alert-heading">¡Lo sentimos!</h4>
                                                            <p>Esta pregunta aún no tiene definidas unas respuestas, por lo tanto no podrá ser evaluada, sin embargo continúa con las demás preguntas, una vez se actualice las respuestas para esta pregrunta podrás diligenciar el cuestionario.</p>
                                                            <hr>
                                                            <p class="mb-0">¡Gracias por tu participación! .</p>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">¡Lo sentimos!</h4>
                                    <p>Esta dimensión aún no tiene definido un formulario, por lo tanto no podrá ser evaluada, sin embargo continúa con las demás dimensiones una vez se actualice las preguntas para esta dimensión podrás diligenciar el cuestionario.</p>
                                    <hr>
                                    <p class="mb-0">¡Gracias por tu participación! .</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @php
                $antes = $valor['factor'];
                @endphp
            @endforeach
        </div>
        <div class="card-footer">
            {{ Form::submit('Registrar', ['class' => 'btn btn-dark btn-rounded btn-fw btn-index']) }}	
            
        </div>
    </form>
    </div>
</div>
<!--end::Card-->


@endsection
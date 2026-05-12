
@section('content')
<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" @if(!isset($isAdmin) || !$isAdmin)
        style="background-image: url({{ url('assets/images/auth/register_1.jpg') }}); background-size: cover;"
    @endif>
  <div class="row w-100">
    <div class="col-lg-4 mx-auto">
       
        <br><br>
        @error('name')
            <span class="alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span><br>
        @enderror
        @error('email')
            <span class="alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span><br>
        @enderror
        @error('password')
            <span class="alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span><br>
        @enderror
        <div class="auto-form-wrapper">
            @if(!isset($isAdmin) || !$isAdmin)
            <form  method="POST" action="{{ route('register') }}">
            <h2 class="text-center mb-4">Regístrese</h2>
                <blockquote class="blockquote">
                    <p class="mb-0">Al registrarse acepta el tratamiento de datos personales.</p>
                </blockquote>
            @else
                <form  method="POST" action="{{ route('users.store') }}">
                <h2 class="text-center mb-4">Registrar Nuevo Usuario</h2>
            @endif
            @csrf
            @if(isset($isAdmin))
                <input type="text" name="isAdmin" id="isAdmin" value="1">
            @endif
            <div class="form-group">
                <div class="input-group">
                <input type="text" name="name" id="name" class="form-control" placeholder="Nombres">
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Apellidos">
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                <input type="text" name="document" id="document" class="form-control" placeholder="Número Documento">
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                <input type="text" name="email" id="email" class="form-control" placeholder="Correo Electrónico">
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Número de Teléfono">
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                <select class="form-control" name="size_organization" id="size_organization">
                    <option>SubRegión</option>
                    <option value="SNOR">Subregión Norte</option>
                    <option value="SNEV">Subregión Nevados</option>
                    <option value="SCEN">Subregión Ibagué (centro)</option>
                    <option value="SORI">Subregión Oriente</option>
                    <option value="SURO">Subregión Sur-Oriente</option>
                    <option value="SUR">Subregión Sur</option>
                </select>
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                <input type="text" name="name_organization" id="name_organization" class="form-control" placeholder="Nombre de la organización">
                <div class="input-group-append">
                    <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                </div>
                </div>
            </div>
            @if(!isset($isAdmin) || !$isAdmin)
            <div class="form-group d-flex justify-content-center">
                <div class="form-check form-check-flat mt-0">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" checked> Acepto los <b><a href="#" classs="text-primary" data-toggle="modal" data-target="#exampleModal">términos y condiciones</a></b> </label>
                </div>
            </div>
            @endif
            <div class="form-group">
                <button class="btn btn-dark btn-rounded submit-btn btn-block">REGISTRAR</button>
            </div>
            @if(!isset($isAdmin) || !$isAdmin)
            <div class="text-block text-center my-3">
                <span class="text-small font-weight-semibold">¿Ya tienes una cuenta ?</span>
                <a href="{{ url('login') }}" class="text-black text-small">Ingresa aquí</a>
            </div>
            @endif
            </form>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 50% !important;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Términos y Condiciones</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @include('auth.termsAndConditions')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection
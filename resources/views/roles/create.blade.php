@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Crear') }}</div>

                <div class="card-body">
                  <form method="POST" action="{{ route('roles.store') }}" aria-label="{{ __('roles') }}">
                    @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre del Rol: ') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $permission->name ?? old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" permission="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('URL Amigable: ') }}</label>

                            <div class="col-md-6">
                                <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ $permission->slug ?? old('slug') }}" required autofocus>

                                @if ($errors->has('slug'))
                                    <span class="invalid-feedback" permission="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripción: ') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="textarea" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ $permission->description ?? old('description') }}" required autofocus>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback" permission="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <center><h3>Lista de Permisos<br><hr style="height: 2px; width: 80%; background-color:#F1EAEA;" ></hr></h3>

                        <div class="form-group">
                          <label >{{ Form::radio('special', 'all-access') }} Acceso total</label>
                          <label >{{ Form::radio('special', 'no-access') }} Ningun acceso</label>
                        </div></center>
                        <h3>Docente<br><hr style="height: 2px; width: 50%; background-color:#F1EAEA; position:absolute;" ></hr></h3><br>
                        @foreach ($permissions as $permission)

                              <label>
                                {{ Form::checkbox('permissions[]', $permission->id, null) }}
                                {{ $permission->name }}
                                <em>({{ $permission->description ?: 'Sin descripcion' }})</em>
                              </label>

                         
                        @endforeach
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

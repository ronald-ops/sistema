@extends('adminlte::page')

@section('title', 'Registrar Empleado')

@section('content_header')
    <h1>Registrar Empleado</h1>
@stop

@section('content')
    <form action="{{ route('empleados.store') }}" method="POST" class="employee-form">
        @csrf

        <div class="card">
            <div class="card-body">

                <!-- Información Personal -->
                <h5>Información Personal</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required class="form-control" placeholder="Ingrese el nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" required class="form-control" placeholder="Ingrese el apellido">
                        </div>
                    </div>
                </div>

                <!-- Cargo y Departamento -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" id="cargo" name="cargo" required class="form-control" placeholder="Ingrese el cargo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="departamento_id">Departamento</label>
                            <select id="departamento_id" name="departamento_id" required class="form-control">
                                @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Biométrico ID -->
                <div class="form-group">
                    <label for="biometrico_lapaz">Biométrico ID</label>
                    <input type="text" id="biometrico_lapaz" name="biometrico_lapaz" required class="form-control" placeholder="Ingrese el ID biométrico">
                </div>

                <!-- Botón para enviar el formulario -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Registrar Empleado</button>
                </div>
            </div>
        </div>
    </form>
@stop

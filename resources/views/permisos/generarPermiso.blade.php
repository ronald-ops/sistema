@extends('adminlte::page')
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h1 class="card-title">Registrar Permiso</h1>
        </div>
        <div class="card-body">
            <!-- Formulario para registrar un permiso -->
            <form action="{{ route('permisos.store') }}" method="POST">
                @csrf <!-- Protección contra ataques CSRF -->

                <!-- Selección de empleado -->
                <div class="form-group mb-4">
                    <label for="empleado_id" class="form-label">Empleado:</label>
                    <select id="empleado_id" name="empleado_id" class="form-control select2" required>
                        <option value="" disabled selected>Seleccione un empleado</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->apellido }}</option>
                        @endforeach
                    </select>
                    @error('empleado_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fecha de entrega -->
                <div class="form-group mb-4">
                    <label for="fecha_entrega" class="form-label">Fecha de Entrega:</label>
                    <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" value="{{ old('fecha_entrega') }}" required>
                    @error('fecha_entrega')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Motivo del permiso -->
                <div class="form-group mb-4">
                    <label for="motivo" class="form-label">Motivo:</label>
                    <textarea id="motivo" name="motivo" class="form-control" rows="3" required>{{ old('motivo') }}</textarea>
                    @error('motivo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tipo de permiso -->
                <div class="form-group mb-4">
                    <label for="tipo_permiso" class="form-label">Tipo de Permiso:</label>
                    <select id="tipo_permiso" name="tipo_permiso" class="form-control select2" required>
                        <option value="" disabled selected>Seleccione el tipo de permiso</option>
                        <option value="docente" {{ old('tipo_permiso') == 'docente' ? 'selected' : '' }}>Docente</option>
                        <option value="administrativo" {{ old('tipo_permiso') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                    </select>
                    @error('tipo_permiso')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Materia (solo para docentes) -->
                <div class="form-group mb-4" id="materia_field" style="display:none;">
                    <label for="materia" class="form-label">Materia:</label>
                    <input type="text" id="materia" name="materia" class="form-control" value="{{ old('materia') }}">
                    @error('materia')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campos para administrativos -->
                <div class="form-group mb-4" id="cargo_field" style="display:none;">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" id="cargo" name="cargo" class="form-control" value="{{ old('cargo') }}">
                    @error('cargo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4" id="oficina_field" style="display:none;">
                    <label for="oficina" class="form-label">Oficina:</label>
                    <input type="text" id="oficina" name="oficina" class="form-control" value="{{ old('oficina') }}">
                    @error('oficina')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hora de salida y llegada (para ambos tipos de empleados) -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="hora_inicio_permiso" class="form-label">Hora de Salida:</label>
                        <input type="time" id="hora_inicio_permiso" name="hora_inicio_permiso" class="form-control" value="{{ old('hora_inicio_permiso') }}" required>
                        @error('hora_inicio_permiso')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="hora_fin_permiso" class="form-label">Hora de Llegada:</label>
                        <input type="time" id="hora_fin_permiso" name="hora_fin_permiso" class="form-control" value="{{ old('hora_fin_permiso') }}" required>
                        @error('hora_fin_permiso')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Reemplazo -->
                <div class="form-group mb-4" id="reemplazo_field" style="display:none;">
                    <label for="reemplazo" class="form-label">Reemplazo:</label>
                    <select id="reemplazo" name="reemplazo" class="form-control select2">
                        <option value="0" {{ old('reemplazo') == '0' ? 'selected' : '' }}>Sin Reemplazo</option>
                        <option value="1" {{ old('reemplazo') == '1' ? 'selected' : '' }}>Con Reemplazo</option>
                    </select>
                    @error('reemplazo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Estado (Con Boleta o Sin Boleta) -->
                <div class="form-group mb-4">
                    <label for="estado" class="form-label">Estado:</label>
                    <select id="estado" name="estado" class="form-control select2" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="con_boleta" {{ old('estado') == 'con_boleta' ? 'selected' : '' }}>Con Boleta</option>
                        <option value="sin_boleta" {{ old('estado') == 'sin_boleta' ? 'selected' : '' }}>Sin Boleta</option>
                    </select>
                    @error('estado')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Otros motivos -->
                <div class="form-group mb-4">
                    <label for="otros" class="form-label">Otros (especificar si corresponde):</label>
                    <input type="text" id="otros" name="otros" class="form-control" value="{{ old('otros') }}">
                    @error('otros')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón de envío -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg">Registrar Permiso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    // Mostrar/Ocultar campos según el tipo de permiso seleccionado
    document.getElementById('tipo_permiso').addEventListener('change', function() {
        var tipo = this.value;
        
        if (tipo === 'docente') {
            // Mostrar campo de materia para docentes
            document.getElementById('materia_field').style.display = 'block';
            document.getElementById('reemplazo_field').style.display = 'block';
            
            // Ocultar campos de cargo y oficina
            document.getElementById('cargo_field').style.display = 'none';
            document.getElementById('oficina_field').style.display = 'none';
            
        } else if (tipo === 'administrativo') {
            // Ocultar campo de materia
            document.getElementById('materia_field').style.display = 'none';
            document.getElementById('reemplazo_field').style.display = 'none';
            // Mostrar campos de cargo y oficina para administrativos
            document.getElementById('cargo_field').style.display = 'block';
            document.getElementById('oficina_field').style.display = 'block';
            
        } else {
            // Ocultar todos los campos si no hay tipo de permiso seleccionado
            document.getElementById('materia_field').style.display = 'none';
            document.getElementById('cargo_field').style.display = 'none';
            document.getElementById('oficina_field').style.display = 'none';
            document.getElementById('reemplazo_field').style.display = 'none';
        }
    });

    // Aplicar select2 a los select
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endsection

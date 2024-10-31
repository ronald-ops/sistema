@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('content')
<div class="container">
    <h1 class="my-4">Lista de Empleados</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('empleados.create') }}" class="btn btn-primary">Crear Nuevo Empleado</a>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <table id="empleadosTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cargo</th>
                <th class="text-center">Horarios</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->apellido }}</td>
                    <td>{{ $empleado->cargo }}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-sm" data-empleado-id="{{ $empleado->id }}" data-toggle="modal" data-target="#horariosModal">
                            Ver Horarios
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm btn-editar-empleado" data-id="{{ $empleado->id }}">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este empleado?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal para Editar Empleado --}}
<div class="modal fade" id="editEmpleadoModal" tabindex="-1" aria-labelledby="editEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmpleadoModalLabel">Editar Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmpleadoForm" method="POST" action="{{ route('empleados.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editEmpleadoId" name="empleado_id">

                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editApellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="editApellido" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" id="editCargo" name="cargo" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="editEmpleadoForm">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal para ver Horarios --}}
<div class="modal fade" id="horariosModal" tabindex="-1" role="dialog" aria-labelledby="horariosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="horariosModalLabel">Horarios del Empleado</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregarHorarioModal">
                        Agregar Nuevo Horario
                    </button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Día Asignado</th>
                            <th>Turno</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Tipo de Horario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="horariosBody">
                        <!-- Horarios cargados por JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Agregar Horario --}}
<div class="modal fade" id="agregarHorarioModal" tabindex="-1" aria-labelledby="agregarHorarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarHorarioModalLabel">Agregar Horario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="agregarHorarioForm" action="" method="POST">
                    @csrf
                    <div id="horario-blocks">
                        <div class="horario-block" data-index="0">
                            <div class="mb-3">
                                <label for="diaSemana_0" class="form-label">Día Asignado</label>
                                <select id="diaSemana_0" name="dia_semana[0]" class="form-control" required>
                                    <option value="">Seleccionar día</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miércoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                    <option value="7">Domingo</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="horarios_0">Horarios</label>
                                <select id="horarios_0" name="horarios[0]" class="form-control" required>
                                    @foreach ($horarios as $horario)
                                        <option value="{{ $horario->id }}">
                                            {{ $horario->turno->nombre_turno }} - {{ $horario->hora_entrada }} / {{ $horario->hora_salida }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipoHorario_0" class="form-label">Tipo de Horario</label>
                                <select id="tipoHorario_0" name="tipo_horario[0]" class="form-control" required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="normal">Normal</option>
                                    <option value="docencia">Docencia</option>
                                    <option value="capacitacion">Capacitación</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fechaInicio_0" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="fechaInicio_0" name="fecha_inicio[0]" required>
                            </div>
                            <div class="mb-3">
                                <label for="fechaFin_0" class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" id="fechaFin_0" name="fecha_fin[0]" required>
                            </div>
                            <button type="button" class="btn btn-danger remove-horario" data-index="0">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="addHorarioButton">Agregar Horario</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="agregarHorarioForm">Guardar Horarios</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#empleadosTable').DataTable();

        $('.btn-editar-empleado').click(function() {
            var empleadoId = $(this).data('id');
            var url = '{{ route("empleados.update", ":id") }}';
            url = url.replace(':id', empleadoId);

            $.get('/empleados/' + empleadoId, function(data) {
                $('#editEmpleadoId').val(data.id);
                $('#editNombre').val(data.nombre);
                $('#editApellido').val(data.apellido);
                $('#editCargo').val(data.cargo);
                $('#editEmpleadoForm').attr('action', url);
                $('#editEmpleadoModal').modal('show');
            });
        });

        $('#horariosModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var empleadoId = button.data('empleado-id');
            loadHorarios(empleadoId);
        });

        $('#addHorarioButton').click(function() {
            var index = $('.horario-block').length;
            var newBlock = `
                <div class="horario-block" data-index="${index}">
                    <div class="mb-3">
                        <label for="diaSemana_${index}" class="form-label">Día Asignado</label>
                        <select id="diaSemana_${index}" name="dia_semana[${index}]" class="form-control" required>
                            <option value="">Seleccionar día</option>
                            <option value="1">Lunes</option>
                            <option value="2">Martes</option>
                            <option value="3">Miércoles</option>
                            <option value="4">Jueves</option>
                            <option value="5">Viernes</option>
                            <option value="6">Sábado</option>
                            <option value="7">Domingo</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="horarios_${index}">Horarios</label>
                        <select id="horarios_${index}" name="horarios[${index}]" class="form-control" required>
                            @foreach ($horarios as $horario)
                                <option value="{{ $horario->id }}">
                                    {{ $horario->turno->nombre_turno }} - {{ $horario->hora_entrada }} / {{ $horario->hora_salida }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipoHorario_${index}" class="form-label">Tipo de Horario</label>
                        <select id="tipoHorario_${index}" name="tipo_horario[${index}]" class="form-control" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="normal">Normal</option>
                            <option value="docencia">Docencia</option>
                            <option value="capacitacion">Capacitación</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fechaInicio_${index}" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fechaInicio_${index}" name="fecha_inicio[${index}]" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaFin_${index}" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fechaFin_${index}" name="fecha_fin[${index}]" required>
                    </div>
                    <button type="button" class="btn btn-danger remove-horario" data-index="${index}">Eliminar</button>
                </div>
            `;
            $('#horario-blocks').append(newBlock);
        });

        $(document).on('click', '.remove-horario', function() {
            var index = $(this).data('index');
            $(this).closest('.horario-block').remove();
        });
    });

    function loadHorarios(empleadoId) {
        $.get('/empleados/' + empleadoId + '/horarios', function(data) {
            var horariosBody = $('#horariosBody');
            horariosBody.empty();
            data.horarios.forEach(function(horario) {
                horariosBody.append(`
                    <tr>
                        <td>${horario.dia_semana}</td>
                        <td>${horario.turno}</td>
                        <td>${horario.hora_entrada}</td>
                        <td>${horario.hora_salida}</td>
                        <td>${horario.tipo_horario}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-eliminar-horario" data-id="${horario.id}" data-empleado-id="${empleadoId}">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `);
            });
        });
    }

    $(document).on('click', '.btn-eliminar-horario', function() {
        var horarioId = $(this).data('id');
        var empleadoId = $(this).data('empleado-id');

        $.ajax({
            url: '/empleados/' + empleadoId + '/horarios/' + horarioId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                loadHorarios(empleadoId);
                alert('Horario eliminado con éxito');
            },
            error: function(xhr, status, error) {
                alert('Error al eliminar el horario');
            }
        });
    });
</script>
@endsection

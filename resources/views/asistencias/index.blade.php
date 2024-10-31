@extends('adminlte::page')
@section('plugins.Datatables', true)

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Control de Asistencia de Empleados</h1>

    <!-- Opcional: Campos de filtrado personalizados -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" id="searchNombre" class="form-control" placeholder="Buscar por Nombre">
        </div>
        <div class="col-md-3">
            <input type="text" id="searchApellido" class="form-control" placeholder="Buscar por Apellido">
        </div>
        <div class="col-md-3">
            <input type="date" id="searchFecha" class="form-control" placeholder="Buscar por Fecha">
        </div>
        <div class="col-md-3">
            <input type="text" id="searchHorasTrabajadas" class="form-control" placeholder="Buscar por Horas Trabajadas">
        </div>
    </div>

    <table id="asistenciaTable" class="table table-hover table-striped table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Minutos de Atraso</th>
                <th>Turno</th>
                <th>Horas Trabajadas</th> <!-- Nueva columna para horas trabajadas redondeadas -->
                <th>Horas Docencia</th> <!-- Nueva columna para Horas Docencia -->
                <th>Horas Capacitación</th> <!-- Nueva columna para Horas Capacitación -->
                <th>Observaciones</th> <!-- Nueva columna de Observaciones -->
            </tr>
        </thead>
        <tbody>
            @foreach ($asistencias as $index => $asistencia)
                <tr>
                    <!-- Número de fila -->
                    <td>{{ $index + 1 }}</td>
                    
                    <!-- Nombre y Apellido -->
                    <td>{{ $asistencia['nombre'] }}</td>
                    <td>{{ $asistencia['apellido'] }}</td>
                    
                    <!-- Fecha -->
                    <td>{{ \Carbon\Carbon::parse($asistencia['fecha'])->format('d-m-Y') }}</td> <!-- Formato más legible -->
                    
                    <!-- Hora de Entrada -->
                    <td class="{{ $asistencia['hora_entrada'] != 'SIN ENTRADA' ? 'text-success' : 'text-danger' }}">
                        {{ $asistencia['hora_entrada'] ?? 'N/A' }}
                    </td>
                    
                    <!-- Hora de Salida -->
                    <td class="{{ $asistencia['hora_salida'] != 'DESCUIDO' ? 'text-success' : 'text-danger' }}">
                        {{ $asistencia['hora_salida'] ?? 'N/A' }}
                    </td>
                    
                    <!-- Minutos de Atraso -->
                    <td>
                        @if ($asistencia['minutos_atraso'] != 'sin atraso' && $asistencia['minutos_atraso'] != '0 min')
                            <span class="badge badge-danger">
                                <i class="fas fa-clock"></i> {{ $asistencia['minutos_atraso'] }}
                            </span>
                        @else
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> Sin Atraso
                            </span>
                        @endif
                    </td>
                    
                    <!-- Turno -->
                    <td>
                        <span class="badge badge-info">
                            {{ $asistencia['horario'] ?? 'N/A' }} <!-- Mostrar el ID o nombre del turno -->
                        </span>
                    </td>
                    
                    <!-- Horas Trabajadas Redondeadas -->
                    <td>
                        <span class="badge badge-primary">
                            {{ $asistencia['horas_trabajadas'] ?? 'N/A' }} <!-- Mostrar las horas trabajadas redondeadas -->
                        </span>
                    </td>

                    <!-- Horas Docencia -->
                    <td>
                        <span class="badge badge-secondary">
                            {{ $asistencia['horas_docencia'] ?? 'N/A' }} <!-- Mostrar horas de docencia -->
                        </span>
                    </td>

                    <!-- Horas Capacitación -->
                    <td>
                        <span class="badge badge-warning">
                            {{ $asistencia['horas_capacitacion'] ?? 'N/A' }} <!-- Mostrar horas de capacitación -->
                        </span>
                    </td>

                    <!-- Observaciones -->
                    <td>
                        {{ $asistencia['observaciones'] ?? 'Sin Observaciones' }} <!-- Mostrar las observaciones si existen -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('js')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        var table = $('#asistenciaTable').DataTable({
            // Configuración de DataTable
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json'
            },
            paging: true, // Habilitar paginación
            ordering: true, // Habilitar ordenación por columnas
            autoWidth: false, // Desactivar el ajuste automático de ancho
            responsive: true, // Hacer la tabla responsiva
            lengthMenu: [10, 25, 50, 100], // Opciones de paginación
        });

        // Filtrar por Nombre
        $('#searchNombre').on('keyup', function() {
            table.columns(1).search(this.value).draw(); // Columna 1 es Nombre
        });

        // Filtrar por Apellido
        $('#searchApellido').on('keyup', function() {
            table.columns(2).search(this.value).draw(); // Columna 2 es Apellido
        });

        // Filtrar por Fecha
        $('#searchFecha').on('change', function() {
            var date = this.value ? moment(this.value).format('YYYY-MM-DD') : ''; // Formato adecuado
            table.columns(3).search(date).draw(); // Columna 3 es Fecha
        });

        // Filtrar por Horas Trabajadas
        $('#searchHorasTrabajadas').on('keyup', function() {
            table.columns(8).search(this.value).draw(); // Columna 8 es Horas Trabajadas
        });
    });
</script>
@endsection
@endsection

@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Importar Archivo de Registros Biométricos')

@section('content_header')
    <h1>Importar Archivo de Registros Biométricos</h1>
@stop

@section('content')
    <!-- Card para el formulario de importación -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Selecciona un archivo para importar</h3>
        </div>
        <div class="card-body">
            <!-- Formulario para importar archivo -->
            <form action="{{ route('importar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Seleccionar archivo (CSV, XLSX, XLS):</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                    
                    <!-- Mensaje de error en caso de no seleccionar un archivo válido -->
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-import"></i> Importar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección para mostrar los datos importados -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Registros Importados</h3>
        </div>
        <div class="card-body">
            @if(isset($biometricoLogs) && count($biometricoLogs) > 0)
                <!-- Tabla con DataTables -->
                <table id="biometricLogsTable" class="table table-hover table-striped table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Empleado</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th> <!-- Entrada o Salida -->
                        </tr>
                        <!-- Filtros de búsqueda al inicio, justo debajo de los encabezados -->
                        <tr>
                            <th><input type="text" placeholder="Buscar por ID" class="form-control form-control-sm" /></th>
                            <th><input type="text" placeholder="Buscar por Empleado" class="form-control form-control-sm" /></th>
                            <th><input type="text" placeholder="Buscar por Fecha" class="form-control form-control-sm" /></th>
                            <th><input type="text" placeholder="Buscar por Hora" class="form-control form-control-sm" /></th>
                            <th><input type="text" placeholder="Buscar por Estado" class="form-control form-control-sm" /></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($biometricoLogs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->empleado->nombre }} {{ $log->empleado->apellido }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->fecha)->format('d-m-Y') }}</td>
                                <td>{{ $log->hora }}</td>
                                <td>{{ $log->estado }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">No hay registros de biométricos importados actualmente.</p>
            @endif
        </div>
    </div>
@stop

@section('js')
    <!-- Inicialización de DataTables con filtros por columna en el encabezado -->
    <script>
        $(document).ready(function() {
            // Inicializa DataTables
            var table = $('#biometricLogsTable').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "pageLength": 10,
                "order": [[ 2, "desc" ]] // Ordenar por la fecha
            });

            // Aplicar filtros individuales en cada columna
            $('#biometricLogsTable thead tr:eq(1) th').each(function() {
                var title = $(this).text();
                $(this).find('input').on('keyup change', function() {
                    if (table.column($(this).parent().index()).search() !== this.value) {
                        table
                            .column($(this).parent().index())
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>
@stop

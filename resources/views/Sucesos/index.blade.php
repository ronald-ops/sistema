@extends('adminlte::page')

@section('title', 'Sucesos del Personal - Mayo 2024')

@section('content_header')
    <h1>Sucesos del Personal - Mayo 2024</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Sucesos del Personal</h3>
            <div class="card-tools">
                <!-- Botón para exportar a Excel -->
                <a href="{{ route('sucesos.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Exportar a Excel
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nombres y Apellidos</th>
                        <th>Retrasos (Min.)</th>
                        <th>Descuidos</th>
                        <th>Horas Pendientes a Compensar</th>
                        <th>Días, Horas, Min. a Cuenta Vacación</th>
                        <th>Horas Acum. De Pasantía</th>
                        <th>Horas por Serv. Adm.</th>
                        <th>Horas por Docencia</th>
                        <th>Horas por Capacitación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sucesos as $suceso)
                        <tr>
                            <td>{{ $suceso['no'] }}</td>
                            <td>{{ $suceso['nombre'] }}</td>
                            <td>{{ $suceso['retrasos'] }}</td>
                            <td>{{ $suceso['descuidos'] }}</td>
                            <td>{{ $suceso['pendientes_compensar'] }}</td>
                            <td>{{ $suceso['cuenta_vacacion'] }}</td>
                            <td>{{ $suceso['pasantia'] }}</td>
                            <td>{{ $suceso['servicio_adm'] }}</td>
                            <td>{{ $suceso['docencia'] }}</td>
                            <td>{{ $suceso['capacitacion'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Sucesos del Personal cargado!'); </script>
@stop

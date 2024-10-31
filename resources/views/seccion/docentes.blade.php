@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content')
<div class="container">
    <h2>Lista del personal de Docentes</h2>

    <table id="docente-table" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cargo</th>
                <th>Departamento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->id }}</td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->apellido }}</td>
                    <td>{{ $empleado->cargo }}</td>
                    <td>{{ $empleado->departamento->nombre_departamento }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#pasantes-table').DataTable();
    });
</script>
@endsection

<table>
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

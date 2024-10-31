@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Lista de Horarios')

@section('content_header')
    <h1>Lista de Horarios</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Turno</th>
                <th>Fecha</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horarios as $horario)
                <tr>
                    <td>{{ $horario->turno->nombre_turno }}</td>
                    <td>{{ $horario->fecha }}</td>
                    <td>{{ $horario->hora_entrada }}</td>
                    <td>{{ $horario->hora_salida }}</td>
                    <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editModal{{ $horario->id }}">
                            Editar
                        </button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $horario->id }}">
                            Eliminar
                        </button>
                    </td>
                </tr>

                <!-- Modal para editar -->
                <div class="modal fade" id="editModal{{ $horario->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $horario->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $horario->id }}">Editar Horario</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="turno_id">Turno</label>
                                        <select name="turno_id" class="form-control">
                                            @foreach($turnos as $turno)
                                                <option value="{{ $turno->id }}" {{ $horario->turno_id == $turno->id ? 'selected' : '' }}>
                                                    {{ $turno->nombre_turno }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha">Fecha</label>
                                        <input type="date" name="fecha" class="form-control" value="{{ $horario->fecha }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="hora_entrada">Hora de Entrada</label>
                                        <input type="time" name="hora_entrada" class="form-control" value="{{ $horario->hora_entrada }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="hora_salida">Hora de Salida</label>
                                        <input type="time" name="hora_salida" class="form-control" value="{{ $horario->hora_salida }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal para eliminar -->
                <div class="modal fade" id="deleteModal{{ $horario->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $horario->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $horario->id }}">Eliminar Horario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que quieres eliminar este horario?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    {{-- Aquí puedes agregar estilos adicionales --}}
@stop

@section('js')
    {{-- Aquí puedes agregar scripts adicionales --}}
@stop

@extends('adminlte::page')

@section('title', 'Editar Horario')

@section('content_header')
    <h1>Editar Horario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Editar Horario</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                @csrf
                @method('PUT')

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
                    <input type="date" name="fecha" class="form-control" value="{{ $horario->fecha }}" required>
                </div>

                <div class="form-group">
                    <label for="hora_entrada">Hora de Entrada</label>
                    <input type="time" name="hora_entrada" class="form-control" value="{{ $horario->hora_entrada }}" required>
                </div>

                <div class="form-group">
                    <label for="hora_salida">Hora de Salida</label>
                    <input type="time" name="hora_salida" class="form-control" value="{{ $horario->hora_salida }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@stop

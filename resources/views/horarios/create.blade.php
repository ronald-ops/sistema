@extends('adminlte::page')

@section('title', 'Crear Horario')

@section('content_header')
    <h1>Crear Horario</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="turno_id">Turno</label>
            <select name="turno_id" id="turno_id" class="form-control">
                @foreach($turnos as $turno)
                    <option value="{{ $turno->id }}">{{ $turno->nombre_turno }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
        </div>
        <div class="form-group">
            <label for="hora_entrada">Hora de Entrada</label>
            <input type="time" name="hora_entrada" id="hora_entrada" class="form-control">
        </div>
        <div class="form-group">
            <label for="hora_salida">Hora de Salida</label>
            <input type="time" name="hora_salida" id="hora_salida" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear Horario</button>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    {{-- Add here extra javascript --}}
@stop

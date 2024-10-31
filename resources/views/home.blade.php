@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $adminCount }}</h3>
                    <p>Personal <br>de Planta</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('seccion.administrativo') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $servicesCount }}</h3>
                    <p>Personal<br> de Servicios</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('seccion.servicios') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $teachersCount }}</h3>
                    <p>Plantel<br> Docentes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('seccion.docentes') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $internsCount }}</h3>
                    <p>Personal con Practicas Pre Profesionales</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('seccion.pasantes') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe de asistencia mensual</h3>
                    <div class="box-tools pull-right">
                        <form class="form-inline">
                            <div class="form-group">
                                <label>Seleccionar Año: </label>
<form method="GET" action="{{ route('home') }}" id="yearForm">
    <select class="form-control input-sm" id="select_year" name="year" onchange="document.getElementById('yearForm').submit();">
        @for ($i = 2015; $i <= 2065; $i++)
            <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
</form>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <br>
                        <div id="legend" class="text-center"></div>
                        <canvas id="barChart" style="height:350px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function(){
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChartData = {
        labels  : {!! json_encode($months) !!},
        datasets: [
            {
                label               : 'Tarde',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                data                : {!! json_encode($late) !!}
            },
            {
                label               : 'A tiempo',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                data                : {!! json_encode($ontime) !!}
            }
        ]
    };
    var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        legend: {
            display: true,
            position: 'top'
        }
    };

    var myChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });

    $('#select_year').change(function(){
        window.location.href = '{{ url("home") }}?year='+$(this).val();
    });
});
</script>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

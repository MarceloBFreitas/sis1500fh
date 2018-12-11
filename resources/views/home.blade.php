@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <label for="">Bem Vindo</label>
    <h1>{{Auth::user()->name}}</h1>
@stop

@section('content')
    @if(Session::has('usuario-criado'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Usuário: {{ Session::get('usuario-criado')}}</strong> Adicionado ao Staff com Sucesso.
        </div>
        {{Session::pull('usuario-criado')}}
    @endif

    @if(Session::has('usuario-erro'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Email cadastrado para: {{ Session::get('usuario-erro')}}</strong> .
        </div>
        {{Session::pull('usuario-erro')}}
    @endif

    @if(Session::has('consultor-criado'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Consultor </strong> Adicionado com Sucesso.
        </div>
        {{Session::pull('consultor-criado')}}
    @endif

    @if(Session::has('consultor-erro'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Erro ao Adicionar Consultor, verifique se o usuário não já está cadastrado como consultor</strong> .
        </div>
        {{Session::pull('consultor-erro')}}
    @endif


    <div class="container">
        <div class="col-md-6">
            <canvas id="horasSemanais"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="outroGrafico"></canvas>
        </div>

    </div>
    <div class="container">
        <div class="col-md-6">
            <canvas id="outroGrafico2"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="horasSemanais2"></canvas>
        </div>

    </div>





    <script>
        let horasSemanais = document.getElementById('horasSemanais').getContext('2d');
        let chart1 = new Chart(horasSemanais, {
            type: 'line',
            data: {
                labels: ['SEG', 'TER', 'QUA', 'QUI', 'SEX'],
                datasets: [{
                    label: 'Horas Planejadas',
                    data: [173448346, 175885229, 178276128, 180619108, 182911487, 185150806],
                    backgroundColor: "rgba(63, 63, 191, 0.3)",

                },
                    {
                        label: 'Horas Reais',
                        data: [173448346, 185150806, 175885229, 182911487, 178276128, 180619108],
                        backgroundColor: "rgba(0, 255, 0, 0.3)",

                    }
                ]
            }
        });

        let outroGrafico = document.getElementById('outroGrafico').getContext('2d');
        let chart2 = new Chart(outroGrafico, {
            type: 'pie',
            data: {
                labels: ['SEG', 'TER', 'QUA', 'QUI', 'SEX'],
                datasets: [{
                    label: 'Horas Planejadas',
                    data: [173448346, 175885229, 178276128, 180619108, 182911487, 185150806],
                    backgroundColor: "rgba(63, 63, 191, 0.3)",

                },
                    {
                        label: 'Horas Reais',
                        data: [173448346, 185150806, 175885229, 182911487, 178276128, 180619108],
                        backgroundColor: "rgba(0, 255, 0, 0.3)",

                    }
                ]
            }
        });

        let horasSemanais2 = document.getElementById('horasSemanais2').getContext('2d');
        let chart3 = new Chart(horasSemanais2, {
            type: 'line',
            data: {
                labels: ['SEG', 'TER', 'QUA', 'QUI', 'SEX'],
                datasets: [{
                    label: 'Horas Planejadas',
                    data: [173448346, 175885229, 178276128, 180619108, 182911487, 185150806],
                    backgroundColor: "rgba(63, 63, 191, 0.3)",

                },
                    {
                        label: 'Horas Reais',
                        data: [173448346, 185150806, 175885229, 182911487, 178276128, 180619108],
                        backgroundColor: "rgba(0, 255, 0, 0.3)",

                    }
                ]
            }
        });

        let outroGrafico2 = document.getElementById('outroGrafico2').getContext('2d');
        let chart4 = new Chart(outroGrafico2, {
            type: 'pie',
            data: {
                labels: ['SEG', 'TER', 'QUA', 'QUI', 'SEX'],
                datasets: [{
                    label: 'Horas Planejadas',
                    data: [173448346, 175885229, 178276128, 180619108, 182911487, 185150806],
                    backgroundColor: "rgba(63, 63, 191, 0.3)",

                },
                    {
                        label: 'Horas Reais',
                        data: [173448346, 185150806, 175885229, 182911487, 178276128, 180619108],
                        backgroundColor: "rgba(0, 255, 0, 0.3)",

                    }
                ]
            }
        });


    </script>
@stop
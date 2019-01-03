@extends('adminlte::page')

@section('title', 'Registro de horas')

@section('content_header')

    <h1>Diagrama de Rede e Tempos de Eventos  </h1>
@stop

@section('content')

<style type="text/css">
    #mynetwork {
        width: 100%;
        height: 400px;
        border: 1px solid lightgray;
    }
</style>

<div class="row">
    <div class="col-md-6">
        <div id="mynetwork"></div>
    </div>

    <div class="col-md-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Atividade</th>
                <th scope="col">Duração</th>
                <th scope="col">Ini.Antec</th>
                <th scope="col">Fim Antec</th>
                <th scope="col">Ini Tardio</th>
                <th scope="col">Fim Tardio</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>ETL</td>
                <td>5 horas</td>
                <td>10/02/2019</td>
                <td>20/02/2019</td>
                <td>12/02/2019</td>
                <td>22/02/2019</td>
            </tr>
            <tr>
                <td>ETL</td>
                <td>5 horas</td>
                <td>10/02/2019</td>
                <td>20/02/2019</td>
                <td>12/02/2019</td>
                <td>22/02/2019</td>
            </tr>
            <tr>
                <td>ETL</td>
                <td>5 horas</td>
                <td>10/02/2019</td>
                <td>20/02/2019</td>
                <td>12/02/2019</td>
                <td>22/02/2019</td>
            </tr>
            <tr>
                <td>ETL</td>
                <td>5 horas</td>
                <td>10/02/2019</td>
                <td>20/02/2019</td>
                <td>12/02/2019</td>
                <td>22/02/2019</td>
            </tr>

            </tbody>
        </table>

    </div>
</div>



<a href="/detalhe-projeto/{{$idprojeto}}"><button class="btn btn-default">Voltar</button></a>

<script type="text/javascript">
    // create an array with nodes


    var nodes = new vis.DataSet([
        {id: 1, label: 'BPS - Desenho \nda Solução'},
        {id: 2, label: 'Node 2'},
        {id: 3, label: 'Início'},
        {id: 4, label: 'Node 4'},
        {id: 5, label: 'Node 5'},
        {id: 6, label: 'Node 6'},
    ]);

    // create an array with edges
    var edges = new vis.DataSet([
        {from: 1, to: 3},
        {from: 1, to: 2},
        {from: 2, to: 4},
        {from: 2, to: 5}
    ]);

    // create a network
    var container = document.getElementById('mynetwork');

    // provide the data in the vis format
    var data = {
        nodes: nodes,
        edges: edges
    };
    var options = {

    };

    // initialize your network!
    var network = new vis.Network(container, data, options);
</script>
@stop
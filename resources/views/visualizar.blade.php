@extends('adminlte::page')

@section('title', 'Registro de horas')

@section('content_header')

    <h1>Visualização das Atividades</h1>
@stop

@section('content')

<style type="text/css">
    #mynetwork {
        width: 100%;
        height: 400px;
        border: 1px solid lightgray;
    }
</style>

<div id="mynetwork"></div>



<a href="/detalhe-projeto/{{$idprojeto}}"><button class="btn btn-default">Voltar</button></a>

<script type="text/javascript">
    // create an array with nodes


    var nodes = new vis.DataSet([
        {id: 1, label: 'BPS - Desenho \nda Solução'},
        {id: 2, label: 'Node 2'},
        {id: 3, label: 'Node 3'},
        {id: 4, label: 'Node 4'},
        {id: 5, label: 'Node 5'}
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
    var options = {};

    // initialize your network!
    var network = new vis.Network(container, data, options);
</script>
@stop
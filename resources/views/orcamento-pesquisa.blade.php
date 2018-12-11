@extends('adminlte::page')

@section('title', 'Orçamento Pesquisa')

@section('content_header')

    <h1><i class="glyphicon glyphicon-scale"></i> Pesquisa de Oçamento </h1>
@stop

@section('content')

<script>
    $(document).ready(function(){

        $('#datainiciomodal').mask('00/00/0000');
        $('#consultortable').DataTable(
            {
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            }
        );

    });
</script>

    <div class="container">

        <table class="table table-striped" style="text-align: center" id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Valor total</th>
                <th class="text-center">Detalhes</th>
            </tr>
            </thead>

            <tbody>
            @foreach($orca as $or)
                <tr class="item{{$or->id}}">
                    <td>{{$or->id}}</td>
                    <td>{{$or->nomefantasia}}</td>
                    <td>{{$or->nome}}</td>
                    <td>{{$or->valor_total}}</td>

                    <td>

                        <a href="/orcamento/{{$or->plano_id}}">
                            <button class="edit-modal btn btn-default" title="Detalhes do orçamento">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button></a>

                </tr>
            @endforeach

            </tbody>
        </table>

    </div>
@stop
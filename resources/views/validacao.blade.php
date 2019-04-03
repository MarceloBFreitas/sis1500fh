@extends('adminlte::page')

@section('title', 'Validação do Projeto')

@section('content_header')

<h1>Validação</h1>
@stop

@section('content')

    <script>
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
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


        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>
                <th class="text-center">teste</th>
                <th class="text-center">teste</th>
                <th class="text-center">tee</th>
                <th class="text-center">te</th>
                <th class="text-center">t</th>
            </tr>
            </thead>
            <tbody>

            <tr class="">
                <td>t</td>
                <td>te</td>
                <td>tee</td>
                <td>test</td>
                <td>teste</td>


            </tr>
            @endforeach
            </tbody>
        </table>




    </div>



    <!-- Validar Escopo -->
    <div class="modal fade" id="modalescopo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Validar Escopo</h4>
                </div>
                <div class="modal-body">
                    /////

                    <table class="table table-striped"  id="consultortable">
                        <thead>
                        <tr>
                            <th class="text-center">teste</th>
                            <th class="text-center">teste</th>
                            <th class="text-center">tee</th>
                            <th class="text-center">te</th>
                            <th class="text-center">t</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr class="">
                                <td>t</td>
                                <td>te</td>
                                <td>tee</td>
                                <td>test</td>
                                <td>teste</td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    ////

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



@stop
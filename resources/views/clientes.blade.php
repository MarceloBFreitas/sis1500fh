@extends('adminlte::page')

@section('title', 'Cadastro de Cliente')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Clientes</h1>
@stop

@section('content')
    <script>
        $(document).ready(function(){

            $('#cep').mask('00000 - 000');
            $('#cepe').mask('00000 - 000');
            $('#cnpj').mask('00.000.000/0000-00');
            $('#cnpje').mask('00.000.000/0000-00');
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

        function salvaCli() {

            var cli =  $('#addnovocli').val();
            $.ajax({
                type:'post',
                url:"{{URL::route('cadastrar.cliente')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    nome:cli
                },  success:function(data){
                    swal({
                        title: data.msg,
                        // text: 'Do you want to continue',
                        type: data.tipo,
                        timer: 2000
                    });
                    location.reload();
                }
            });
        }
        function showmodaladdcli() {
            $("#modalCriarCliente").modal('toggle');

        }

        function showmodaledit(nome,id) {
            $("#modalEditaCliente").modal('toggle');
            $('#editnovocli').val(nome);
            $('#editid').val(id);

        }

        function editacli(){

            var nome =  $('#editnovocli').val();
            var id =  $('#editid').val();
            $.ajax({
                type:'post',
                url:"{{URL::route('edit.cliente')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    nome:nome,
                    id:id,
                },  success:function(data){
                    swal({
                        title: data.msg,
                        // text: 'Do you want to continue',
                        type: data.tipo,
                        timer: 2000
                    });
                    location.reload();
                }
            });
        }

    </script>


    <div class="container">
        <br>
        <button onclick="showmodaladdcli()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Nome</th>

            </tr>
            </thead>
            <tbody>
            @foreach($cliente as $cli)
                <tr class="item{{$cli->id}}">
                    <td class="text-center">{{$cli->id}}</td>
                    <td class="text-center">{{$cli->nome}}</td>

                    <td>
                        <button class="edit-modal btn btn-default" title="Editar"

                                data-toggle="modal" onclick="showmodaledit('{{$cli->nome}}','{{$cli->id}}')">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>


    <!-- Modal Adicionar Cliente -->
    <div class="modal fade" id="modalCriarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Cliente</h4>
                </div>
                <div class="modal-body">
                    <label>Nome do  Cliente</label>
                    <input type="text" class="form-control" id="addnovocli">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvaCli()" class="btn btn-primary">Adicionar Cliente</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal EditaCliente -->
    <div class="modal fade" id="modalEditaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Cliente</h4>
                </div>
                <div class="modal-body">
                    <label>Nome do novo Cliente</label>
                    <input type="text" class="form-control" id="editnovocli">
                    <input type=hidden class="form-control" id="editid">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="editacli()" class="btn btn-primary">Alterar Cliente</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

@stop
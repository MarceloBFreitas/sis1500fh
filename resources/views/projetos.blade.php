@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Projetos</h1>
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

        function addProjeto() {

            $("#modalprojetos").modal('toggle');
        }


        function salvarprojeto(){
            var idcliente = $('#clientemodal').val();
            var nomeprojeto =$('#nomeprojetomodal').val();
            var objetivo =$('#objetivomodal').val();
            var mensuracao =$('#mensuracaomodal').val();
            var dtinicio =$('#datainiciomodal').val();

            if(dtinicio==""){
                swal({
                    title: 'Campo Obrigatório',
                    text: 'Por favor, verifique se o campo de Data de Início do Projeto do Preenchido',
                    type: 'warning',
                    timer: 2000
                });
            }else{
                var dtini = dtinicio.split('/');
                dtinicio = dtini[2]+'-'+dtini[1]+'-'+dtini[0];

                $.ajax({
                    type:'POST',
                    url:"{{URL::route('registrar.projeto')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        idcliente:idcliente,
                        nomeprojeto:nomeprojeto,
                        objetivo:objetivo,
                        mensuracao:mensuracao,
                        dtinicio:dtinicio
                    },
                    success:function(data){
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

        }




        function editarProjeto(id) {
            $.ajax({
                type:'get',
                url:'/detalhes-projeto/'+ id ,
                success:function(data){

                    console.log(data);
                    $('#nomeprojetomodale').val(data[0].nome);
                    $('#clientemodale').val(data[0].nomefantasia);
                    $('#idprojetoe').val(data[0].id);
                    $('#objetivomodale').val(data[0].objetivo);
                    $('#mensuracaomodale').val(data[0].mensuracao);
                    var dini = data[0].dt_inicio;
                    dini = dini.split('-');
                    $('#datainiciomodale').val(dini[2]+'/'+dini[1]+'/'+dini[0]);
                    $("#modalEditaProjeto").modal('toggle');
                }
            });
        }
        function atualizarProjeto(){

            var idprojeto = $('#idprojetoe').val();
            var nomeprojeto =$('#nomeprojetomodale').val();
            var objetivo =$('#objetivomodale').val();
            var mensuracao =$('#mensuracaomodale').val();
            var dtinicio =$('#datainiciomodale').val();



            if(dtinicio==""){
                swal({
                    title: 'Campo Obrigatório',
                    text: 'Por favor, verifique se o campo de Data de Início do Projeto do Preenchido',
                    type: 'warning',
                    timer: 2000
                });
            }else{
                var dtini = dtinicio.split('/');
                dtinicio = dtini[2]+'-'+dtini[1]+'-'+dtini[0];
                $.ajax({
                    type:'POST',
                    url:'/atualizar-projeto/'+ idprojeto ,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nomeprojeto:nomeprojeto,
                        objetivo:objetivo,
                        mensuracao:mensuracao,
                        dtinicio:dtinicio
                    },
                    success:function(data){
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

        }

        function removerProjeto($id) {
            swal({
                title: 'Confirmar Exclusão do Projeto?',
                text: 'Escopos, Orçamentos e Atividades relacionadas ao projeto também serão removidas,',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-projeto/'+$id,
                        data:{
                            _token : "<?php echo csrf_token() ?>"
                        },
                        success:function(data){
                            swal({
                                title: data.msg,
                                // text: 'Do you want to continue',
                                type: data.tipo,
                                timer: 2000
                            });
                            location.reload();
                        }
                    });


                } else if (result.dismiss === swal.DismissReason.cancel) {

                }
            })
        }

    </script>



    <div class="container">
        <br>
        <button onclick="addProjeto()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Objetivo</th>
                <th class="text-center">Data Início</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projetos as $projeto)
                <tr class="item{{$projeto->id}}">
                    <td>{{$projeto->id}}</td>
                    <td>{{$projeto->nome}}</td>
                    <td>{{$projeto->objetivo}}</td>
                    <td><?php
                        $data = explode('-',$projeto->dt_inicio);
                        echo $data[2]."/".$data[1]."/".$data[0];
                        ?></td>

                    <td>
                        <button class="edit-modal btn btn-default" title="Editar"
                                data-info="{{$projeto->id}},{{$projeto->nome}}"
                                data-toggle="modal" onclick="editarProjeto({{$projeto->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerProjeto({{$projeto->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>











    <!-- Modal Criar Projeto -->
    <div class="modal fade" id="modalprojetos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicioanr Projeto</h4>
                </div>
                <div class="modal-body clientebody">

                    <select class="form-control" name="" id="clientemodal">
                        @foreach($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->nomefantasia}}</option>
                        @endforeach
                    </select>
                    <label for="">Nome</label>
                    <input type="text" class="form-control" id="nomeprojetomodal">
                    <label for="">Objetivo</label>
                    <input type="text" class="form-control" id="objetivomodal">
                    <label for="">Mensuração</label>
                    <input type="text" class="form-control" id="mensuracaomodal">
                    <label for="">Data Início</label>
                    <input type="text" class="form-control" id="datainiciomodal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarprojeto()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>




    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="modalEditaProjeto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Projeto</h4>
                </div>
                <div class="modal-body clientebody">
                    <input type="hidden" id="idprojetoe">
                    <label for="">Cliente</label>
                    <input type="text" disabled class="form-control" id="clientemodale">
                    <label for="">Nome</label>
                    <input type="text" class="form-control" id="nomeprojetomodale">
                    <label for="">Objetivo</label>
                    <input type="text" class="form-control" id="objetivomodale">
                    <label for="">Mensuração</label>
                    <input type="text" class="form-control" id="mensuracaomodale">
                    <label for="">Data Início</label>
                    <input type="text" class="form-control" id="datainiciomodale">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="atualizarProjeto()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>





















@stop
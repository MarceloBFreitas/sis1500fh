@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Grupos de Atividades</h1>
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

        function addgrupo() {
            $("#modalGrupo").modal('toggle');
        }
        function salvarGrupo(){

            var nome = $('#gruponomemodal').val();
            var desc = $('#descgrupomodal').val();


            if(nome == "" ||desc==""){
                swal({
                    title: "Campos Vazios",
                    text:'Por favor, verifique se todos os campos foram preenchidos',
                    type: 'warning',
                    timer: 2000
                })
            }else{

                $.ajax({
                    type:'POST',
                    url:"{{URL::route('registrar.atividade.grupo')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nome:nome,
                        desc:desc
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

        function editarGrupo(id) {
            $.ajax({
                type:'get',
                url:'/detalhes-grupo/'+ id ,
                success:function(data){

                    console.log(data);
                     $('#gruponomemodale').val(data.nomegrupo);
                     $('#descgrupomodale').val(data.descricao);
                     $('#idgrupoe').val(data.id);
                    $("#modalEditagrupo").modal('toggle');
                }
            });
        }

        function atualizarGrupo(){

            var nomegrupo= $('#gruponomemodale').val();
            var descricao= $('#descgrupomodale').val();
            var id = $('#idgrupoe').val();

            if(nomegrupo == "" ||descricao==""){
                swal({
                    title: "Campos Vazios",
                    text:'Por favor, verifique se todos os campos foram preenchidos',
                    type: 'warning',
                    timer: 2000
                })
            }else{
                $.ajax({
                    type:'POST',
                    url:'/atualizar-grupo-nome',
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nomegrupo:nomegrupo,
                        descricao:descricao,
                        id: id
                    },
                    success:function(data){
                        swal({
                            title: data.msg,
                            // text: 'Do you want to continue',
                            type: data.tipo,
                            timer: 2000
                        });
                        console.log(data);
                        location.reload();
                    }
                });
            }

        }

        function removerGrupo(id) {
            swal({
                title: 'Confirmar Exclusão do Grupo?',
                //text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-grupo/'+id,
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
        <button onclick="addgrupo()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Criar Grupo</button>


        <br><br>

        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Grupo</th>
                <th class="text-center">Descrição</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($grupoatividades as $grupoatividade)
                <tr class="item{{$grupoatividade->id}}">
                    <td class="text-center">{{$grupoatividade->id}}</td>
                    <td class="text-center">{{$grupoatividade->nomegrupo}}</td>
                    <td class="text-center">{{$grupoatividade->descricao}}</td>

                    <td class="text-center">
                        <a href="/gerenciar-grupo/<?php echo $grupoatividade->id;?>">
                            <button class="edit-modal btn btn-success" title="Incluir Tipos">
                            <span class="glyphicon glyphicon-plus"></span>
                            </button></a>
                        <button class="edit-modal btn btn-default" title="Editar"
                                data-info="{{$grupoatividade->id}},{{$grupoatividade->nome}}"
                                data-toggle="modal" onclick="editarGrupo({{$grupoatividade->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerGrupo({{$grupoatividade->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <br><br>


        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>











    <!-- Modal Criar Perfil -->
    <div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Grupo</h4>
                </div>
                <div class="modal-body">
                    <label>Grupo de Atividade</label>
                    <input type="text" class="form-control" id="gruponomemodal">
                    <label>Descrição</label>
                    <textarea class="form-control" id="descgrupomodal"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarGrupo()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>








    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="modalEditagrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Perfil</h4>
                </div>
                <div class="modal-body">

                    <label>Grupo de Atividade</label>
                    <input type="text" class="form-control" id="gruponomemodale">
                    <label>Descrição</label>
                    <textarea class="form-control" id="descgrupomodale"></textarea>

                    <input type="hidden" id="idgrupoe" value="">



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="atualizarGrupo()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>





















@stop
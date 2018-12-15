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

        function addatividade() {
            $("#modalCriarAtividade").modal('toggle');
        }
        function salvarAtividade(){

            var nome = $('#nome').val();
            var sigla = $('#sigla').val().toUpperCase();
            var descricao = $('#descricao').val();

            var tipo = $('#tipoid').val();

            if(sigla == ""){
                swal({
                    title: "Sigla hora preenchida",
                    type: 'warning',
                    timer: 2000
                })
            }else{

                $.ajax({
                    type:'POST',
                    url:"{{URL::route('registrar.atividade')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nome:nome,
                        sigla:sigla,
                        descricao: descricao,
                        tipo:tipo
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

        function editarAtividade(id) {
            $.ajax({
                type:'get',
                url:'/detalhes-atividade/'+ id ,
                success:function(data){
                    $('#nomee').val(data[0].nome);
                    $('#siglae').val(data[0].sigla);
                    $('#descricaoe').val(data[0].descricao);
                    $('#idatividade').val(data[0].id);
                    var tipo = $('#tipoide').val(data[0].tipo);

                    $("#modalEditaAtividade").modal('toggle');


                }
            });
        }
        function atualizarAtividade(){

            var nome = $('#nomee').val();
            var sigla = $('#siglae').val().toUpperCase();
            var descricao = $('#descricaoe').val();
            var idatividade= $('#idatividade').val();
            var tipo = $('#tipoide').val();


            $.ajax({
                type:'POST',
                url:'/atualizar-atividade/'+ idatividade ,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    nome:nome,
                    sigla:sigla,
                    descricao: descricao,
                    tipo:tipo
                },
                success:function(data){
                    swal({
                        title: data.msg,
                        // text: 'Do you want to continue',
                        type: data.tipo,
                        timer: 2000
                    });
                    console.log(data);
                }
            });
        }

        function removerAtividade($id) {
            swal({
                title: 'Confirmar Exclusão do Atividade?',
                //text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-atividade/'+$id,
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
        <button onclick="addatividade()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Sigla</th>
                <th class="text-center">Nome</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($grupoatividades as $grupoatividade)
                <tr class="item{{$grupoatividade->blid}}">
                    <td>{{$grupoatividade->blid}}</td>
                    <td>{{$atividade->sigla}}</td>
                    <td>{{$atividade->nome}}</td>
                    <td>{{$atividade->tipo}}</td>

                    <td>
                        <button class="edit-modal btn btn-default" title="Editar"
                                data-info="{{$atividade->id}},{{$atividade->nome}}"
                                data-toggle="modal" onclick="editarAtividade({{$atividade->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerAtividade({{$atividade->id}})">
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
    <div class="modal fade" id="modalCriarAtividade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade</h4>
                </div>
                <div class="modal-body">
                    <label>Tipo</label>
                    <select title="Pick a number" class="form-control selectpicker" id="tipoid">
                        <option value="Gestão">Gestão</option>
                        <option value="Técnica">Técnica</option>
                    </select> <br/>

                    <label>Sigla</label>
                    <input type="text" class="form-control" id="sigla">
                    <label for="">Nome</label>
                    <input type="text" class="form-control" id="nome">
                    <label for="">Descrição</label>
                    <textarea name="" id="descricao" cols="30" rows="5" class="form-control"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarAtividade()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>








    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="modalEditaAtividade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Perfil</h4>
                </div>
                <div class="modal-body">

                    <label>Tipo</label>
                    <select title="Pick a number" class="form-control selectpicker" id="tipoide">
                        <option value="Gestão">Gestão</option>
                        <option value="Técnica">Técnica</option>
                    </select> <br/>


                    <label>Sigla</label>
                    <input type="text" class="form-control" id="siglae">
                    <label for="">Nome</label>
                    <input type="text" class="form-control" id="nomee">
                    <label for="">Descrição</label>
                    <textarea name="" id="descricaoe" cols="30" rows="5" class="form-control"></textarea>

                    <input type="hidden" id="idatividade" value="">



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="atualizarAtividade()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>





















@stop
@extends('adminlte::page')

@section('title', 'Listagem de Staff')

@section('content_header')

    <h1>Equipe</h1>
@stop

@section('content')

    <script type="text/javascript">
        $(function() {
            $('#userstable').DataTable(
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

        function editarUser(iduser) {
            $.ajax({
                type:'get',
                url:'/detalhes-usuario/'+iduser,
                success:function(data){
                    //alert(data.name);
                    $('#myModalLabel').html(data.name).fadeIn('slow');
                    $('#nomemodal').val(data.name);
                    $('#emailmodal').val(data.email);
                    var registrado = data.created_at.split(" ");
                    var data1 = registrado[0].split("-");

                    $('#registradomodal').html("Data do Registro: <strong>"+data1[2]+"/"+data1[1]+"/"+data1[0]+ " - "+registrado[1]+"</strong>");

                    var atualizado = data.updated_at.split(" ");
                    var data2 = atualizado[0].split("-");
                    $('#atualizadomodal').html("Última Atualização: <strong>"+data2[2]+"/"+data2[1]+"/"+data2[0]+ " - "+atualizado[1]+"</strong>");
                    $('#cargomodal :nth-child('+data.nivelacesso+')').prop('selected', true);
                    $('#idusermodal').val(data.id);
                    $("#modalEditaUser").modal('toggle');
                }
            });
        }

        function salvarUser(){

            $.ajax({
                type:'POST',
                url:'/atualizar-usuario/'+$('#idusermodal').val(),
                data:{
                    _token : "<?php echo csrf_token() ?>",
                    nome:$('#nomemodal').val(),
                    email:$('#emailmodal').val(),
                    cargo: $('#cargomodal').val()
                },
                success:function(data){
                    swal({
                        title: data.msg,
                        // text: 'Do you want to continue',
                        type: data.tipo,
                        timer: 2000
                    })
                }
            });

            $("#modalEditaUser").modal('toggle');
            location.reload();





        }

        function removeUser($id){

            swal({
                title: 'Confirmar Exclusão do Usuário?',
                //text: 'You will not be able to recover this imaginary file!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-usuario/'+$id,
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


        <table class="table table-striped"  id="userstable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Nome</th>
                <th class="text-center">E-Mail</th>
                <th class="text-center">Cargo</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="item{{$user->id}}">
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if($user->nivelacesso==1)
                            Administrativo
                        @endif
                        @if($user->nivelacesso==2)
                            Gerência
                        @endif
                        @if($user->nivelacesso==3)
                            Consultor
                        @endif
                    </td>

                    <td>
                       <button class="edit-modal btn btn-default" title="Editar"
                                data-info="{{$user->id}},{{$user->name}}"
                                data-toggle="modal" onclick="editarUser({{$user->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removeUser({{$user->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>








    <!-- Modal Editar Usuário -->
    <div class="modal fade" id="modalEditaUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-addon" id="">Nome Completo</span>
                        <input type="text" id="nomemodal" class="form-control" placeholder="Nome Completo"
                               @if(Auth::user()->nivelacesso ==3)
                               disabled
                               @endif
                               aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="">E-mail</span>
                        <input type="text" id="emailmodal" class="form-control" placeholder="E-Mail"
                               @if(Auth::user()->nivelacesso ==3)
                                       disabled
                               @endif
                               aria-describedby="basic-addon1">
                    </div>
                    <select name="cargo"  class="form-control selectmodal" id="cargomodal"
                            @if(Auth::user()->nivelacesso ==3)
                            disabled
                            @endif
                            class="form-control">
                        <option value="1">Administrativo</option>
                        <option value="2">Gerência</option>
                        <option value="3">Consultor</option>
                    </select>
                    <p id="registradomodal" ></p>
                    <p id="atualizadomodal" ></p>
                    <input type="hidden" value="" id="idusermodal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarUser()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>
































@stop
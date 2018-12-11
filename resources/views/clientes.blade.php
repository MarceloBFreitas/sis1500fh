@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

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

        function addcliente() {
            $("#modalCriarCliente").modal('toggle');
        }
        function salvarCliente(){
            var nomefantasia = $('#nomefantasia').val();
            var razaosocial = $('#razaosocial').val().toUpperCase();
            var cnpj = $('#cnpj').val();
            var ie = $('#ie').val();
            var emailcliente = $('#emailcliente').val();
            var telefone = $('#telefone').val();
            var celular = $('#celular').val();
            var pais = $('#pais').val();
            var estado = $('#estado').val();
            var cidade = $('#cidade').val();
            var bairro = $('#bairro').val();
            var rua = $('#rua').val();
            var complemento = $('#complemento').val();
            var numero = $('#numero').val();
            var contato = $('#contato').val();
            var cep = $('#cep').val();
            var cont=0;
            $.each( $( ".clientebody input" ), function() {
                if( this.value ==""){
                    cont++;
                }
            });
            if(cont > 15){
                swal({
                    title: "Por Favor verifique se todos os campos foram preenchidos",
                    type: 'warning',
                    timer: 2000
                });
                console.log(cont);
                cont=0;
            }else{

                $.ajax({
                    type:'POST',
                    url:"{{URL::route('registrar.cliente')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nomefantasia: nomefantasia,
                        razaosocial: razaosocial,
                        cnpj :cnpj,
                        ie :ie,
                        emailcliente: emailcliente,
                        telefone :telefone,
                        celular :celular,
                        pais:pais,
                        estado :estado,
                        cidade :cidade,
                        bairro:bairro,
                        rua :rua,
                        complemento: complemento,
                        numero :numero,
                        contato:contato,
                        cep :cep
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




        function editarCliente(id) {
            $.ajax({
                type:'get',
                url:'/detalhes-cliente/'+ id ,
                success:function(data){
                    $('#nomefantasiae').val(data[0].nomefantasia);
                    $('#razaosociale').val(data[0].razaosocial);
                    $('#cnpje').val(data[0].cnpj);
                    $('#iee').val(data[0].ie);
                    $('#emailclientee').val(data[0].email);
                    $('#telefonee').val(data[0].telefone);
                    $('#celulare').val(data[0].celular);
                    $('#paise').val(data[0].pais);
                    $('#estadoe').val(data[0].estado);
                    $('#cidadee').val(data[0].cidade);
                    $('#bairroe').val(data[0].bairro);
                    $('#ruae').val(data[0].rua);
                    $('#complementoe').val(data[0].complemento);
                    $('#numeroe').val(data[0].numero);
                    $('#contatoe').val(data[0].contato);
                    $('#cepe').val(data[0].cep);
                    $('#idcliente').val(data[0].id);
                    $("#modalEditaCliente").modal('toggle');


                }
            });
        }
        function atualizarCliente(){

            var nomefantasia = $('#nomefantasiae').val();
            var razaosocial = $('#razaosociale').val().toUpperCase();
            var cnpj = $('#cnpje').val();
            var ie = $('#iee').val();
            var emailcliente = $('#emailclientee').val();
            var telefone = $('#telefonee').val();
            var celular = $('#celulare').val();
            var pais = $('#paise').val();
            var estado = $('#estadoe').val();
            var cidade = $('#cidadee').val();
            var bairro = $('#bairroe').val();
            var rua = $('#ruae').val();
            var complemento = $('#complementoe').val();
            var numero = $('#numeroe').val();
            var contato = $('#contatoe').val();
            var cep = $('#cepe').val();
            var idcliente = $('#idcliente').val();
            var cont=0;
            $.each( $( ".clientebody input" ), function() {
                if( this.value ==""){
                    cont++;
                }
            });


            if(cont > 15){
                swal({
                    title: "Por Favor verifique se todos os campos foram preenchidos",
                    type: 'warning',
                    timer: 2000
                });
                console.log(cont);
                cont=0;
            }else{
                $.ajax({
                    type:'POST',
                    url:'/atualizar-cliente/'+ idcliente ,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nomefantasia: nomefantasia,
                        razaosocial: razaosocial,
                        cnpj :cnpj,
                        ie :ie,
                        emailcliente: emailcliente,
                        telefone :telefone,
                        celular :celular,
                        pais:pais,
                        estado :estado,
                        cidade :cidade,
                        bairro:bairro,
                        rua :rua,
                        complemento: complemento,
                        numero :numero,
                        contato:contato,
                        cep :cep
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
        <button onclick="addcliente()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Nome Fantasia</th>
                <th class="text-center">E-Mail</th>
                <th class="text-center">Telefone</th>
                <th class="text-center">Celular</th>
                <th class="text-center">Contato</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr class="item{{$cliente->id}}">
                    <td>{{$cliente->id}}</td>
                    <td>{{$cliente->nomefantasia}}</td>
                    <td>{{$cliente->email}}</td>
                    <td>{{$cliente->telefone}}</td>
                    <td>{{$cliente->celular}}</td>
                    <td>{{$cliente->contato}}</td>

                    <td>
                        <button class="edit-modal btn btn-default" title="Editar"
                                data-info="{{$cliente->id}},{{$cliente->nomefantasia}}"
                                data-toggle="modal" onclick="editarCliente({{$cliente->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerCliente({{$cliente->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>


    <!-- Modal Criar Perfil -->
    <div class="modal fade" id="modalCriarCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Cliente</h4>
                </div>
                <div class="modal-body clientebody">
                    <div class="input-group">
                        <label class="input-group-addon">Nome Fantasia</label>
                        <input type="text" class="form-control" id="nomefantasia">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Razão Social</label>
                        <input type="text" class="form-control" id="razaosocial">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj">
                        <label class="input-group-addon">IE</label>
                        <input type="text" class="form-control" id="ie">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">E-Mail</label>
                        <input type="text" class="form-control" id="emailcliente">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Telefone</label>
                        <input type="text" class="form-control" id="telefone">
                        <label class="input-group-addon">Celular</label>
                        <input type="text" class="form-control" id="celular">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Pais</label>
                        <input type="text" value="Brasil" class="form-control" id="pais">
                        <label class="input-group-addon">Estado</label>
                        <input type="text" value="SP" class="form-control" id="estado">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Cidade</label>
                        <input type="text" value="São Paulo" class="form-control" id="cidade">
                        <label class="input-group-addon">Bairro</label>
                        <input type="text"  class="form-control" id="bairro">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Rua|Av</label>
                        <input type="text" class="form-control" id="rua">
                        <label class="input-group-addon">Compl.</label>
                        <input type="text"  class="form-control" id="complemento">
                        <label class="input-group-addon">Num.</label>
                        <input type="text"  class="form-control" id="numero">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">CEP</label>
                        <input type="text" class="form-control" id="cep">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Nome do Contato</label>
                        <input type="text" class="form-control" id="contato">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarCliente()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>




    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="modalEditaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Perfil</h4>
                </div>
                <div class="modal-body clientebody">
                    <input type="hidden" id="idcliente">
                    <div class="input-group">
                        <label class="input-group-addon">Nome Fantasia</label>
                        <input type="text" class="form-control" id="nomefantasiae">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Razão Social</label>
                        <input type="text" class="form-control" id="razaosociale">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">CNPJ</label>
                        <input type="text" class="form-control" id="cnpje">
                        <label class="input-group-addon">IE</label>
                        <input type="text" class="form-control" id="iee">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">E-Mail</label>
                        <input type="text" class="form-control" id="emailclientee">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Telefone</label>
                        <input type="text" class="form-control" id="telefonee">
                        <label class="input-group-addon">Celular</label>
                        <input type="text" class="form-control" id="celulare">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Pais</label>
                        <input type="text" value="Brasil" class="form-control" id="paise">
                        <label class="input-group-addon">Estado</label>
                        <input type="text" value="SP" class="form-control" id="estadoe">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Cidade</label>
                        <input type="text" value="São Paulo" class="form-control" id="cidadee">
                        <label class="input-group-addon">Bairro</label>
                        <input type="text"  class="form-control" id="bairroe">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Rua|Av</label>
                        <input type="text" class="form-control" id="ruae">
                        <label class="input-group-addon">Compl.</label>
                        <input type="text"  class="form-control" id="complementoe">
                        <label class="input-group-addon">Num.</label>
                        <input type="text"  class="form-control" id="numeroe">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">CEP</label>
                        <input type="text" class="form-control" id="cepe">
                    </div>
                    <div class="input-group">
                        <label class="input-group-addon">Nome do Contato</label>
                        <input type="text" class="form-control" id="contatoe">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="atualizarCliente()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



@stop
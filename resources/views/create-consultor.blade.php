@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Gerenciar Consultores</h1>
@stop

@section('content')
    <script>
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data

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

        function addconsultor() {
            $("#modalCriarConsultor").modal('toggle');
            $('#myModalLabel').html("Cadastrar Consultor").fadeIn('slow');
        }
        function salvarConsultor(){
            var custohora = $('#custohora').val();
            custohora = custohora.replace(',','.');
            var idconsultor = $('#idconsultor').val();
            var horasdia = $('#horasdia').val();
            var datainicio = $('#datainicio').val();

            if(datainicio == ""){
                swal({
                    title: "Data de Início não preenchida",
                    type: 'warning',
                    timer: 2000
                })
            }else{
                var dtini = datainicio.split('/');
                datainicio = dtini[2]+'-'+dtini[1]+'-'+dtini[0];


                $.ajax({
                    type:'POST',
                    url:"{{URL::route('registrar.consultor')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        custohora:custohora,
                        idconsultor:idconsultor,
                        horasdia: horasdia,
                        datainicio:datainicio
                    },
                    success:function(data){
                        swal({
                            title: data.msg,
                            // text: 'Do you want to continue',
                            type: data.tipo, //success ou error
                            timer: 2000
                        });
                        console.log(data);

                        location.reload();


                    }
                });
            }
        }
        function editarUser(idcon) {
            $.ajax({
                type:'get',
                url:'/detalhes-consultor/'+ idcon ,
                success:function(data){
                    $('#idconsultor').val(idcon);
                    $('#custohorae').val(data[0].custohora);
                    $('#nomeconsultore').val(data[0].name);
                    $('#horasdiae').val(data[0].horas_por_dia);
                    var dtinici = data[0].data_inicio.split('-');
                    $('#datainicioe').val(dtinici[2]+"/"+dtinici[1]+"/"+dtinici[0]);
                    $('#emailconsultore').val(data[0].email);
                    $("#modalEditarConsultor").modal('toggle');
                    console.log(data);
                }
            });
        }
        function atualizarConsultor(){

            var datainicio = $('#datainicioe').val();
            var dtini = datainicio.split('/');
            datainicio = dtini[2]+'-'+dtini[1]+'-'+dtini[0];
            var custohora = $('#custohorae').val();
            custohora = custohora.replace(',','.');
            $.ajax({
                type:'POST',
                url:'/atualizar-consultor/'+ $('#idconsultor').val() ,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    custohora:custohora,
                    horasdia:  $('#horasdiae').val(),
                    datainicio:datainicio
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
        function removerUser($id) {
            swal({
                title: 'Confirmar Exclusão do Consultor?',
                text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-consultor/'+$id,
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
        <button onclick="addconsultor()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


            <br><br>

        <table class="table table-striped"  id="consultortable">
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
            @foreach($consultores as $consultor)
                <tr class="item{{$consultor->id}}">
                    <td>{{$consultor->id}}</td>
                    <td>{{$consultor->name}}</td>
                    <td>{{$consultor->email}}</td>
                    <td>
                        @if($consultor->nivelacesso==1)
                            Administrativo
                        @endif
                        @if($consultor->nivelacesso==2)
                            Gerência
                        @endif
                        @if($consultor->nivelacesso==3)
                            Consultor
                        @endif
                    </td>

                    <td>
                        <button class="edit-modal btn btn-default" title="Editar"
                                data-info="{{$consultor->id}},{{$consultor->name}}"
                                data-toggle="modal" onclick="editarUser({{$consultor->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerUser({{$consultor->cons_id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

            <a href="/"><button class="btn btn-default">Voltar</button></a>
            <button type="button"  onclick="salvarConsultor()" class="btn btn-success">Cadastrar</button>

    </div>














    <!-- Modal Criar Consultor -->
    <div class="modal fade" id="modalCriarConsultor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">

                    <label>Selecione o Usuário</label>
                    <select id="idconsultor" name="idconsultor" class="form-control" id="nomeconsultor">
                        @foreach($naoregistrados as $consultor)

                            <option value="{{$consultor->id}}">{{$consultor->name}}</option>
                        @endforeach
                    </select>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Custo / Hora</label>
                            R$<input type="text"  id="custohora" class="money2 form-control" placeholder="Custo Hora ">
                        </div>
                        <div class="col-md-6">
                            <label for="">Horas por dia</label>
                            <input type="text"  id="horasdia" class="money2 form-control"  placeholder="total de Horas Trabalhadas por dia">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Data de Início</label>
                            <input type="text" id="datainicio" class="datainput form-control" placeholder="Data de Início ">
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarConsultor()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>




    <!-- Modal Editar Consultor -->
    <div class="modal fade" id="modalEditarConsultor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Consultor</h4>
                </div>
                <input type="hidden" id="idconsultor" value="">
                <div class="modal-body">
                    <label for="">Nome</label>
                    <input type="text" id="nomeconsultore" disabled class="form-control">
                    <input type="text" id="emailconsultore" disabled class="form-control">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Custo / Hora</label>
                            R$<input type="text"  id="custohorae" class="money2 form-control" placeholder="Custo Hora ">
                        </div>
                        <div class="col-md-6">
                            <label for="">Horas por dia</label>
                            <input type="text"  id="horasdiae" class="money2 form-control"  placeholder="total de Horas Trabalhadas por dia">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Data de Início</label>
                            <input type="text" id="datainicioe" class="datainput form-control" placeholder="Data de Início ">
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="atualizarConsultor()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>





















@stop
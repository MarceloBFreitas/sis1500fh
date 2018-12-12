@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Projetos</h1>
@stop

@section('content')
    <?php
    function formatarDataFront($data){
        $dataarray = explode("-",$data);
        return $dataarray[2]."/".$dataarray[1]."/".$dataarray[0];
    }
    ?>
    <script>
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#projetosdettable').DataTable(
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

        function addOrcamentoEscopo() {
            $("#modalCriarOrcamentoEscopo").modal('toggle');
        }



        function criarOrcamentoEscopo(){

            var cliente = $('#addclientemodal').val();
            var projeto = $('#addprojetomodal').val();
            var objetivo = $('#addobjetivomodal').val();
            var tarifatecn = $('#addtartecnmodal').val();
            var tarifagestao = $('#addtargestaomodal').val();
            var mensuracao = $('#addmensuracaotextmodal').val();
            var mensuracaodata = $('#addmensuracaodatamodal').val();



            if(cliente == "" || projeto=="" ||objetivo=="" ||tarifatecn=="" ||tarifagestao==""){
                swal({
                    title: "Campos não preenchidos",
                    text: "Por favor, verifique se todos os campos foram preenchidos",
                    type: 'warning',
                    timer: 2000
                })
            }else{

                $.ajax({
                    type:'POST',
                    url:"{{URL::route('criar.orcamento.escopo')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        cliente :cliente,
                        projeto:projeto,
                        objetivo :objetivo,
                        tarifatecn :tarifatecn,
                        tarifagestao :tarifagestao,
                        mensuracao :mensuracao,
                        mensuracaodata :mensuracaodata

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
        <button onclick="addOrcamentoEscopo()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped"  id="projetosdettable">
            <thead>
            <tr>
                <th class="text-center">Cliente</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Horas Totais</th>
                <th class="text-center">Horas Estimadas</th>
                <th class="text-center">Mensuração</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projetos as $projeto)
                <tr class="item{{$projeto->id}}">
                    <td>{{$projeto->cliente}}</td>
                    <td>{{$projeto->projeto}}</td>
                    <td>{{$projeto->horas_totais}}</td>
                    <td>{{$projeto->horas_estimadas}}</td>
                    <td>{{formatarDataFront($projeto->mensuracao_data)}}</td>

                    <td><a href="/configurar-orcamento/{{$projeto->id}}">
                            <button class="edit-modal btn btn-default" title="Detalhes"
                                    data-toggle="modal">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button></a>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerAtividade({{$projeto->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>


    <!-- Modal Criar Escopo -->
    <div class="modal fade" id="modalCriarOrcamentoEscopo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Escopo para Orçamento</h4>
                </div>
                <div class="modal-body">
                    <label>Cliente</label>
                    <input type="text" class="form-control" id="addclientemodal">
                    <label>Nome do Projeto</label>
                    <input type="text" class="form-control" id="addprojetomodal">
                    <label>Objetivo</label>
                    <input type="text" class="form-control" id="addobjetivomodal">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Tarifa Técnica</label>
                            <input type="text" class="form-control" id="addtartecnmodal">
                        </div>
                        <div class="col-md-4">
                            <label for="">Tarifa Gestão</label>
                            <input type="text" class="form-control" id="addtargestaomodal">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">Mensuração</label>
                            <input type="text" class="form-control" id="addmensuracaotextmodal">
                        </div>
                        <div class="col-md-4">
                            <label for="">Data Mensurada</label>
                            <input type="date" class="form-control" id="addmensuracaodatamodal">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="criarOrcamentoEscopo()" class="btn btn-primary">Criar Escopo</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



@stop
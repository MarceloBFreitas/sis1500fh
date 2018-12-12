@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Projeto {{$projeto->projeto}}</h1>
    <div class="container">
        <div class="col-md-6">
            <label for="">Nome do Projeto</label>
            <input type="text" value="{{$projeto->projeto}}" class="form-control">
            <label for="">Cliente</label>
            <input type="text" value="{{$projeto->cliente}}" class="form-control">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Mensuração</label>
                    <input type="text" value="{{$projeto->mensuracao_descricao}}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="">Data</label>
                    <input type="date" value="{{$projeto->mensuracao_data}}" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="">Tarifa Técnica</label>
                    <input type="text" value="{{$projeto->tecn}}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="">Tarifa Gestão</label>
                    <input type="text" value="{{$projeto->gestao}}" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label for="">Horas Totais</label>
            <input type="text" value="{{$projeto->horas_totais}}" class="form-control">
            <label for="">Valor</label>
            <input type="text" value="{{$projeto->valor_total}}" class="form-control">
            <label for="">Custo</label>
            <input type="text" value="{{$projeto->custo_total}}" class="form-control">
            <br>
            <button class="btn btn-warning form-control">Atualizar Dados</button>
        </div>

    </div>

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
            $('#projetoodettable').DataTable(
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

        function adicionaratividadeModal() {
            $("#modaladicionarAtividade").modal('toggle');
        }

        function adicionarAtividadeCreate(){

            var atvid = $('#tipoatividademodal').val();
            var descricao =  $('#descatvmodal').val();
            var horasestimadas =  $('#horasestimadasmodal').val();



            if(horasestimadas == "" ){
                swal({
                    title: "Campos não preenchidos",
                    text: "Por favor, verifique se todos os campos foram preenchidos",
                    type: 'warning',
                    timer: 2000
                })
            }else{

                $.ajax({
                    type:'POST',
                    url:"{{URL::route('adicionar.atividade.escopo')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{

                        atvid :atvid,
                        descricao:descricao,
                        horasestimadas :horasestimadas
                    },
                    success:function(data){
                        console.log(data);
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

        function atualizarDetalhe(id) {
            var descricao =  $('#descridettabela').val();
            var horas =  $('#horasdettabela').val();

            $.ajax({
                type:'post',
                url:'/atualizar-atividade-orcamento/'+ id ,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    horas:horas,
                    descricao :descricao,
                },
                success:function(data){
                    console.log(data);
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

        function removerDetalhe($id) {
            swal({
                title: 'Confirmar Exclusão da Atividade?',
                //text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-detalhe-orcamento/'+$id,
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

        function converteremProjeto(id){
            $.ajax({
                type:'post',
                url:'/criar-projeto/'+ id ,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success:function(data){
                    console.log(data);
                    swal({
                        title: data.msg,
                        // text: 'Do you want to continue',
                        type: data.tipo,
                        timer: 2000
                    });

                    //location.reload();

                }
            });
        }

    </script>



    <div class="container">
        <br>
        <h4>Atividades Previstas</h4>
        <button onclick="adicionaratividadeModal()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped"  id="projetoodettable">
            <thead>
            <tr>
                <th class="text-center">Sigla</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Horas Reais</th>
                <th class="text-center">Estimadas</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projetodetalhesquery as $projetodet)
                <tr class="item{{$projetodet->id}}">
                    <td>{{$projetodet->sigla}}</td>
                    <td>{{$projetodet->nome}}</td>
                    <td>{{$projetodet->tipo}}</td>
                    <td>
                        <input id="descridettabela" type="text" class="form-control" value="{{$projetodet->horas_reais}}">
                    </td>
                    <td>
                        <input id="horasdettabela" type="text" class="form-control" value="{{$projetodet->horas_estimadas}}">
                    </td>

                    <td> <button class="edit-modal btn btn-primary" title="Atualizar"
                                 onclick="atualizarDetalhe({{$projetodet->id}})"
                                 data-toggle="modal">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>

                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerDetalhe({{$projetodet->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>


    </div>


    <!-- Modal Criar Atividade -->
    <div class="modal fade" id="modaladicionarAtividade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade para <?php echo $projeto;?></h4>
                </div>
                <div class="modal-body">
                    <label for="">Tipo de Atividade</label>
                    <select class="form-control" name="" id="tipoatividademodal">

                    </select>
                    <label for="">Descrição Adicional</label>
                    <input type="text" class="form-control" id="descatvmodal">
                    <label for="">Horas Estimadas</label>
                    <input type="text" class="form-control" id="horasestimadasmodal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="adicionarAtividadeCreate()" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



@stop
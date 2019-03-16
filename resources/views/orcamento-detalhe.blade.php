@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Orçamento: <?php echo $projeto;?></h1>
    <div class="container" >
        <div class="container collapse in" id="menutopo" >
            <div class="col-md-6">
                <label for="">Nome do Projeto</label>
                <input type="text" id="nomeprojetoheader" value="{{$projeto}}" class="form-control">
                <label for="">Cliente</label>
                <input type="text" id="clienteprojetoheader" value="{{$cliente}}" disabled class="form-control">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Mensuração</label>
                        <input type="text" id="mensuracaoprojetoheader" value="{{$mensuracaotexto}}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">Data</label>
                        <input type="date" id="dataprojetoheader" value="{{$mensuracaodata}}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Tarifa Técnica</label>
                        <input type="text" id="tecnprojetoheader" value="<?php echo "R$ ".  number_format ($tarifatecn,2);?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">Tarifa Gestão</label>
                        <input type="text" id="gestaoprojetoheader" value="<?php echo "R$ ".  number_format ($tarifagestao,2);?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="">Horas Totais</label>
                <input type="text" disabled value="<?php echo number_format ($horastotais,2);?>" class="form-control">
                <label for="">Valor</label>
                <input type="text" disabled value="<?php echo "R$ ".  number_format ($valortotal,2);?>" class="form-control">
                <br>
                <button onclick="atualizarHeader(<?php echo $idorcamentoescopo;?>)" class="btn btn-warning form-control">Atualizar Dados</button>
            </div>
            </div>
        <button data-toggle="collapse" data-target="#menutopo"><span class="glyphicon glyphicon-resize-full"></span></button>
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
            $('.classhoras').mask("999.99");
            $('#orcamentodettable').DataTable(
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
        function atualizarHeader(id) {
            var nomeprojeto = $('#nomeprojetoheader').val();
            var cliente = $('#clienteprojetoheader').val();
            var mensuracao = $('#mensuracaoprojetoheader').val();
            var dataproj = $('#dataprojetoheader').val();
            var tecn = $('#tecnprojetoheader').val();
            var gestao = $('#gestaoprojetoheader').val();


            if(nomeprojeto =="" ||cliente==""||mensuracao==""||dataproj==""||tecn==""||gestao==""){
                swal({
                    title: 'Campos Vazios',
                    text: 'Por Favor, verifique se todos os campos foram preenchidos',
                    type:'warning',
                    timer: 2000
                });
            }else{
                $.ajax({
                    type:'post',
                    url:'/atualizar-orcamento-escopo/'+ id ,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nomeprojeto :nomeprojeto,
                        cliente : cliente,
                        mensuracao :mensuracao,
                        dataproj : dataproj,
                        tecn:tecn,
                        gestao :gestao

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

        function adicionaratividadeModal() {
            $("#modaladicionarAtividade").modal('toggle');
        }

        function adicionargrupoModal() {
            $("#modaladicionarGrupo").modal('toggle');
        }

        function adicionarAtividadeCreate(){

            var atvid = $('#tipoatividademodal').val();
            var descricao =  $('#descatvmodal').val();
            var horasestimadas =  $('#horasestimadasmodal').val();



            if(horasestimadas == "" || descricao=="" ){
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
                        escopoid:{{$idorcamentoescopo}},
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

        function adicionarGrupoCreate(idescopo){

            var blocoid = $('#tipoGrupomodal').val();

                $.ajax({
                    type:'POST',
                    url:"/adicionar-grupo-atividades-bloco",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        escopoid:idescopo,
                        blocoid :blocoid
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




        function atualizarDetalhe(id) {
            var descricao =  $('#'+id+'descridettabela').val();
            var horas =  $('#'+id+'horasdettabela').val();

            //alert(descricao+"-"+horas);
            if(descricao=="" ||horas==0.0 ){
                swal({
                    title: "Campo Vazio ou Zerado",
                    // text: 'Do you want to continue',
                    type: "warning",
                    timer: 2000
                });
            }else{
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

            var inputs = new Array();

            var campos = 0;
            $('.table input').each(function()
            {
                if($(this).val() == 0.0 || ""){
                    campos = campos+1;
                }
            });

            if(campos >0){
                swal({
                    title: "Campos não Preenchidos",
                    text: 'Por favor, verifique se todos os campos foram preenchidos e se as horas não estão com valores iguais a zero',
                    type: 'error',
                    timer: 4000
                });
            }else{
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

        }
        function salvardadostabela(){
            var itens =  [];

            $('#orcamentodettable tbody tr').each(function(index,tr){


                var obj = {
                    id:$(this).find(".classid").val(),
                    desc:$(this).find(".classdescricao").val(),
                    horas:$(this).find(".classhoras").val()
                };


                itens.push(obj);

            });

            console.log(itens);
            $.ajax({
                type:'post',
                url:'/salvar-dados',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    itens:itens
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

    </script>



    <div class="container">
        <br>
        <button onclick="adicionaratividadeModal()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Atividade</button>
        <button onclick="adicionargrupoModal()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Grupo de Atividade</button>


        <br><br>

        <table class="table table-striped"  id="orcamentodettable">
            <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Sigla</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Descrição</th>
                <th class="text-center">Horas</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($atividades as $atv)
                <tr class="item{{$atv->id}}">
                    <td><input disabled size="3" class="text-center classid" value="{{$atv->id}}"></td>
                    <td>{{$atv->sigla}}</td>
                    <td>{{$atv->descricao}}</td>
                    <td>{{$atv->tipo}}</td>
                    <td>
                        <input id="{{$atv->id}}descridettabela" type="text" class="form-control classdescricao" value="{{$atv->descricao}}">
                    </td>
                    <td>
                        <input id="{{$atv->id}}horasdettabela" type="text" class="form-control classhoras" value="<?php echo number_format ($atv->horas_estimadas,2);?>">
                    </td>

                    <td>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerDetalhe({{$atv->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>
        <button onclick="converteremProjeto(<?php echo $idorcamentoescopo?>)" class="btn btn-success" <?php
                if($status==1){
                    echo "disabled";
                }
                ?>> Converter em Projeto</button>
        <button class="btn btn-success" onclick="salvardadostabela()"> <span  class="glyphicon glyphicon-save"></span>Salvar Dados da Tabela</button></a>


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
                        @foreach($tiposatividade as $tpatv)
                            <option value="{{$tpatv->id}}">{{$tpatv->descricao}}</option>
                            @endforeach
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



    <!-- Modal Criar Grupo -->
    <div class="modal fade" id="modaladicionarGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade para <?php echo $projeto;?></h4>
                </div>
                <div class="modal-body">
                    <label for="">Grupo de Atividade</label>
                    <select class="form-control" name="" id="tipoGrupomodal">
                        @foreach($blocosatividades as $blocos)
                            <option value="{{$blocos->id}}">{{$blocos->nomegrupo}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="adicionarGrupoCreate({{$idorcamentoescopo}})" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



@stop
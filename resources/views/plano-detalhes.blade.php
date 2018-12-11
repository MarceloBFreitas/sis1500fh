@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')


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
        function addenvolvidos(){
           var iduser = $('#usersenvmodal').val();
           var idpdet =  $('#idpdetmodaladd').val();
            $.ajax({
                type:'POST',
                url:"/registrar-envolvido",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    iduser:iduser,
                    idpdet:idpdet
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
        function addatividade() {
            var gestao = $('#valorgestao').val();
            var tecn = $('#valortecn').val();
            gestao = gestao.replace('R$ ','');
            gestao = gestao.replace(',','.');

            tecn = tecn.replace('R$ ','');
            tecn = tecn.replace(',','.');

            if(gestao <= 0 || tecn<=0){
                swal({
                    title: 'Valores das Tarifas não Definidos',
                     text: 'Por favor, defina os valores das Tarifas de Gestão e Técnicas',
                    type: 'error',
                    timer: 2000
                });
            }else{
                $("#modaladicionarAtividade").modal('toggle');
            }

        }

        function addatividadeplano($id) {
            var userid = $('#iduser').val();
            var atvid = $('#idatividade').val();
            var horasestimadas = $('#horasestimadas').val();


            if(horasestimadas ==""){
                swal({
                    title: 'Estimativa de Horas não definida',
                    text: 'Por favor, defina os valores da estimativa de horas da atividade',
                    type: 'error',
                    timer: 2000
                });
            }else{
                $.ajax({
                    type:'POST',
                    url:"/registrar-atividade/"+$id,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        userid:userid,
                        atvid:atvid,
                        horasestimadas:horasestimadas
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
                title: 'Confirmar Exclusão da Atividade?',
                text: 'Os registros relacionados a esta atividade também serão removidos',
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

        function adicionarEnvolvido(idatividade,idplano) {

            $("#idpdetmodaladd").val(idatividade);

            $('#modaladicionarEnvolvido').modal('toggle')
        }

        function removerenvolvidobt($idenvol) {

            $.ajax({
                type: 'post',
                url: "/excluir-envolvido",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    id: $idenvol,

                },
                success: function (data) {
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

        function editaratvdet($idatv){

           $.ajax({
                type:'get',
                url:"/editar-atividade/"+$idatv, //arrumar a rota para busar envolvidos,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success:function(data){
                    console.log(data);
                    var selectbox = $('#empresa');
                    var listaenvmodal = $('#listaenvmodal');
                    var atvid ;
                    var horas;
                    var  idplanodet;
                    $.each(data.envolvidos, function(i, v){
                        console.log(data.envolvidos);
                        listaenvmodal.append('<li class="ex">'+data.envolvidos[i].name+ ' <button  onclick="removerenvolvidobt('+data.envolvidos[i].idplanenvolvido +')" class= "btn btn-danger"><span class="glyphicon glyphicon-minus"></span></button></li>');
                       // atvid = data.envolvidos[i].atvid;
                        horas = data.envolvidos[i].horasestimadas;
                        idplanodet = data.envolvidos[i].idpdet;
                    })
                   // $('#idatv').val(atvid);
                    $('#horaest').val(horas);
                    $('#idpdet').val(idplanodet);
                    horaest
                    $('#idatvdetmodal').val(atvid);
                    $('#modalEdita').modal('toggle');



                }
            });

        }
        function fecha() {

         location.reload();
        }
        function salvarTarifa($id) {

            var gestao = $('#valorgestao').val();
            var tecn = $('#valortecn').val();
            gestao = gestao.replace('R$ ','');
            gestao = gestao.replace(',','.');

            tecn = tecn.replace('R$ ','');
            tecn = tecn.replace(',','.');

            if(gestao <= 0 || tecn<=0){
                swal({
                    title: 'Valores das Tarifas não Definidos',
                    text: 'Por favor, defina os valores das Tarifas de Gestão e Técnicas',
                    type: 'error',
                    timer: 2000
                });
            }else{
                console.log($id);
                $.ajax({
                    type:'POST',
                    url:'/registrar-tarifa/'+$id,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        gestao:gestao,
                        tecn:tecn
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
        function addorc(idplan,val) {

            console.log(idplan+'/'+val);
            $.ajax({
                type:'Post',
                async:false,
                url:"/Registrar-orcamento", //arrumar a rota para busar envolvidos,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },

                data:{
                    idplanos:idplan,
                    val:val
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

        function editaAtividadePlano() {

          var idplanodet =  $("#idpdet").val();
          var horasestimadas =  $("#horaest").val();
          var iddaatv = $("#idatvdetmodal").val();


            $.ajax({
                type:'POST',
                url:'/editar-atividade',        // rota do controlador p
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    idpdet:idplanodet,
                    he:horasestimadas,
                    idatv:iddaatv
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
    </script>



    <div class="container">

    <div class="row cabecalhodet">
        <div class="col-md-4">
            <label for="">Projeto - <?php if($status==0){echo "Orçamento";}else{echo "Planejamento";}?></label>
            <h2>{{$nomeprojeto}}</h2>
            <p><b>Cliente:</b> {{$nomefantasia}}</p>
            <p><b>Objetivo:</b> {{$objetivo}}</p>
            <p><b>Data Início:</b> <?php
                $dat = explode('-',$datainicio);
                echo $dat[2]."/".$dat[1]."/".$dat[0];
                ?></p>
            <p><b>Horas Registradas:</b> {{$horasreais}} h</p>
            <p><b>Horas para Finaização:</b> {{$horasfim}} h</p>

        </div>

        <div class="col-md-4">
            <?php
            if(!empty($envolvidos)){ ?>
                <h3>Envolvidos</h3>
           <?php } ?>
            <hr>
            <ul>
                @foreach($envolvidos as $envolvido)

                <li>
                    <span class="glyphicon glyphicon-user"></span> {{$envolvido->name}} -
                    <?php if($envolvido->nivelacesso == '3'){echo "Consultor";}else{ echo  "Gestão";} ?>
                </li>
                @endforeach
            </ul>
                <hr>
            <b>Custo de Horas dos Envolvidos</b>
                <h4 >R$ <?php echo number_format($custogeral,2,',','')?></h4>

        </div>
        <div class="col-md-4">
            <h3>Tarifas</h3>
            <label for="">Gestão</label>
            <input type="text" id="valorgestao" class="form-control" value="R$ <?php echo number_format($gestao,2,',','')?>"  placeholder="Digite o Valor da Tarifa do Gerente">
            <label for="">Técnica</label>
            <input type="text" id="valortecn" class="form-control" value="R$ <?php echo number_format($tecn,2,',','')?>" placeholder="Digite o Valor da Tarifa do Consultor">
       <button onclick="salvarTarifa({{$idplano}})" class="btn btn-default">Salvar</button>
            <br>
            <b>Valor</b>
            <h4 class="btn-success">R$ <?php echo number_format($valor,2,',','')?></h4>
        </div>

    </div>

        <br>

        <button onclick="addatividade()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar Atividade</button>

        <br><br>
        <table class="table table-striped" style="text-align: center" id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Responsável</th>
                <th class="text-center">Horas Reais</th>
                <th class="text-center">Estimadas</th>
                <th class="text-center">Registros</th>
            </tr>
            </thead>
            <tbody>
            @foreach($atividades as $atividade)
                <tr class="item{{$atividade->atvid}}">
                    <td>{{$atividade->pdetid}}</td>
                    <td>{{$atividade->sigla}}</td>
                    <td>{{$atividade->name}}</td>
                    <td>{{$atividade->horas_reais}}</td>
                    <td>{{$atividade->horas_estimadas}}</td>
                    <td>
                        <button onclick="adicionarEnvolvido({{$atividade->pdetid}},{{$idplano}})"
                                class="edit-modal btn btn-primary" title="Adicionar Pessoa" data-toggle="modal">
                            <span class="glyphicon glyphicon-user"></span>
                        </button>
                        <button class="edit-modal btn btn-default"  onclick="editaratvdet({{$atividade->id}})" >
                                <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerAtividade({{$atividade->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>



        <hr>
        <a href="/planos"><button class="btn btn-default">Voltar</button></a>
        <a href="/planos"><button class="btn btn-warning ">Atualizar Orçamento</button></a>
        <a href="/planos"><button class="btn btn-primary ">Salvar Baseline</button></a>
        <button class="btn btn-info " onclick="addorc({{$idplano}},{{$valor}})">Gerar Orçamento</button>
        <?php if($status==0){?>
            <a href="/planos"><button class="btn btn-success">Concluir Planejamento</button></a>
        <?php }else{?>
        <a href="/planos"><button class="btn btn-danger">Finalizar</button></a>
        <?php }?>

    </div>







    <!-- Modal Criar Atividades -->
    <div class="modal fade" id="modaladicionarAtividade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade ao Plano</h4>
                </div>
                <div class="modal-body">

                    <label>Selecione o Responsável</label>
                    <select id="iduser" name="iduser" class="form-control" id="nomeconsultor">
                        @foreach($responsaveis as $responsavel)

                            <option value="{{$responsavel->id}}">{{$responsavel->name}}</option>
                        @endforeach
                    </select>

                    <label>Selecione a Atividade</label>
                    <select id="idatividade" name="iduser" class="form-control" id="nomeconsultor">
                        @foreach($atividadesgeral as $atividade)

                            <option value="{{$atividade->id}}">{{$atividade->nome}}</option>
                        @endforeach
                    </select>
                    <label for="">Horas Estimadas</label>
                    <input type="text"  id="horasestimadas" class="form-control" placeholder="Estimativa de Horas">

                </div>
                <div class="modal-footer">
                    <button type="button"onclick = "editaratvdet()"  class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="addatividadeplano({{$idplano}})" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



    <!-- Modal Adicionar Envolvido  -->
    <div class="modal fade" id="modaladicionarEnvolvido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade ao Plano</h4>
                </div>
                <div class="modal-body">
                    <label for="">Selecione o Usuário</label>
                    <select name="" id="usersenvmodal">
                        @foreach($usuarios as $u)
                            <option value="{{$u->id}}">{{$u->name}} - <?php if($u->nivelacesso ==3){ echo "Consultor";}else{echo "Gerênte";}?></option>
                            @endforeach
                    </select>
                    <input type="hidden" id="idpdetmodaladd">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="addenvolvidos()" class="btn btn-primary">Adicionar Pessoa</button>
                    @endif

                </div>
            </div>
        </div>
    </div>





    <!-- Modal Editar Atividades -->
    <div class="modal fade" id="modalEdita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Atividade do Plano</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="iddoedita">
                    <input type="hidden" id="idpdet">
                    <input type="hidden" id="horaest">
                    <input type="hidden" id="idatv">
                    <label>Envolvidos nesta Atividades</label>

                    <ul id="listaenvmodal">

                    </ul>


                    <label>Selecione a Atividade</label>
                    <select id="idatvdetmodal" name="iduser" class="form-control" id="nomeconsultor">
                        @foreach($atividadesgeral as $atividade)

                            <option value="{{$atividade->id}}" >{{$atividade->nome}}</option>
                        @endforeach
                    </select>

                    <label for="">Horas Estimadas</label>
                    <input type="text"  id="horasestimadase" class="form-control" placeholder="Estimativa de Horas">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="fecha()" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="editaAtividadePlano()" class="btn btn-primary">Salvar Alterações</button>
                    @endif

                </div>
            </div>
        </div>
    </div>




@stop
@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')


    <?php

    function formatadata($data){
        if($data==""){
            return " / / ";
        }else{
            $dataar = explode('-',$data);
            return $dataar[2]."/".$dataar[1]."/".$dataar[0];
        }

    }
    ?>

    <h1><i class="glyphicon glyphicon-check"></i> Projeto {{$projeto->projeto}}</h1>
    <div class="container" >
        <div class="container collapse in" id="menutopo" >
            <div class="col-md-6">
                <label for="">Gestor do Projeto</label>
                <select name="" id="gestorselectheader" class="form-control">
                    <?php
                    if(empty($projeto->id_gestor)){
                    ?>
                    <option value="" selected>Nenhum Gestor Selecionado</option>
                    <?php } ?>
                    @foreach($gestores as $gestor)
                        <option
                            <?php if($projeto->id_gestor == $gestor->gest_id){echo "selected";}?>
                            value="{{$gestor->gest_id}}">{{$gestor->name}}</option>
                    @endforeach
                </select>
                <label for="">Nome do Projeto</label>
                <input type="text" id="nomeprojetoheader" value="{{$projeto->projeto}}" class="form-control">
                <label for="">Cliente</label>
                <input type="text" id="clienteprojetoheader" value="{{$projeto->cliente}}" class="form-control">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Mensuração</label>
                        <input type="text" id="mensuracaotextoprojetoheader" value="{{$projeto->mensuracao_descricao}}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">Data</label>
                        <input type="date" id="mensuracaodataprojetoheader" value="{{$projeto->mensuracao_data}}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Tarifa Técnica</label>
                        <input type="text" id="tarifatecnprojetoheader" value="<?php echo 'R$ '.number_format($projeto->tecn,2);?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">Tarifa Gestão</label>
                        <input type="text" id="tarifagestaoprojetoheader" value="<?php echo 'R$ '.number_format($projeto->gestao,2);?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="">Execuções Ordenadas: <?php
                    if(empty($projeto->planejado) || 0){
                        echo "Não";
                    }else{
                        echo "Sim";
                    }
                    ?></label> <br>
                <span>* Caso não haja ordenação, a excução considerada será pela data de inclusão na programação</span><br>
                <div class="col-md-6">
                    <label for="">Horas Totais Planejadas</label>
                    <input type="text" disabled value="<?php echo $projeto->horas_totais + $projeto->horas_estimadas;?>" class="form-control">
                    <label for="">Horas Fim</label>
                    <input type="text" disabled value="{{$projeto->horas_fim}}" class="form-control">
                    <label for="">Custo</label>
                    <input type="text" disabled value="<?php echo 'R$ '.number_format($projeto->custo_total,2);?>" class="form-control">
                    <label for="">Valor Real</label>
                    <input type="text" disabled value="<?php echo 'R$ '.number_format($projeto->valor_total,2);?>" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="">Horas Planejadas</label>
                    <input type="text" disabled value="{{$projeto->horas_estimadas}}" class="form-control">
                    <label for="">Horas Registradas</label>
                    <input type="text" disabled value="<?php echo $projeto->horas_totais;?>" class="form-control">

                    <label for="">Valor Planejado</label>
                    <input type="text" disabled value="<?php echo 'R$ '.number_format($projeto->valor_planejado,2);?>" class="form-control">
                </div>

                <div class="col-md-12" style="margin-top: 3%">

                    <button onclick="atualizarHeader(<?php echo $projeto->id;?>)" class="btn btn-success form-control">Atualizar Dados</button>
                </div>


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
        var contador = 0;
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

            $('#divgeraltabela').css('display','none');


            $('#projetoodettablefiltrada').DataTable(
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

        function explosao(idprojeto){
            $('#modalloading').modal('toggle');
            $.ajax({
                type:'POST',
                url:"/explosao/"+idprojeto,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success:function(data){
                    $('#modalloading').modal('toggle');
                    console.log(data);

                    if(data.tipo=='error'){
                        swal({
                            title: data.msg,
                            // text: 'Do you want to continue',
                            type: data.tipo,
                            timer: 8000
                        });
                    }else{
                        swal({
                            title: data.msg,
                            // text: 'Do you want to continue',
                            type: data.tipo,
                            timer: 8000
                        });
                        location.reload();
                    }

                }
            });
        }


        function visualizarTabeacheia(){
            if(contador==0){
                $('#divgeraltabela').css('display','inline');
                $('#divfiltradatabela').css('display','none');
                $('#btvisualizarhorasfim').html('<i class="glyphicon glyphicon-eye-open"></i> Ocultar Finalizadas');
                contador++;
            }else{
                $('#btvisualizarhorasfim').html(' <i class="glyphicon glyphicon-eye-close"></i> Visualizar Finalizadas');
                $('#divgeraltabela').css('display','none');
                $('#divfiltradatabela').css('display','inline');
                contador = 0;
            }

        }
        function atualizarHeader(id) {
            var nomeprojeto = $('#nomeprojetoheader').val();
            var cliente = $('#clienteprojetoheader').val();
            var mensuracaotexto = $('#mensuracaotextoprojetoheader').val();
            var mensuracaodata = $('#mensuracaodataprojetoheader').val();
            var tecn = $('#tarifatecnprojetoheader').val();
            var gestao = $('#tarifagestaoprojetoheader').val();
            var gerente = $('#gestorselectheader').val();

            if(nomeprojeto=="" || cliente=="" ||mensuracaotexto=="" || mensuracaodata=="" || gerente==""){
                swal({
                    title: "Campos não preenchidos",
                    text: "Por favor, verifique se todos os campos foram preenchidos",
                    type: 'warning',
                    timer: 2000
                });
            }else{
                $.ajax({
                    type:'POST',
                    url:"/atualiza-projeto-header/"+id,
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        nomeprojeto : nomeprojeto,
                        cliente : cliente,
                        mensuracaotexto : mensuracaotexto,
                        mensuracaodata : mensuracaodata,
                        tecn : tecn,
                        gestao : gestao,
                        gerente:gerente
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
        function vincularResponsavel($idprojeto){
            $("#modalAtribuirAtividade").modal('toggle');
            $("#idoprojetodetalhemodal").val($idprojeto);
        }
        function adicionarAtividadeCreate(idprojeto){

            var atvid = $('#tipoatividademodal').val();
            var descricao =  $('#descatvmodal').val();
            var horasestimadas =  $('#horasestimadasmodal').val();

            console.log(atvid+"-"+descricao+"-"+horasestimadas);


            if(horasestimadas == "" ||descricao=="" || atvid==""){
                swal({
                    title: "Campos não preenchidos",
                    text: "Por favor, verifique se todos os campos foram preenchidos",
                    type: 'warning',
                    timer: 2000
                });
            }else{

                $.ajax({
                    type:'POST',
                    url:"/adicionar-atividade-projeto-detalhe",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        idprojeto:idprojeto,
                        atvid :atvid,
                        descricao:descricao,
                        horasestimadas :horasestimadas,
                        respmodal:$('#respmodal').val(),
                        predmodal:$('#predmodal').val()
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
        function atualizarDetalheprojeto(id) {
            var horasestimadas =  $('#'+id+'horasesttabela').val();
            var horasfim =  $('#'+id+'horafimtabela').val();
            var tarefas = $('#'+id+'tarefapred').val();


            console.log(horasfim+"-"+horasestimadas)
            if(horasestimadas =="" || horasestimadas == "" || horasestimadas =="0.0" || horasestimadas=="0,0" ){
                swal({
                    title: "Campos Vazios ou Inválidos",
                    // text: 'Do you want to continue',
                    type: 'warning',
                    timer: 2000
                });
            }else{
                swal({
                    title: 'Confirmar Alteração da Atividade?',
                    //text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type:'put',
                            url:'/atualizar-detalhe-projeto',
                            data:{
                                _token : "<?php echo csrf_token() ?>",
                                idprojetodetalhe:id,
                                horasestimadas:horasestimadas,
                                horasfim:horasfim,
                                tarefas:tarefas

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
        }
        function removerprojetoDetalhe(id) {
            var horasestimadas =  $('#'+id+'horasesttabela').val();
            swal({
                title: 'Confirmar Exclusão da Atividade?',
                //text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                   if(horasestimadas > 0){
                       swal({
                           title: "Operação Inválida",
                           text: "Atividades Com Registros de Horas já cadastrados, Não poderão ser excluidas",
                           type: 'warning',
                           timer: 4000
                       });
                   }else{

                    $.ajax({
                        type:'DELETE',
                        url:'/excluir-detalhe-projeto/'+id,
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
                   }


                } else if (result.dismiss === swal.DismissReason.cancel) {

                }
            })
        }
        function __atribuirAtividadeUser(){
            var idprodet = $('#idoprojetodetalhe').val();
            var iduser =  $('#idoprojetodetalhemodal').val();
            alert(idprodet+"-"+iduser)

        }
        function ModaltirarFoto() {
            var today = new Date();
            var dy = today.getDate();
            var mt = today.getMonth()+1;
            var yr = today.getFullYear();
            console.log(yr+"-"+mt+"-"+dy);
            //$('#datafotomodal').val(yr+"-"+mt+"-"+dy);
            $("#modalfoto").modal('toggle');
        }
        function atribuirAtividadeUser() {
            var idprodet = $('#idoprojetodetalhemodal').val();
            var iduser =  $('#useridmodalid').val();

            if(iduser=="" || idprodet==""){
                swal({
                    title: "Erro JS",
                    //text: 'Do you want to continue',
                    type: 'error',
                    timer: 2000
                });
            }else{
                $.ajax({
                    type:'post',
                    url:'/definir-responsavel',
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        idprodet:idprodet,
                        iduser:iduser
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
        function tirarFoto(id){


            swal({
                title: 'Confirmar Registro da Foto?',
                text: 'Caso exista uma foto registrada para esse dia, ela será substituida, senão uma foto será criada',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        type:'POST',
                        url:'/criar-foto/'+ id ,
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        data:{
                            datafoto: $('#datafotomodal').val()
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


                } else if (result.dismiss === swal.DismissReason.cancel) {

                }
            })
        }
        function adicionarbase(id){
            $.ajax({
                type:'post',
                url:'/criar-baseline',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:id
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
        function alterarbase(id) {
            swal({
                title: 'Confirmar Alteração da Baseline?',
                //text: 'Os projetos em que ele estiver envolvido também serão removidos, para desligamento de colaborador procure a guia Desligamento',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        type:'post',
                        url:'/alterar-baseline',
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        data:{
                            id:id
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


                } else if (result.dismiss === swal.DismissReason.cancel) {

                }
            })

        }
        function fimprojeto(id) {

            swal({
                title: 'Confirmar finalização do Projeto?',
                text: ' Caso confirme a finalização, causara impactos nos envolvidos uma vez finalizado não aparecera atividades nos registros de hora desse projeto, Deseja continuar?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({

                        type:'post',
                        url:'/finaliza',
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        data:{
                            id:id
                        },
                        success:function(data){
                            swal({
                                title: data.msg,
                                // text: 'Do you want to continue',
                                type: data.tipo,
                                timer: 2000
                            });
                            console.log(data);
                            //location.reload();
                        }
                    });
                } else if (result.dismiss === swal.DismissReason.cancel) {

                }
            })
        }

        function adddataini(id){
            var data =  $('#'+id+'datainicialfil').val();


            $.ajax({
                type:'post',
                url:'/adddatainicial',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    data:data,
                    id:id
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
        function adddatainisemfiltro(id){
            var data =  $('#'+id+'datainicial').val();


            $.ajax({
                type:'post',
                url:'/adddatainicialsemfiltro',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    data:data,
                    id:id
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

        function salvasemfiltro(){
            var itens =  [];

            $('#projetoodettable tbody tr').each(function(index,tr){


                var obj = {
                    id:$(this).find(".idprodder").val(),
                    pred:$(this).find(".predecessora").val(),
                    dataini:$(this).find(".dataini").val(),
                    idenvolvido:$(this).find(".func").val(),
                    hestima:$(this).find(".hestima").val(),
                    hfim:$(this).find(".hfim").val()
                };


                itens.push(obj);

            });

            console.log(itens);
            $.ajax({
                type:'post',
                url:'/atualiza-atv',
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

                    location.reload();


                }
            });



        }

        function salvacomfiltro(){
            var itens = [];

            $('#projetoodettablefiltrada tbody tr').each(function(index,tr){


                var obj = {
                    id:$(this).find(".idfiltro").val(),
                    pred :$(this).find(".predfiltro").val(),
                    dataini:$(this).find(".datainifiltro").val(),
                    idenvolvido:$(this).find(".funcfiltro").val(),
                    hestima:$(this).find(".hestimafiltro").val(),
                    hfim:$(this).find(".hfimfiltro").val()

                };


                itens.push(obj);

            });


            console.log(itens);


            $.ajax({
                type:'post',
                url:'/atualiza-atv',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    itens:itens
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

    </script>
    <div class="container">

        <h4>Atividades Previstas</h4>
        <button onclick="adicionaratividadeModal()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
        <button onclick="visualizarTabeacheia()" id="btvisualizarhorasfim" class="btn btn-primary"><i class="glyphicon glyphicon-eye-close"></i> Visualizar Finalizadas</button>


        <br><br>

        <div id="divfiltradatabela">
            <table class="table table-striped"  id="projetoodettablefiltrada">
                <thead>
                <tr>
                    <th class="text-center">Atividade</th>
                    <th class="text-center">Descrição</th>
                    <th class="text-center">Predecessora(s)</th>
                    <th class="text-center">Data inicial</th>
                    <th class="text-center">Data Fim</th>
                    <th class="text-center">Responsável</th>
                    <th class="text-center">Horas Reais</th>
                    <th class="text-center">Estimadas</th>
                    <th class="text-center">Horas Fim</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projetodetalhesfiltradahorasfimquery as $projetodet)
                    <tr class="item{{$projetodet->id_projetodetalhe}}">
                        <td  class="text-center">
                            <input disabled class="text-center idfiltro "  value="{{$projetodet->id_projetodetalhe}}"  id="{{$projetodet->id_projetodetalhe}}filtro" size="5">
                        </td>

                        <td  class="text-center">

                            {{$projetodet->descri}}</td>
                        <td  class="text-center">

                            <input type="text"  class="text-center predfiltro" value="{{$projetodet->predecessora}}" id="{{$projetodet->id_projetodetalhe}}tarefapred" size="5" placeholder="Tarefa(s)"><br>
                        </td>
                        <td>
                            <input type="date" class="text-center datainifiltro" id="{{$projetodet->id_projetodetalhe}}datainicialfil" value="{{$projetodet->data_inicio}}">
                        </td>
                        <td>
                            <input type="text" class="text-center datainifiltro" id="{{$projetodet->id_projetodetalhe}}datainicialfil" size="7" disabled value="<?=formatadata($projetodet->data_fim)?>">
                        </td>
                        <td  class="text-center">
                            <div class="form-group">
                                <select class="form-control funcfiltro" id="sel1">
                                    <?php
                                    if(empty($projetodet->id_responsavel)){
                                    ?>

                                    <option selected value="" >Adicionar envolvido</option>
                                    <?php } ?>
                                    @foreach($usuarios as $usuario)
                                        <option <?php if($projetodet->id_responsavel == $usuario->id){echo "selected";}?>
                                                value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td  class="text-center">
                            {{$projetodet->horas_reais}}
                        </td>
                        <td  class="text-center">
                            <input size="5" class="text-center hestimafiltro" id="{{$projetodet->id_projetodetalhe}}horasesttabela" type="text" class="form-control" value="{{$projetodet->horas_estimadas_det}}">
                        </td>
                        <td  class="text-center">
                            <input size="5" class="text-center hfimfiltro" id="{{$projetodet->id_projetodetalhe}}horafimtabela" type="text" class="form-control" value="{{$projetodet->horas_fim_det}}">
                        </td>


                        <td>
                            <button class="delete-modal btn btn-danger" title="Remover"
                                    onclick="removerprojetoDetalhe({{$projetodet->id_projetodetalhe}})">
                                <span  class="glyphicon glyphicon-trash"></span>
                            </button>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </br></br>
            <a href="#"><button onclick="salvacomfiltro()" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Salvar Dados Alterados</button></a>
            </br></br>
        </div>

        <div id="divgeraltabela">
            <table class="table table-striped"  id="projetoodettable">
                <thead>
                <tr>
                    <th class="text-center">Atividade</th>
                    <th class="text-center">Descrição</th>
                    <th class="text-center">Predecessora(s)</th>
                    <th class="text-center">Data inicial</th>
                    <th class="text-center">Data Fim</th>
                    <th class="text-center">Responsável</th>
                    <th class="text-center">Horas Reais</th>
                    <th class="text-center">Estimadas</th>
                    <th class="text-center">Horas Fim</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projetodetalhesquery as $projetodet)
                    <tr class="item{{$projetodet->id_projetodetalhe}}">
                        <td  class="text-center">
                            <input disabled class="text-center idprodder"  value="{{$projetodet->id_projetodetalhe}}"  id="{{$projetodet->id_projetodetalhe}}filtro" size="5" > </input>
                        </td>

                        <td  class="text-center">

                            {{$projetodet->descri}}</td>
                        <td  class="text-center">

                            <input type="text" class="text-center predecessora" value="{{$projetodet->predecessora}}" id="{{$projetodet->id_projetodetalhe}}tarefapred" size="5" placeholder="Tarefa(s)"><br>
                        </td>
                        <td>
                            <input type="date" class="text-center dataini" id="{{$projetodet->id_projetodetalhe}}datainicial" value="{{$projetodet->data_inicio}}" >
                        </td>

                        <td>
                            <input type="text" class="text-center dataini" id="{{$projetodet->id_projetodetalhe}}datafim" size="7" disabled value="<?=formatadata($projetodet->data_fim)?>" >
                        </td>

                        <td  class="text-center">
                            <div class="form-group">
                                <select class="form-control func" id="sel1">
                                    <?php
                                    if(empty($projetodet->id_responsavel)){

                                    ?>

                                    <option selected value="">Adicionar envolvido</option>
                                    <?php } ?>
                                    @foreach($usuarios as $usuario)
                                        <option <?php if($projetodet->id_responsavel == $usuario->id){echo "selected";}?>
                                                value="{{$usuario->id}}">{{$usuario->name}}</option>





                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td  class="text-center">
                            {{$projetodet->horas_reais}}
                        </td>
                        <td  class="text-center">
                            <input size="5" class="text-center hestima" id="{{$projetodet->id_projetodetalhe}}horasesttabela" type="text" class="form-control" value="{{$projetodet->horas_estimadas_det}}">
                        </td>
                        <td  class="text-center">
                            <input size="5" class="text-center hfim " id="{{$projetodet->id_projetodetalhe}}horafimtabela" type="text" class="form-control" value="{{$projetodet->horas_fim_det}}">
                        </td>


                        <td>
                            <button class="delete-modal btn btn-danger" title="Remover"
                                    onclick="removerprojetoDetalhe({{$projetodet->id_projetodetalhe}})">
                                <span  class="glyphicon glyphicon-trash"></span>
                            </button>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </br></br>
            <a href="#"><button onclick="salvasemfiltro()" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> # Salvar Dados Alterados</button></a>
            </br></br>
        </div>





        <a href="/"><button class="btn btn-default">Voltar</button></a>

        <?php if($flag > 0){ ?>
        <button onclick="alterarbase({{$projeto->id}})" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Alterar baseline</button>
        <a href="/view-baseline/{{$projeto->id}}"><button class="btn btn-warning"><span class="glyphicon glyphicon-list-alt"></span> Visualizar Baseline</button></a>
        <?php
        } else{ ?>
        <button onclick="adicionarbase({{$projeto->id}})" class="btn btn-primary"><span class="glyphicon glyphicon-saved"></span> Salvar baseline</button>
        <?php }
        ?>





        <a href="#"><button onclick="explosao({{$projeto->id}})" class="btn btn-success"><span class="glyphicon glyphicon-calendar"></span> Programar Atividades</button></a>
        <a href="#"><button onclick="ModaltirarFoto()" class="btn btn-info"><span class="glyphicon glyphicon-camera"></span> Tirar Foto</button></a>
        <a href="/fotos-projeto/{{$projeto->id}}"><button  class="btn btn-default"><span class="glyphicon glyphicon-picture"></span> Fotos do Projeto</button></a>
        <?php if($projeto->status == 'execucao'){ ?>
        <button  class="btn btn-danger" onclick="fimprojeto({{$projeto->id}})" >Finalizar Projeto <span class="glyphicon glyphicon-check"></span></button>
        <?php } ?>



    </div>


    <!-- Modal Criar Atividade -->
    <div class="modal fade" id="modaladicionarAtividade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade para <?php echo $projeto->projeto;?></h4>
                </div>
                <div class="modal-body">
                    <label for="">Tipo de Atividade</label>
                    <select class="form-control" name="" id="tipoatividademodal">
                        @foreach($tiposatividade as $tpatv)
                            <option value="{{$tpatv->id}}">{{$tpatv->nome}}</option>
                        @endforeach
                    </select>

                    <label for="">Responsável</label>
                    <select class="form-control func" id="respmodal">
                        <option selected value="" >Adicionar envolvido</option>
                        @foreach($usuarios as $usuario)
                            <option <?php if($projetodet->id_responsavel == $usuario->id){echo "selected";}?>
                                    value="{{$usuario->id}}">{{$usuario->name}}</option>
                             @endforeach
                    </select>

                    <label for="">Definir Predecessora</label>
                    <select class="form-control func" id="predmodal">
                        <option selected value="" >Atividade Inicial</option>
                        @foreach($projetodetalhesfiltradahorasfimquery as $pdfq)
                            <option
                                    value="{{$pdfq->id}}">{{$pdfq->id}} - {{$pdfq->descri}}</option>
                        @endforeach
                    </select>



                    <label for="">Descrição Adicional</label>
                    <input type="text" class="form-control" id="descatvmodal">
                    <label for="">Horas Estimadas</label>
                    <input type="text" class="form-control" id="horasestimadasmodal">
                    <label for="">Data de inicio</label>
                    <input class="form-control"  type="date" id="inidata">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="adicionarAtividadeCreate(<?php echo $projeto->id;?>)" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



    <!-- Modal Foto -->
    <div class="modal fade" id="modalfoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Definir data da foto: <?php echo $projeto->projeto;?></h4>
                </div>
                <div class="modal-body">
                    <span>Selecione a Data da Foto</span>
                    <input type="date" id="datafotomodal" value="<?php echo date('Y-m-d');?>" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="tirarFoto(<?php echo $projeto->id;?>)" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Atribuir Atividades -->
    <div class="modal fade" id="modalAtribuirAtividade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Atividade para <?php echo $projeto->projeto;?></h4>
                </div>
                <div class="modal-body">
                    <label for="">Selecione o Responsável pela Atividade</label>
                    <select class="form-control" name="" id="useridmodalid">
                        @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="idoprojetodetalhemodal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="atribuirAtividadeUser()" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>




    <!-- Modal loading -->
    <div class="modal fade" id="modalloading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: rgba(10,23,55,0.5) !important;">

                <img class="center-block" src="{{asset('img/ajax-loader.gif')}}" alt="">
                <h3 class="text-center" style="color: #ffffff !important;">Processando...</h3>

            </div>
        </div>
    </div>


@stop
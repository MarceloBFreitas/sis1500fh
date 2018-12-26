@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')
    <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Atenção </strong><br>Estes dados são referentes a uma Instância do Projeto.
    </div>
    <h1><i class="glyphicon glyphicon-check"></i> Projeto {{$foto->projeto}}</h1>
    <div class="container" >
        <div class="container collapse in" id="menutopo" >
            <div class="col-md-6">
                <label for="">Gestor do Projeto</label>
                <input type="text" class="form-control" value="{{$gestores}}" disabled>

               <label for="">Nome do Projeto</label>
                <input type="text" id="nomeprojetoheader" value="{{$foto->projeto}}" class="form-control">
                <label for="">Cliente</label>
                <input type="text" id="clienteprojetoheader" value="{{$foto->cliente}}" class="form-control">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Mensuração</label>
                        <input type="text" id="mensuracaotextoprojetoheader" value="{{$foto->mensuracao_descricao}}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">Data</label>
                        <input type="date" id="mensuracaodataprojetoheader" value="{{$foto->mensuracao_data}}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Tarifa Técnica</label>
                        <input type="text" id="tarifatecnprojetoheader" value="<?php echo 'R$ '.number_format($foto->tecn,2);?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="">Tarifa Gestão</label>
                        <input type="text" id="tarifagestaoprojetoheader" value="<?php echo 'R$ '.number_format($foto->gestao,2);?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="">Execuções Ordenadas: <?php
                    if(empty($foto->planejado) || 0){
                        echo "Não";
                    }else{
                        echo "Sim";
                    }
                    ?></label> <br>
                <span>* Caso não haja ordenação, a excução considerada será pela data de inclusão na programação</span><br>


                <div class="col-md-6">
                    <label for="">Horas Totais Planejadas</label>
                    <input type="text" disabled value="<?php echo $foto->horas_totais + $foto->horas_estimadas;?>" class="form-control">
                    <label for="">Horas Fim</label>
                    <input type="text" disabled value="{{$foto->horas_fim}}" class="form-control">
                    <label for="">Custo</label>
                    <input type="text" disabled value="<?php echo 'R$ '.number_format($foto->custo_total,2);?>" class="form-control">
                    <label for="">Valor Real</label>
                    <input type="text" disabled value="<?php echo 'R$ '.number_format($foto->valor_total,2);?>" class="form-control">




                </div>

                <div class="col-md-6">
                    <label for="">Horas Planejadas</label>
                    <input type="text" disabled value="{{$foto->horas_estimadas}}" class="form-control">
                    <label for="">Horas Registradas</label>
                    <input type="text" disabled value="<?php echo $foto->horas_totais;?>" class="form-control">

                    <label for="">Valor Planejado</label>
                    <input type="text" disabled value="<?php echo 'R$ '.number_format($foto->valor_planejado,2);?>" class="form-control">
                </div>






                <div class="col-md-6" style="margin-top: 3%">
                    <button onclick="atualizarHeader(<?php echo $foto->id;?>)" class="btn btn-success form-control">Converter em Projeto</button>
                </div>
                <div class="col-md-6" style="margin-top: 3%">
                    <button onclick="" class="btn btn-danger form-control">Criar Nova Versão do Projeto</button>
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

        function removerprojetoDetalhe($id) {
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
                        url:'/excluir-detalhe-projeto/'+$id,
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


        function __atribuirAtividadeUser(){
            var idprodet = $('#idoprojetodetalhe').val();
            var iduser =  $('#idoprojetodetalhemodal').val();
            alert(idprodet+"-"+iduser)

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
            $.ajax({
                type:'POST',
                url:'/criar-foto/'+ id ,
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

                    location.reload();

                }
            });
        }

    </script>



    <div class="container">



        <table class="table table-striped"  id="projetoodettable">
            <thead>
            <tr>
                <th class="text-center">Sigla</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Predecessora(s)</th>
                <th class="text-center">Responsável</th>
                <th class="text-center">Horas Reais</th>
                <th class="text-center">Estimadas</th>
                <th class="text-center">Horas Fim</th>

            </tr>
            </thead>
            <tbody>
            @foreach($detalhesfoto as $projetodet)
                <tr class="item{{$projetodet->id_fotodet}}">
                    <td  class="text-center">
                        {{$projetodet->sigla}}<br>
                        {{$projetodet->tipo}}
                    </td>

                    <td  class="text-center">
                        <strong>ID:</strong>{{$projetodet->id_fotodet}}<br>
                        {{$projetodet->descricao}}</td>
                    <td  class="text-center">

                        <input type="text"  value="{{$projetodet->predecessora}}" id="{{$projetodet->id_fotodet}}tarefapred" size="10" placeholder="Tarefa(s)"><br>
                    </td>
                    <td  class="text-center">
                        <?php
                        if(empty($projetodet->id_responsavel)){
                            echo '<span class="glyphicon btn-danger glyphicon-exclamation-sign"></span> N/C';
                        }else{
                            echo $projetodet->name;
                        }
                        ?>
                    </td>
                    <td  class="text-center">
                        {{$projetodet->horas_reais}}
                    </td>
                    <td  class="text-center">
                        <input size="6" id="{{$projetodet->id_fotodet}}horasesttabela" type="text" class="form-control" value="{{$projetodet->horas_estimadas}}">
                    </td>
                    <td  class="text-center">
                        <input size="6" id="{{$projetodet->id_fotodet}}horafimtabela" type="text" class="form-control" value="{{$projetodet->horas_fim}}">
                    </td>



                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>



    </div>





@stop
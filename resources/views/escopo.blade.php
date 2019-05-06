@extends('adminlte::page')

@section('title', 'Validação do Projeto')

@section('content_header')



@stop

@section('content')

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
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#validaobj').DataTable(
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

        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#gestaoprodutividade').DataTable(
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


        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#pencli').DataTable(
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
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#validorca').DataTable(
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
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#validadata').DataTable(
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


        function trastipo(id) {

            console.log(id);

            $.ajax({
                type:'POST',
                url:"/trastipo",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:id,

                },
                success:function(data){
                    $('#idtipo').val(data.tipo);
                    $('#idestima').val(data.estima);
                    $('#hfim').val(data.hfim);
                    console.log(data);
                }
            });

        }
        function trasitenspendencia(id) {



            $.ajax({
                type:'POST',
                url:"/trasitens",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:id,

                },
                success:function(data){
                    $('#iddatainiciopendencia').val(data.datainicio);
                    $('#iddatafimpendencia').val(data.datafim);


                }
            });

        }
        function add(id) {
          var cli =  $('#cli').val();
            var estima =    $('#idestima').val();
            var projeto = $('#proj').val();
            var hfim = $('#hfim').val();
            var dia =  $('#iddia').val();
            var tipo = $('#idtipo').val();
            var  idatv = $('#sel1').val();
            var status =  $('#status').val();
            var desc = $('#iddesc').val();
            var tema = $('#tema').val();
            var idprojeto = id;

            $.ajax({
                type:'POST',
                url:"/add",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cli:cli,
                    dia:dia,
                    estima:estima,
                    desc:desc,
                    hfim:hfim,
                    idprojeto:idprojeto,
                    tema:tema,
                    status:status,
                    idatv:idatv,
                    tipo:tipo,
                    projeto:projeto
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
        function chamaescopo() {
            $("#modalescopo").modal('toggle');
        }
        function chamaprod() {

            $("#modalprod").modal('toggle');

        }
        function chamapendencias() {
            $("#modalPendencias").modal('toggle');
        }
        function chamadata() {
            $("#modaldatas").modal('toggle');

        }
        function chamaobj() {
            modalobjetivo
            $("#modalobjetivo").modal('toggle');
        }
        function addorca() {
            $("#modalorca").modal('toggle')
        }
        function addprod($id) {

            var cliente =  $('#cliprod').val();
            var projeto =  $id;
            var horas_plan =  $('#planprod').val();
            var horas_projeto =  $('#realprod').val();
            var data =  $('#diaprod').val();
            var tema =  $('#temaprod').val();
            var status =  $('#statusprod').val();
            var comentario =  $('#iddescprod').val();

            $.ajax({
                type:'POST',
                url:"/addprodutividade",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cliente:cliente,
                    projeto:projeto,
                    horas_plan:horas_plan,
                    horas_projeto:horas_projeto,
                    data:data,
                    tema:tema,
                    status:status,
                    comentario:comentario

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

        function adddata($id){
            var cliente =  $('#clidata').val();
            var projeto =  $id;
            var database =  $('#datafimbaseline').val();
            var datareal =  $('#datafimatual').val();
            var datafoto =  $('#datafimfoto').val();
            var data =  $('#diadata').val();
            var tema =  $('#temadata').val();
            var status =  $('#statusdata').val();
            var comentario =  $('#iddescdata').val();

            $.ajax({
                type:'POST',
                url:"/adddata",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cliente:cliente,
                    projeto:projeto,
                    database:database,
                    datareal:datareal,
                    datafoto:datafoto,
                    data:data,
                    tema:tema,
                    status:status,
                    comentario:comentario

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
        function addpendencia($id) {
            var cliente =  $('#clipen').val();
            var projeto =  $id;
            var datainicio =  $('#iddatainiciopendencia').val();
            var datafim =  $('#iddatafimpendencia').val();
            var tipo =  $('#idtipo').val();
            var data =  $('#iddiapen').val();
            var tema =  $('#temapen').val();
            var status =  $('#statuspen').val();
            var comentario =  $('#iddescpen').val();
            var atv =  $('#sel1pen').val();

            $.ajax({
                type:'POST',
                url:"/addpen",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cliente:cliente,
                    tipo:tipo,
                    datafim:datafim,
                    datainicio:datainicio,
                    projeto:projeto,
                    data:data,
                    tema:tema,
                    status:status,
                    atvdet:atv,
                    comentario:comentario

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
        function addorcamentos(id) {
            var cliente =  $('#cliorc').val();
            var projeto =  id;
            var valorbase =  $('#valorbaseorc').val();
            var valorfoto =  $('#valorfotoorc').val();
            var valortotal =  $('#valoratualorc').val();

            var data =  $('#diaorc').val();
            var tema =  $('#temaorc').val();
            var status =  $('#statusorc').val();
            var comentario =  $('#iddescorc').val();
            console.log('wwwwww');

            $.ajax({
                type:'POST',
                url:"/addorc",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cliente:cliente,

                    valorbase:valorbase,
                    valorfoto:valorfoto,
                    valoratual:valortotal,
                    projeto:projeto,
                    data:data,
                    tema:tema,
                    status:status,
                    comentario:comentario

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
        function addobj(id) {
            var cliente =  $('#cliobj').val();
            var projeto =  id;

            var resultado =  $('#resulobj').val();

            var data =  $('#diaobj').val();
            var tema =  $('#temaobj').val();
            var status =  $('#statusobj').val();
            var comentario =  $('#comentobj').val();
            var mensuracaodata =  $('#mendata').val();
            var mensuracao =  $('#mendesc').val();


            $.ajax({
                type:'POST',
                url:"/objetivoadd",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cliente:cliente,
                    mensuracaodata:mensuracaodata,
                    mensuracao:mensuracao,
                    resultado:resultado,
                    projeto:projeto,
                    data:data,
                    tema:tema,
                    status:status,
                    comentario:comentario

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




    <h3>Validação de Objetivo</h3><br>
    <?php if( $alertavalidacao->objetivo==1) { ?>
    <button onclick="chamaobj()" class="btn btn-danger glyphicon-check"> Adicionar Validação</button>
    <?php } else { ?>

    <button onclick="chamaobj()" class="btn btn-success glyphicon-check"> Adicionar Validação</button>
    <?php } ?>
    <table class="table table-striped"  id="validaobj">
        <thead>
        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Resultado</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Descrição</th>
            <th class="text-center">Dia</th>
        </tr>
        </thead>
        <tbody>
        @foreach($validaobj as $obj)
            <tr>
                <td class="text-center">{{$obj->cliente}}</td>
                <td class="text-center">{{$projeto->projeto}}</td>
                <td class="text-center">{{$obj->resultado}}</td>
                <td class="text-center">{{$obj->status}}</td>
                <td class="text-center">{{$obj->tema}}</td>
                <td class="text-center">{{$obj->comentario}}</td>
                <td class="text-center">{{$obj->data}}</td>


            </tr>
        @endforeach
        </tbody>
    </table><br><br><br><br>



    <h3>Validação de Datas</h3><br>
        <?php if( $alertavalidacao->data==1) { ?>
        <button onclick="chamadata()" class="btn btn-danger glyphicon-check"> Adicionar Validação</button>
        <?php } else { ?>

        <button onclick="chamadata()" class="btn btn-success glyphicon-check"> Adicionar Validação</button>
        <?php } ?>
    <table class="table table-striped"  id="validadata">
        <thead>
        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Data Fim Baseline</th>
            <th class="text-center">Data Fim Atual</th>
            <th class="text-center">Data Foto</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Descrição</th>
            <th class="text-center">Dia</th>
        </tr>
        </thead>

        <tbody>
        @foreach($validadata as $vd)
            <tr>
                <td class="text-center">{{$vd->cliente}}</td>
                <td class="text-center">{{$projeto->projeto}}</td>
                <td class="text-center">{{$vd->data_fim_base}}</td>
                <td class="text-center">{{$vd->data_fim_atual}}</td>
                <td class="text-center">{{$vd->fim_semana}}</td>
                <td class="text-center">{{$vd->status}}</td>
                <td class="text-center">{{$vd->tema}}</td>
                <td class="text-center">{{$vd->comentario}}</td>
                <td class="text-center">{{$vd->data}}</td>

            </tr>
        @endforeach
        </tbody>
    </table><br><br><br><br>


    <h3>Gestão De Escopo</h3><br>
        <?php if( $alertavalidacao->escopo==1) { ?>
        <button onclick="chamaescopo()" class="btn btn-danger glyphicon-check"> Adicionar Validação</button>
        <?php } else { ?>

        <button onclick="chamaescopo()" class="btn btn-success glyphicon-check"> Adicionar Validação</button>
        <?php } ?>
    <table class="table table-striped"  id="projetosdettable">
        <thead>
        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Atividade</th>
            <th class="text-center">Horas Planejadas</th>
            <th class="text-center">Horas fim</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Descrição</th>
            <th class="text-center">Dia</th>
        </tr>
        </thead>
        <tbody>
        @foreach($escopo as $es)
            <tr>
                <td>{{$es->cliente}}</td>
                <td>{{$projeto->projeto}}</td>
                <td>{{$es->descricao}}</td>
                <td>{{$es->horas_plan}}</td>
                <td>{{$es->horas_fim}}</td>
                <td>{{$es->status}}</td>
                <td>{{$es->tema}}</td>
                <td>{{$es->comentario}}</td>
                <td>{{$es->data}}</td>

            </tr>
        @endforeach
        </tbody>
    </table><br><br><br><br>

    <h3>Gestão de Produtividade</h3><br>

        <?php if( $alertavalidacao->produtividade==1) { ?>
        <button onclick="chamaprod()" class="btn btn-danger glyphicon-check"> Adicionar Validação</button>
        <?php } else { ?>

        <button onclick="chamaprod()" class="btn btn-success glyphicon-check"> Adicionar Validação</button>
        <?php } ?>
    <table class="table table-striped"  id="gestaoprodutividade">
        <thead>

        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Horas Planejadas</th>
            <th class="text-center">Horas do Projeto</th>
            <th class="text-center">Dia</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Comentario</th>
            <th class="text-center">Status</th>

        </tr>

        </thead>
        <tbody>
        @foreach($produtividade as $prod)
            <tr>
                <td class="text-center">{{$prod->cli}}</td>
                <td class="text-center">{{$prod->projeto}}</td>
                <td class="text-center">{{$prod->horas_plan}}</td>
                <td class="text-center">{{$prod->horas_projeto}}</td>
                <td class="text-center">{{$prod->data}}</td>
                <td class="text-center">{{$prod->tema}}</td>
                <td class="text-center">{{$prod->comentario}} </td>
                <td class="text-center">{{$prod->status}}</td>


            </tr>
        @endforeach
        </tbody>
    </table> <br><br><br><br>



    <h3>Pendências de Cliente</h3><br>
        <?php if( $alertavalidacao->pendencias==1) { ?>
        <button onclick="chamapendencias()" class="btn btn-danger glyphicon-check"> Adicionar Validação</button>
        <?php } else { ?>

        <button onclick="chamapendencias()" class="btn btn-success glyphicon-check"> Adicionar Validação</button>
        <?php } ?>
    <table class="table table-striped"  id="pencli">
        <thead>
        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Atividade</th>
            <th class="text-center">Data Inicio</th>
            <th class="text-center">Data fim</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Comentario</th>
            <th class="text-center">Dia</th>
        </tr>
        </thead>
        <tbody>
        @foreach($validapendencia as $pen)
        <tr>
            <td class="text-center">{{$pen->cliente}}</td>
            <td class="text-center">{{$projeto->projeto}}</td>
            <td class="text-center">{{$pen->descricao}}</td>
            <td class="text-center">{{$pen->data_inicio}}</td>
            <td class="text-center">{{$pen->data_fim}}</td>
            <td class="text-center">{{$pen->status}}</td>
            <td class="text-center">{{$pen->tema}}</td>
            <td class="text-center">{{$pen->comentario}}</td>
            <td class="text-center">{{$pen->data}}</td>

        </tr>
@endforeach
        </tbody>
    </table><br><br><br><br>


    <h3>Validação de Orçamento</h3><br>
        <?php if( $alertavalidacao->orcamento==1) { ?>
        <button onclick="addorca()" class="btn btn-danger glyphicon-check"> Adicionar Validação</button>
        <?php } else { ?>

        <button onclick="addorca()" class="btn btn-success glyphicon-check"> Adicionar Validação</button>
        <?php } ?>
    <table class="table table-striped"  id="validorca">
        <thead>
        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Valor Baseline</th>
            <th class="text-center">Valor Foto</th>
            <th class="text-center">Valor Atual</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Descrição</th>
            <th class="text-center">Dia</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orcamentos as $or)
        <tr>
            <td class="text-center">{{$or->cliente}}</td>
            <td class="text-center">{{$projeto->projeto}}</td>
            <td class="text-center">{{$or->valor_base}}</td>
            <td class="text-center">{{$or->valor_foto}}</td>
            <td class="text-center">{{$or->valor_Atual}}</td>
            <td class="text-center">{{$or->status}}</td>
            <td class="text-center">{{$or->tema}}</td>
            <td class="text-center">{{$or->comentario}}</td>
            <td class="text-center">{{$or->data}}</td>


        </tr>
    @endforeach
        </tbody>
    </table><br><br><br><br>









</div>



    <!-- Modal validação de escopo -->
    <div class="modal fade" id="modalescopo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="cli" >
                        <label for="comment">Horas Planejadas:</label><input class="form-control" value="" type="text" disabled  id="idestima" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Projeto</label> <input class="form-control" value="{{$projeto->projeto}}" type="text" disabled  id="proj" >
                        <label for="comment">Horas Para Fim:</label><input class="form-control" value="" type="text" disabled  id="hfim" >

                    </div>
                    <div class="col-md-6">
                        <label for="comment">Dia</label><input class="form-control" type="date" id="iddia" size="5" >
                        <label for="comment">Tipo Atividade</label><input  value="" disabled class="form-control" type="Text" id="idtipo" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Atividade</label>
                        <select class="form-control funcfiltro"  onchange="trastipo(this.value);" id="sel1">


                            <option selected >Adicionar Atividade</option>

                            @foreach($pdet as $pd)
                                <?php if($pd->situacao == 'Mudança de escopo'){ ?>
                                <option
                                        value="{{$pd->id}}" id="e{{$pd->id}}e">{{$pd->descricao}}</option>
                                <?php } ?>
                            @endforeach
                        </select>
                        <label for="comment">Status</label>
                        <select class="form-control funcfiltro" id="status">


                            <option selected value="" >Adicionar Status</option>
                            <option>Pendente</option>
                            <option>Finalizado</option>

                        </select>

                        <label for="comment">Tema</label>
                        <select class="form-control funcfiltro" id="tema">


                            <option>Produtividade</option>
                            <option>Objetivo</option>
                            <option>Atraso</option>
                            <option>Pendencia cliente</option>
                            <option>Orçamento</option>
                            <option selected>Mudança Escopo</option>

                        </select>

                    </div>
                    <label for="comment">Comentatio</label> <textarea class="form-control" rows="5" id="iddesc"></textarea>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="add({{$projeto->id}})" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- Modal validação produtividade -->
    <div class="modal fade" id="modalprod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="cliprod" >
                        <label for="comment">Projeto:</label><input class="form-control" value="{{$projeto->projeto}}" type="text" disabled  id="projetoprod" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Horas Planejadas</label> <input class="form-control" value="{{$projeto->horas_estimadas}}" type="text" disabled  id="planprod" >
                        <label for="comment">Horas do Projeto:</label><input class="form-control" value="{{$projeto->horas_totais}}" type="text" disabled  id="realprod" >

                    </div>
                    <div class="col-md-6">
                        <label for="comment">Dia</label><input class="form-control" type="date" id="diaprod" size="5" >



                    </div>
                    <div class="col-md-6"><br>
                        <label for="comment">Tema</label>
                        <select class="form-control funcfiltro" id="temaprod">



                            <option selected>Produtividade</option>
                            <option>Objetivo</option>
                            <option>Atraso</option>
                            <option>Pendencia cliente</option>
                            <option>Orçamento</option>
                            <option>Mudança Escopo</option>

                        </select>

                        <label for="comment">Status</label>
                        <select class="form-control funcfiltro" id="statusprod">


                            <option selected value="" >Adicionar Status</option>
                            <option>Pendente</option>
                            <option>Finalizado</option>

                        </select>
                    </div>


                    <label for="comment">Comentatio</label>
                    <textarea class="form-control" rows="5" id="iddescprod"></textarea>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="addprod({{$projeto->id}})" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal validação Orcamento -->
    <div class="modal fade" id="modalorca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar  Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="cliorc" >
                        <label for="comment">Projeto:</label><input class="form-control" value="{{$projeto->projeto}}" type="text" disabled  id="projetoorc" >
                        <label for="comment">Dia</label><input class="form-control" type="date" id="diaorc" size="5" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Valor Baseline</label> <input class="form-control" value="{{$valorbase}}" type="text" disabled  id="valorbaseorc" >
                        <label for="comment">Valor Foto</label><input class="form-control" value="{{$valorfoto}}" type="text" disabled  id="valorfotoorc" >
                        <label for="comment">Valor Atual</label><input class="form-control" value="{{$projeto->valor_total}}" type="text" disabled  id="valoratualorc" >

                    </div>
                    <div class="col-md-6">
                        <label for="comment">Tema</label>
                        <select class="form-control funcfiltro" id="temaorc">



                            <option>Produtividade</option>
                            <option>Objetivo</option>
                            <option>Atraso</option>
                            <option>Pendencia cliente</option>
                            <option selected>Orçamento</option>
                            <option>Mudança Escopo</option>

                        </select>

                    </div>
                    <div class="col-md-6"><br>


                        <label for="comment">Status</label>
                        <select class="form-control funcfiltro" id="statusorc">


                            <option selected value="" >Adicionar Status</option>
                            <option>Pendente</option>
                            <option>Finalizado</option>

                        </select>
                    </div>


                    <label for="comment">Comentatio</label>
                    <textarea class="form-control" rows="5" id="iddescorc"></textarea>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="addorcamentos({{$projeto->id}})" class="btn btn-primary">Adicionar Validação</button>
                    @endif

                </div>
            </div>
        </div>
    </div>



    <!-- Modal validação de datas do projeto -->
    <div class="modal fade" id="modaldatas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="clidata" >
                        <label for="comment">Projeto:</label><input class="form-control" value="{{$projeto->projeto}}" type="text" disabled  id="projetodata" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Data fim Atual do Projeto</label> <input class="form-control" value="{{$datafimatual}}" type="text" disabled  id="datafimatual" >
                        <label for="comment">Data fim Baseline</label><input class="form-control" value="{{$datafimbase}}" type="text" disabled  id="datafimbaseline" >
                        <label for="comment">Data fim Semana Passada</label><input class="form-control" value="{{$datafimfoto}}" type="text" disabled  id="datafimfoto" >

                    </div>
                    <div class="col-md-6">
                        <label for="comment">Dia</label><input class="form-control" type="date" id="diadata" size="5" >



                    </div>
                    <div class="col-md-6"><br>
                        <label for="comment">Tema</label>
                        <select class="form-control funcfiltro" id="temadata">



                            <option>Produtividade</option>
                            <option>Objetivo</option>
                            <option selected>Atraso</option>
                            <option>Pendencia cliente</option>
                            <option>Orçamento</option>
                            <option>Mudança Escopo</option>

                        </select>

                        <label for="comment">Status</label>
                        <select class="form-control funcfiltro" id="statusdata">


                            <option selected value="" >Adicionar Status</option>
                            <option>Pendente</option>
                            <option>Finalizado</option>

                        </select>
                    </div>


                    <label for="comment">Comentatio</label>
                    <textarea class="form-control" rows="5" id="iddescdata"></textarea>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="adddata({{$projeto->id}})" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- Modal validação pendencias do cliente -->
    <div class="modal fade" id="modalPendencias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="clipen" >
                        <label for="comment">Data inicio:</label><input class="form-control" value="" type="date" disabled  id="iddatainiciopendencia" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Projeto</label> <input class="form-control"  value="{{$projeto->projeto}}" type="text" disabled  id="proj" >
                        <label for="comment">Data Fim:</label><input class="form-control" value="" type="date" disabled  id="iddatafimpendencia" >

                    </div>
                    <div class="col-md-6">
                        <label for="comment">Dia</label><input class="form-control" type="date" id="iddiapen" size="5" >
                        <label for="comment">Tipo Atividade</label><input  value="Pendencia Cliente" disabled class="form-control" type="Text" id="idtipo" >
                    </div>
                    <div class="col-md-6">
                        <label for="comment">Atividade</label>
                        <select class="form-control funcfiltro"  onchange="trasitenspendencia(this.value);" id="sel1pen">


                            <option selected >Adicionar Atividade</option>

                            @foreach($pdet as $pd)
                                <?php if($pd->situacao == 'Atraso do Cliente'){ ?>
                                <option
                                        value="{{$pd->id}}" id="e{{$pd->id}}e">{{$pd->descricao}}</option>
                                <?php } ?>{{$pd->id}}
                            @endforeach
                        </select>
                        <label for="comment">Status</label>
                        <select class="form-control funcfiltro" id="statuspen">


                            <option selected value="" >Adicionar Status</option>
                            <option>Pendente</option>
                            <option>Finalizado</option>

                        </select>

                        <label for="comment">Tema</label>
                        <select class="form-control funcfiltro" id="temapen">



                            <option>Produtividade</option>
                            <option>Objetivo</option>
                            <option>Atraso</option>
                            <option selected>Pendencia cliente</option>
                            <option>Orçamento</option>
                            <option>Mudança Escopo</option>

                        </select>

                    </div>
                    <label for="comment">Comentatio</label> <textarea class="form-control" rows="5" id="iddescpen"></textarea>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="addpendencia({{$projeto->id}})" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal validação Objetivo -->
    <div class="modal fade" id="modalobjetivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Adicionar Validação</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="cliobj" >
                        <label for="comment">Projeto</label> <input class="form-control"  value="{{$projeto->projeto}}" type="text" disabled  id="proj" >
                        <label for="comment">Data Mensuração</label> <input class="form-control"  value="{{$projeto->mensuracao_data}}" type="text" disabled  id="mendata" >

                    </div>
                    <div class="col-md-6">


                        <label for="comment">Status</label>
                        <select class="form-control funcfiltro" id="statusobj">


                            <option selected value="" >Adicionar Status</option>
                            <option>Pendente</option>
                            <option>Finalizado</option>

                        </select>
                        <label for="comment">Mensuração</label> <input class="form-control"  value="{{$projeto->mensuracao_descricao}}" type="text" disabled  id="mendesc" >

                        <label for="comment">Tema</label>
                        <select class="form-control funcfiltro" id="temaobj">


                            <option>Produtividade</option>
                            <option selected>Objetivo</option>
                            <option>Atraso</option>
                            <option >Pendencia cliente</option>
                            <option>Orçamento</option>
                            <option>Mudança Escopo</option>

                        </select>
                        <label for="comment">Dia</label><input class="form-control " type="date" id="diaobj" size="5" >

                    </div>
                    <div class="col-md-6">


                    </div>
                    <div class="col-md-6">


                    </div>
                    <label for="comment">Resultado</label><input  value=""  class="form-control" type="Text" id="resulobj" >
                    <label for="comment">Comentatio</label> <textarea class="form-control" rows="5" id="comentobj"></textarea>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="addobj({{$projeto->id}})" class="btn btn-primary">Adicionar</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

@stop
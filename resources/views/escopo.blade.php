@extends('adminlte::page')

@section('title', 'Validação do Projeto')

@section('content_header')

    <h1>Gestão De Escopo</h1><br>
    <div class="container">
        

        <button onclick="chamaescopo()" class="btn-success glyphicon-check"> Adicionar Validação</button>


        <div class="container">


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
                        <td>{{$es->id_atv_det}}</td>
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

        </div>





    </div>
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
        function chamadata() {
            $("#modaldatas").modal('toggle');

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

    </script>

<div class="container">

    <h3>Gestão de Produtividade</h3><br>

    <button onclick="chamaprod()" class="btn-success glyphicon-check"> Adicionar Validação</button>
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


    <h3>Validação de Datas</h3><br>
    <button onclick="chamadata()" class="btn-success glyphicon-check"> Adicionar Validação</button>
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



    <h3>Pendências de Cliente</h3><br>
    <button onclick="" class="btn-success glyphicon-check"> Adicionar Validação</button>
    <table class="table table-striped"  id="pencli">
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

        <tr>
            <td>BIC</td>
            <td>Assistente Virtual</td>
            <td>Criar BOOT</td>
            <td>20</td>
            <td>Horas Reais</td>
            <td>data </td>
            <td>tema</td>
            <td>Comentario</td>
            <td>status</td>

        </tr>

        </tbody>
    </table><br><br><br><br>


    <h3>Validação de Orçamento</h3><br>
    <button onclick="" class="btn-success glyphicon-check"> Adicionar Validação</button>
    <table class="table table-striped"  id="validorca">
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

        <tr>
            <td>BIC</td>
            <td>Assistente Virtual</td>
            <td>Criar BOOT</td>
            <td>20</td>
            <td>Horas Reais</td>
            <td>data </td>
            <td>tema</td>
            <td>Comentario</td>
            <td>status</td>

        </tr>

        </tbody>
    </table><br><br><br><br>



    <h3>Validação de Objetivo</h3><br>
    <button onclick="" class="btn-success glyphicon-check"> Adicionar Validação</button>
    <table class="table table-striped"  id="validaobj">
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

        <tr>
            <td>BIC</td>
            <td>Assistente Virtual</td>
            <td>Criar BOOT</td>
            <td>20</td>
            <td>Horas Reais</td>
            <td>data </td>
            <td>tema</td>
            <td>Comentario</td>
            <td>status</td>

        </tr>

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


                            <option selected value="" >Adicionar tema</option>
                            <option>Produtividade</option>
                            <option>Objetivo</option>
                            <option>Atraso</option>
                            <option>Pendencia cliente</option>
                            <option>Orçamento</option>
                            <option>Mudança Escopo</option>

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


                            <option selected value="" >Adicionar tema</option>
                            <option>Produtividade</option>
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


                            <option selected value="" >Adicionar tema</option>
                            <option>Produtividade</option>
                            <option>Objetivo</option>
                            <option>Atraso</option>
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


@stop
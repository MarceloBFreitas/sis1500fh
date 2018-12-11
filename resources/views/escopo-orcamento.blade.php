@extends('adminlte::page')

@section('title', 'Cadastro de Orcamento Escopo')

@section('content_header')

    <h1><i class="glyphicon glyphicon-scale"></i> Escopo Orçamento</h1>
@stop

@section('content')

    <script>

        function addescopo() {

            $("#modalEscopo").modal('toggle');

        }

        function salvaescopo(){
            var mensuracao  = $("#idmen").val();
            var cliente  = $("#idcli").val();
            var projeto  = $("#idpro").val();
            var horagestao  = $("#idhorag").val();
            var horatecnica  = $("#idhorast").val();
            var obj  = $("#idobj").val();


            $.ajax({
                type:'POST',
                url:"{{URL::route('registrar.escopo')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                   mensuracao:mensuracao,
                    cliente:cliente,
                    projeto:projeto,
                    horag:horagestao,
                    horat:horatecnica,
                    objetivo:obj,
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
        function traselemento($id) {
            $("#modalEscopoe").modal('toggle');
            $("#aux").val($id);

            $.ajax({
                type:'POST',
                url:"{{URL::route('tras.escopo')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:$id,
                },
                success:function(data){
                    console.log(data);

                    $("#idmene").val(data.mensuracao);
                    $("#idclie").val(data.cliente);
                    $("#idproe").val(data.projeto);
                    $("#idhorage").val(data.gestao);
                    $("#idhoraste").val(data.tecn);
                    $("#idobje").val(data.objetivo);





                }
            });


        }
        function edita() {

            var mensuracao = $("#idmene").val();
            var cliente = $("#idclie").val();
            var projeto = $("#idproe").val();
            var horagestao = $("#idhorage").val();
            var horatecnica = $("#idhoraste").val();
            var obj = $("#idobje").val();
            var id = $("#aux").val();


            $.ajax({
                type:'POST',
                url:"{{URL::route('edita.escopo')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    mensuracao:mensuracao,
                    cliente:cliente,
                    projeto:projeto,
                    horag:horagestao,
                    horat:horatecnica,
                    objetivo:obj,
                    id:id,
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
            location.reload();
        }
        function deleta($id){
            $.ajax({
                type:'POST',
                url:"{{URL::route('deleta.escopo')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{

                    id:$id,
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
        <input hidden  id="aux">
        <br>
        <button onclick="addescopo()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
        <br><br>

        <table class="table table-striped" style="text-align: center" id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Mensuraçã0</th>
                <th class="text-center">Hora Gestão</th>
                <th class="text-center">Hora Técnica</th>
                <th class="text-center">Objetivo</th>
                <th class="text-center">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($escopo as $es)


                    <td>{{$es->id}}</td>
                    <td>{{$es->cliente}}</td>
                    <td>{{$es->projeto}}</td>

                    <td>{{$es->mensuracao}}</td>
                    <td>{{$es->gestao}}</td>
                    <td>{{$es->tecn}}</td>
                    <td>{{$es->objetivo}}</td>



                    <td>
                        <button class="edit-modal btn btn-danger" title="Excluir"
                                data-toggle="modal" onclick="deleta({{$es->id}})">
                            <span class="glyphicon glyphicon-trash"></span>
                        </button>
                        <button class="edit-modal btn btn-info" title="Editar"
                                data-toggle="modal" onclick="traselemento({{$es->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        <a href="/orcamento-detalhe/{{$es->id}}">
                            <button class="edit-modal btn btn-default" title="Detalhes do Plano">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button></a>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>


    </div>



    <!-- Modal Criar escopo orcamento -->
    <div class="modal fade" id="modalEscopo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Criação de  Escopo</h4>
                </div>
                <div class="modal-body clientebody">

                    <div class="form-group">
                        <label for="comment">Mensuração</label><input class="form-control" type="date" id="idmen" > <br/>
                        <label for="comment">Cliente</label><input class="form-control" type="text"  id="idcli" placeholder="Nome do Cliente"> <br/>
                        <label for="comment">Projeto</label><input class="form-control" type="text" id="idpro" placeholder="Nome do Projeto"> <br/>
                        <label for="comment">Horas de Gestão</label><input class="form-control" type="text" id="idhorag" placeholder="Valor de Horas por Gestão"><br/>
                        <label for="comment">Horas Técnicas</label><input class="form-control" type="text" id="idhorast" placeholder="Valor de Horas Ténicas"> <br/>
                        <label for="comment">Objetivo:</label>
                        <textarea class="form-control" rows="5" id="idobj"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvaescopo()" class="btn btn-primary">Criar Escopo</button>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Editar escopo orcamento -->

    <div class="modal fade" id="modalEscopoe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Criação de  Escopo</h4>
                </div>
                <div class="modal-body clientebody">

                    <div class="form-group">
                        <label for="comment">Mensuração</label><input class="form-control" type="date" id="idmene" > <br/>
                        <label for="comment">Cliente</label><input class="form-control" type="text"  id="idclie" placeholder="Nome do Cliente"> <br/>
                        <label for="comment">Projeto</label><input class="form-control" type="text" id="idproe" placeholder="Nome do Projeto"> <br/>
                        <label for="comment">Horas de Gestão</label><input class="form-control" type="text" id="idhorage" placeholder="Valor de Horas por Gestão"><br/>
                        <label for="comment">Horas Técnicas</label><input class="form-control" type="text" id="idhoraste" placeholder="Valor de Horas Ténicas"> <br/>
                        <label for="comment">Objetivo:</label>
                        <textarea class="form-control" rows="5" id="idobje"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="edita()" class="btn btn-primary">Criar Escopo</button>
                    @endif

                </div>
            </div>
        </div>
    </div>












@stop
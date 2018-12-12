@extends('adminlte::page')

@section('title', 'Registro de horas')

@section('content_header')

    <h1>Registro de Horas por Atividade</h1>
@stop

@section('content')
    <script>

        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#atividadetable').DataTable(
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

        function addhoras($idoed) {

            var idod = $idoed;

            $('#help').val(idod);

            $('#adddet').modal('toggle')




        }
        function salvar(){
            var dia =  $('#iddia').val();
            var qtd  =$('#idqtd').val();
            var desc= $('#iddesc').val();
            var idod = $('#help').val();
            $.ajax({
                type:'POST',
                url:"{{URL::route('salvar.horas')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    idod:idod,
                    dia:dia,
                    qtd:qtd,
                    desc:desc,
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

<div class="row">


    <div class="container">


        <table  class="table table-striped"  id="atividadetable">
            <thead>
            <tr>
                <th class="text-center">Projeto</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Sigla</th>
                <th class="text-center">Detalhes</th>
            </tr>
            </thead>

            <tbody>
            @foreach($od as $o)
                <tr class="item">
                    <td>{{$o->id}}</td>
                    <td>@foreach($oe as $e)
                            <?php
                            if($o->id_eo == $e->id){

                                echo $e->cliente;
                            }
                            ?> @endforeach</td>
                    <td>@foreach($oe as $oee)
                            <?php
                            if($o->id_eo == $oee->id){

                                echo $oee->projeto;
                            }
                            ?> @endforeach</td>
                    <td>@foreach($atv as $t)
                            <?php
                            if($o->id_atv == $t->id){

                                echo $t->sigla;
                            }
                            ?> @endforeach</td>
                    <td>{{$o->descricao}}</td>

                    <td>


                        <button class="edit-modal btn btn-default" title="Adicionar" onclick="addhoras({{$o->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>



</div>


    <!-- Modal Adicionar Detalhes do Registro de Horas -->
    <div class="modal fade" id="adddet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Hora</h4>
            </div>
            <div class="modal-body clientebody">

                <div class="form-group">
                    <h2>Registro Detalhado:</h2>
                    <input id="help" type="hidden" value="">

                    <label for="comment">Dia</label><input class="form-control" type="date" id="iddia" > <br/>
                    <label for="comment">Quantidade de Horas</label><input class="form-control" type="Text" id="idqtd" > <br/>
                    <label for="comment">Descrição:</label>
                    <textarea class="form-control" rows="5" id="iddesc"></textarea>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                @if(Auth::user()->nivelacesso <3)
                    <button type="button" onclick="salvar()" class="btn btn-primary">Registrar Horas</button>
                @endif

            </div>
        </div>
    </div>
    </div>


@stop
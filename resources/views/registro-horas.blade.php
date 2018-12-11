@extends('adminlte::page')

@section('title', 'Registro de horas')

@section('content_header')

    <h1>Registro de Horas por Atividade</h1>
@stop

@section('content')
    <script>
        function addhoras($idoed) {

            var idod = $idoed;
            alert(idod);
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

<div class="container">
    <div style="width: 20%">

        <img src="{{ asset('img/1500-logo-completo.png') }}"  class="rounded" alt="Cinque Terre" style=" width:100%;
    margin-left:-10%;" />

    </div>
    <table class="table table-striped" style="text-align: center" id="consultortable">
        <thead>
        <tr>
            <th class="text-center">Código</th>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Sigla</th>
            <th class="text-center">Descrição</th>
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


    <!-- Modal Adicionar Detalhes do Registro de Horas -->
    <div class="modal fade" id="adddet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Criação de  Escopo</h4>
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
                    <button type="button" onclick="salvar()" class="btn btn-primary">Criar Escopo</button>
                @endif

            </div>
        </div>
    </div>
    </div>


@stop
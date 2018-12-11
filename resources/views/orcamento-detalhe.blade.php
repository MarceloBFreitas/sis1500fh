@extends('adminlte::page')

@section('title', 'Cadastro de Atividades do Orçamento')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Atividades do Orçamento</h1>
@stop

@section('content')
<script>
    function addatv() {
        $("#modalatv").modal('toggle');
    }

    function salvaatt($ideo){
      var iduser=  $("#iduser").val();
        var idoee = $ideo;
        var idatv=  $("#idatividade").val();
        var horasestimadas =  $("#horasestimadas").val();
        var desc =  $("#Descricao").val();
        $.ajax({
            type:'POST',
            url:"{{URL::route('salvar.detalhe.orcamento')}}",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            data:{

                iduser:iduser,
                idoe:idoee,
                idatv:idatv,
                horasestimadas:horasestimadas,
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
    function salvaorcamento($id) {

        $.ajax({
            type:'POST',
            url:"{{URL::route('registrar.escopo.final')}}",
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
                console.log(data);
                //location.reload();


            }
        });

    }
</script>

    <div>

        <button onclick="addatv()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
        <br><br>

        <table class="table table-striped" style="text-align: center" id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Sigla</th>
                <th class="text-center">Descrição</th>
                <th class="text-center">Horas Estimadas</th>
                <th class="text-center">Usiario</th>
                <th class="text-center">Ação</th>
            </tr>
            </thead>
            <tbody>
            @foreach($eod as $d)
                    <tr class="item{{$d->id}}">
                    <td>{{$d->id}}</td>
                    <td>@foreach($atv as $a)
                            <?php
                            if($d->id_atv == $a->id){

                                echo $a->sigla;
                            }
                            ?>
                    @endforeach
                    </td>
                    <td>{{$d->descricao}}</td>
                    <td>{{$d->horas_estimadas}}</td>
                    <td>
                        @foreach($user as $u)
                            <?php
                            if($d->id_user == $u->id){

                                echo $u->name;
                            }
                            ?>
                        @endforeach
                    </td>





                <td>
                    <button class="edit-modal btn btn-danger" title="Excluir"
                            data-toggle="modal" onclick="">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                    <button class="edit-modal btn btn-info" title="Editar"
                            data-toggle="modal" onclick="">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>

                        <button class="edit-modal btn btn-default" title="Detalhes do Plano">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                </td>

                </tr>
                @endforeach

            </tbody>
        </table>

        <button type="button" class="btn btn-default" onclick="salvaorcamento({{$eo}})">Salvar</button>
    </div>

    <div class="modal fade" id="modalatv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Criação de  Escopo</h4>
                </div>
                <div class="modal-body clientebody">

                    <label>Selecione o Responsável</label>
                    <select id="iduser" name="iduser" class="form-control" id="nomeconsultor">
                        @foreach($user as $us)

                            <option value="{{$us->id}}">{{$us->name}}</option>
                        @endforeach
                            <option value="0" selected></option>
                    </select>
                    <br/>
                    <label>Selecione a Atividade</label>
                    <select id="idatividade" name="iduser" class="form-control" >
                        @foreach($atv as $at)

                            <option value="{{$at->id}}">{{$at->sigla}}</option>
                        @endforeach
                    </select>
                    <br/>
                    <label>Descrição da Atividade</label>
                    <input type="text"  id="Descricao" class="form-control" placeholder="Descreva a Atividade">
                    <br/>
                    <label>Estimativa de Horas</label>
                    <input type="text"  id="horasestimadas" class="form-control" placeholder="Horas Estimadas">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvaatt({{$eo}})" class="btn btn-primary">Criar Atividade</button>
                    @endif




                </div>
            </div>
        </div>
    </div>


    @stop
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
            $('#atividadetablehoras').DataTable(
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

        function addhoras(id) {

            $.ajax({
                type:'POST',
               url:"{{URL::route('registrar.horasf')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    idprojetodet:id,

                },
                success:function(data){
                    console.log(data);
                    $('#adddet').modal('toggle');
                    $('#idhorasfim').val(data);
                    $('#idprodetalhe').val(id);




                }
            });






        }
        function salvar(){
            var dia =  $('#iddia').val();
            var qtd  =$('#idqtd').val();
            var desc= $('#iddesc').val();
            var horaFim = $('#idhorasfim').val();
            var id = $('#idprodetalhe').val();


            if(dia == ""){
                swal({
                    title: 'Campo vazio',
                    text: 'Por favor, verificar se todos os campos estão preenchidos',
                    type: 'warning',
                    timer: 2000
                });
            }else{


            $.ajax({
                type:'POST',
                url:"{{URL::route('salvar.horas')}}",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:id,
                    dia:dia,
                    qtd:qtd,
                    desc:desc,
                    horaFim:horaFim,
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
    </script>
<div class="container">

<div>
        <table  class="table table-striped"  id="atividadetablehoras">
            <thead>
            <tr>

                <th class="text-center">Clientes</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Horas Estimadas</th>
                <th class="text-center">Horas Fim</th>
                <th class="text-center">Ação</th>

            </tr>
            </thead>

            <tbody>
            @foreach($itensTabela as $itens)
                <tr class="item{{$itens->id}}">
                    <td>{{$itens->cliente}}</td>
                    <td>{{$itens->projeto}}</td>
                    <td>{{$itens->descricao}}</td>
                    <td>{{$itens->horas_estimadas}}</td>
                    <td>{{$itens->horas_fim}}</td>

                    <td>
                        <button class="edit-modal btn btn-default" title="Adicionar" onclick="addhoras({{$itens->id}})">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>

                        <button class="edit-modal btn btn-default" title="Vizualizar" onclick="">
                            <span class="glyphicon glyphicon-zoom-in"></span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

</div>


    <input type="hidden" id="idprodetalhe">
</div>






    <!-- Modal Adicionar Detalhes do Registro de Horas-->
    <div class="modal fade" id="adddet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Hora</h4>
            </div>
            <div class="modal-body ">

                <div class="form-group">
                    <h2>Registro Detalhado:</h2>
                    <input id="help" type="hidden" value="">

                    <label for="comment">Dia</label><input class="form-control" type="date" id="iddia" > <br/>
                    <label for="comment">Quantidade de Horas</label><input class="form-control" type="Text" id="idqtd" > <br/>
                    <label for="comment">Horas para Fim</label><input class="form-control" type="Text" id="idhorasfim" > <br/>
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
@extends('adminlte::page')

@section('title', 'Registro de horas')

@section('content_header')

    <h1>Lista com Todos os Registros Realizados  </h1>
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
        function chamamodaldet(desc) {

            $('#showdet').modal('toggle');
            $('#iddesc').val(desc);



        }

    </script>

    <div class="container">

        <table  class="table table-striped"  id="atividadetablehoras">
            <thead>
            <tr>

                <th class="text-center">Usuario</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Atividade</th>
                <th class="text-center">Dia</th>
                <th class="text-center">Horas Cadastradas</th>
                <th class="text-center">Descrição</th>


            </tr>
            </thead>

            <tbody>
                @foreach($registro as $re)
              <tr class="item{{$re->id}}">
                 <td class="text-center">{{$re->name}}</td>
                 <td class="text-center">{{$re->projeto}}</td>
                 <td class="text-center">{{$re->sigla}}</td>
                 <td class="text-center">{{$re->dia}}</td>
                 <td class="text-center">{{$re->qtd_horas}}</td>
                <td class="text-center" >
                    <button  class="edit-modal btn btn-default"  onclick="chamamodaldet('{{$re->descricaodoregistro}}')" title="Vizualizar" >
                      <span class="glyphicon glyphicon-zoom-in"></span>
                  </button>
                </td>

              </tr>
                @endforeach
            </tbody>
        </table>



    </div>


    <div class="modal fade" id="showdet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detalhes do Registro</h4>
                </div>
                <div class="modal-body ">

                    <div class="form-group">
                        <h2>Registro Detalhado:</h2>

                        <textarea class="form-control" rows="5" id="iddesc" disabled="true"></textarea>
                    </div>


                </div>

            </div>
        </div>
    </div>

@stop
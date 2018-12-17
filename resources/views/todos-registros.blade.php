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

            <tbody>$re->
                @foreach($registro as $re)
              <tr class="item{{$re->id}}">
                 <td class="text-center">{{$re->name}}</td>
                 <td class="text-center">{{$re->projeto}}</td>
                 <td class="text-center">{{$re->sigla}}</td>
                 <td class="text-center">{{$re->dia}}</td>
                 <td class="text-center">{{$re->qtd_horas}}</td>
                 <td class="text-center">{{$re->descricaodoregistro}}</td>

              </tr>
                @endforeach
            </tbody>
        </table>



    </div>

@stop
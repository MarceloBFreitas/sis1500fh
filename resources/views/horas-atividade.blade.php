@extends('adminlte::page')

@section('title', 'Horas Registradas da Atividade')

@section('content_header')

    <h1>Totais de horas da atividade</h1>
@stop

@section('content')

 <script>
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
          $('.valortable').mask("#.##0,00", {reverse: true});
            $('#tabelaregistro').DataTable(
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

        function excluir(id) {
            $.ajax({
                type:'POST',
                url:"/horas-excluir/"+id,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:id,

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

        <div class="row">

               <table  class="table table-striped"  id="tabelaregistro">
                  <thead>
                        <tr>

                            <th class="text-center">Usuario</th>
                            <th class="text-center">Horas</th>
                            <th class="text-center">Data</th>
                            <th class="text-center">Descrição</th>
                            <th class="text-center">Ação</th>

                    </tr>
                  </thead>

                    <tbody>
                        @foreach($todosRegistros as $todos)
                            <tr class="">
                                <td class="text-center">{{$todos->name}}</td>
                                <td class ="text-center">{{$todos->qtd_horas}}</td>
                                <td class="text-center">{{$todos->dia}}</td>
                                <td class="text-center">{{$todos->descricao}}</td>
                                <td class="text-center">
                                <button class="ion-android-deletebtn-danger  warning" title="Excluir" onclick="excluir({{$todos->idregistro}})">
                                  <span class="glyphicon  glyphicon-trash warning danger"></span>
                                    </button>
                                </td>
                            </tr>
                         @endforeach
                    </tbody>
             </table>

        </div>


    </div>






































@stop
@extends('adminlte::page')

@section('title', 'Validação do Projeto')

@section('content_header')

<h1>Validação</h1>
@stop

@section('content')

    <script>
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#consultortable').DataTable(
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

        function addescopo(id) {


            $.ajax({
                type:'GET',
                url:'/escopo/'+id,
                data:{
                    _token : "<?php echo csrf_token() ?>"
                },

            });


        }
    </script>
    <div class="container">


        <table class="table table-striped"  id="consultortable">
            <thead>
            <tr>

                <th class="text-center">Gestor</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Validar</th>

            </tr>
            </thead>
            <tbody>
            @foreach($projeto as $pjt)

                <tr class="">
                <td class="text-center">{{$pjt->name}}</td>
                <td class="text-center">{{$pjt->cliente}}</td>
                <td class="text-center">{{$pjt->projeto}}</td>
                <td class="text-center">
                <?php if($pjt->pendencias == 1 or $pjt->escopo == 1) { ?>
                      <a href="/escopo/{{$pjt->pjid}}">
                        <button  class="btn btn-danger"  onclick="" title="Validar este projeto" >
                            Validar este projeto
                        </button>
                    </a>
                    <?php } else { ?>

                     <a href="/escopo/{{$pjt->pjid}}">
                        <button  class="btn btn-success"  onclick="" title="Validar este projeto" >
                            Validar este projeto
                        </button>
                    </a>
                    <?php } ?>


                </td>

                </tr>
            @endforeach
            </tbody>
        </table>




    </div>









@stop
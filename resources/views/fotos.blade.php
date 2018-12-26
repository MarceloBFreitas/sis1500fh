@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-check"></i> Fotos do Projeto: {{$projeto->projeto}}</h1>
@stop

@section('content')
    <?php
    function diaSemana($data){
       switch ($data){
           case 1:
               return "Domingo";
               break;
           case 2:
               return "Segunda-Feira";
               break;
           case 3:
               return "Terça-Feira";
               break;
           case 4:
               return "Quarta-Feira";
               break;
           case 5:
               return "Quinta-Feira";
               break;
           case 6:
               return "Sexta-Feira";
               break;
           case 7:
               return "Sábado";
               break;
       }
    }

    function retornaMes($data){
       switch ($data){
           case 1:
               return "Janeiro";
               break;
           case 2:
               return "Fevereiro";
               break;
           case 3:
               return "Março";
               break;
           case 4:
               return "Abril";
               break;
           case 5:
               return "Maio";
               break;
           case 6:
               return "Junho";
               break;
           case 7:
               return "Julho";
               break;
           case 8:
               return "Agosto";
               break;
           case 9:
               return "Setembro";
               break;
           case 10:
               return "Outubro";
               break;
           case 11:
               return "Novembro";
               break;
           case 12:
               return "Dezembro";
               break;
       }
    }
    function formatarDataFront($data){
        $dataarray = explode("-",$data);
        return $dataarray[2]."/".$dataarray[1]."/".$dataarray[0];
    }
    ?>
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



    </script>



    <div class="container">

        <br><br>

        <table class="table table-striped"  id="projetosdettable">
            <thead>
            <tr>
                <th class="text-center">Cliente</th>
                <th class="text-center">Gestor</th>
                <th class="text-center">Horas</th>
                <th class="text-center">Mensuração</th>
                <th class="text-center">Foto</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($fotos as $foto)
                <tr class="item{{$foto->id}}">
                    <td class="text-center">{{$foto->cliente}}</td>
                    <td class="text-center"><?php if(empty($foto->id_gestor)){echo " - - -";}else{echo $foto->name;}?></td>
                    <td>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Estimadas: </strong><br>
                                <strong>Registradas:</strong> <br>
                                <strong>Fim:</strong>
                            </div>
                            <div class="col-md-6">
                                {{number_format($foto->horas_estimadas,2,",","")}} h<br>
                                {{number_format($foto->horas_totais,2,",","")}} h<br>
                                {{number_format($foto->horas_fim,2,",","")}} h
                            </div>
                        </div>

                    </td>
                    <td  class="text-center">
                        {{formatarDataFront($foto->mensuracao_data)}} <br>
                        {{$foto->mensuracao_descricao}}
                    </td>
                    <td  class="text-center">
                        <?php echo diaSemana($foto->dia_semana); ?><br>
                        <strong>Semana:</strong>{{$foto->semana}}<br>
                        <strong><?php echo retornaMes($foto->mes)?></strong>:{{$foto->ano}}
                    </td>

                    <td><a href="/detalhes-foto/{{$foto->id}}">
                            <button class="edit-modal btn btn-default" title="Detalhes"
                                    data-toggle="modal">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button></a>
                        <button class="delete-modal btn btn-danger" title="Remover"
                                onclick="removerAtividade({{$foto->id}})">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>




@stop
@extends('adminlte::page')

@section('title', 'Baseline')

@section('content_header')
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Atenção </strong><br>Estes dados são referentes a uma Instância Base do Projeto.
    </div>

    <h1><i class="glyphicon glyphicon-check"></i> Baseline </h1>
<div class="container">
<div class="col-lg-6">
    <h3> Cliente : {{$baseline->cliente}}</h3><br/>
    <div class="col-lg-6">
        <label> Gestor:</label><br/><input class="form-control" disabled value="@foreach($base as $b)  {{$b->name}}@endforeach"><br/>
        <label> Valor Gestão:</label><br/><input class="form-control" disabled value=" {{$baseline->gestao}}"><br/>
        <label> Valor Tecnico:</label><br/> <input class="form-control" disabled value="   {{$baseline->tecn}}"><br/>
    </div>
    <div class="col-lg-6">

        <label> Valor Total:</label><br/><input class="form-control" disabled value="    {{$baseline->valor_total}}"><br/>
        <label> Valor Planejado: </label><br/><input class="form-control" disabled value="   {{$baseline->valor_planejado}}"><br/>
        <label> Custo Total: </label><br/><input class="form-control" disabled value="  {{$baseline->custo_total}}"><br/></div>

</div>
 <div class="col-lg-6">
     <h3> Projeto: @foreach($base as $b) {{$b->projeto}}@endforeach </h3><br/>
     <div class="col-lg-6">
         <label>  Objetivo: </label><br/><input class="form-control" disabled value=" {{$baseline->objetivo}}"><br/>
         <label> Mensuração: </label><br/><input class="form-control" disabled value=" {{$baseline->munsuracao_descricao}}"><br/>
         <label>  Data Mensuração: </label><br/><input class="form-control" disabled value="  {{$baseline->mensuracao_data}}  "><br/>
     </div>

    <div class="col-lg-6">
        <label>  Horas Planejadas:</label><br/><input class="form-control" disabled value="   {{$baseline->horas_estimadas}}  "><br/>
        <label>  Horas Totais:  </label><br/><input class="form-control" disabled value="   {{$baseline->horas_totais}}  "><br/>
        <label>  Horas para fim:  </label><br/><input class="form-control" disabled value="   {{$baseline->horas_fim}} "><br/>
    </div>






 </div>
</div>



@stop

@section('content')
    <script>
        $(document).ready(function(){
            $('.datainput').mask('99/99/9999'); //Máscara para Data
            $('.valortable').mask("#.##0,00", {reverse: true});
            $('#tableATT').DataTable(
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


    <table class="table table-striped"  id="tableATT">
        <thead>
        <tr>
            <th class="text-center">Sigla</th>
            <th class="text-center">Atividade</th>
            <th class="text-center">Data Inicio</th>
            <th class="text-center">Data Fim</th>
            <th class="text-center">Responsável</th>
            <th class="text-center">Horas Reais</th>
            <th class="text-center">Estimadas</th>
            <th class="text-center">Horas Fim</th>

        </tr>
        </thead>
        <tbody>
        @foreach($basedet as $projetodet)
            <tr class="item{{$projetodet->idbase}}">
                <td  class="text-center">
                    {{$projetodet->sigla}}<br>
                    {{$projetodet->tipo}}
                </td>

                <td  class="text-center">

                    {{$projetodet->descri}}</td>
                <td  class="text-center">
                    {{$projetodet->data_inicio}}
                </td>
                <td>
                    {{$projetodet->data_fim}}
                </td>
                <td  class="text-center">
                    <?php
                    if(empty($projetodet->name)){
                        echo '<span class="glyphicon btn-danger glyphicon-exclamation-sign"></span> N/C';
                    }else{
                        echo $projetodet->name;
                    }
                    ?>
                </td>
                <td  class="text-center">
                    {{$projetodet->horas_reais}}
                </td>
                <td  class="text-center">
                    {{$projetodet->horas_estimadas}}
                </td>
                <td  class="text-center">
                    {{$projetodet->horas_fim}}
                </td>


            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="/detalhe-projeto/{{$baseline->id_projeto}}"><button class="btn btn-default">Voltar</button></a>

</div>





@stop
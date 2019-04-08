@extends('adminlte::page')

@section('title', 'Validação do Projeto')

@section('content_header')

    <h1>Validação De Escopo</h1>
    <div class="container">
        <div class="col-md-6">
            <label for="comment">Cliente</label> <input class="form-control" value="{{$projeto->cliente}}" type="text" disabled  id="cli" >
            <label for="comment">Horas Planejadas:</label><input class="form-control" value="" type="text" disabled  id="idestima" >
        </div>
        <div class="col-md-6">
            <label for="comment">Projeto</label> <input class="form-control" value="{{$projeto->projeto}}" type="text" disabled  id="proj" >
            <label for="comment">Horas Para Fim:</label><input class="form-control" value="" type="text" disabled  id="hfim" >

        </div>
        <div class="col-md-6">
            <label for="comment">Dia</label><input class="form-control" type="date" id="iddia" size="5" >
            <label for="comment">Tipo Atividade</label><input  value="" disabled class="form-control" type="Text" id="idtipo" >
        </div>
        <div class="col-md-6">
            <label for="comment">Atividade</label>
            <select class="form-control funcfiltro"  onchange="trastipo(this.value);" id="sel1">


                <option selected >Adicionar Atividade</option>

                @foreach($pdet as $pd)
                    <option
                            value="{{$pd->id}}" id="e{{$pd->id}}">{{$pd->descricao}}</option>
                @endforeach
            </select>
            <label for="comment">Status</label>
            <select class="form-control funcfiltro" id="status">


                <option selected value="" >Adicionar Status</option>
                <option>Pendente</option>
                <option>Finalizado</option>

            </select>
            <label for="comment">Tema</label><input class="form-control" value="" type="text"  id="tema" >
        </div>
        <label for="comment">Comentatio</label> <textarea class="form-control" rows="5" id="iddesc"></textarea>


        <button onclick="add({{$projeto->id}})" class="btn-success glyphicon-check"> Adicionar Validação</button>








    </div>
@stop

@section('content')

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
        function trastipo(id) {
            $.ajax({
                type:'POST',
                url:"/trastipo",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    id:id,

                },
                success:function(data){
                    $('#idtipo').val(data.tipo);
                    $('#idestima').val(data.estima);
                    $('#hfim').val(data.hfim);
                }
            });

        }
        function add(id) {
          var cli =  $('#cli').val();
            var estima =    $('#idestima').val();
            var projeto = $('#proj').val();
            var hfim = $('#hfim').val();
            var dia =  $('#iddia').val();
            var tipo = $('#idtipo').val();
            var  idatv = $('#sel1').val();
            var status =  $('#status').val();
            var desc = $('#iddesc').val();
            var tema = $('#tema').val();
            var idprojeto = id;

            $.ajax({
                type:'POST',
                url:"/add",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data:{
                    cli:cli,
                    dia:dia,
                    estima:estima,
                    desc:desc,
                    hfim:hfim,
                    idprojeto:idprojeto,
                    tema:tema,
                    status:status,
                    idatv:idatv,
                    tipo:tipo,
                    projeto:projeto
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


    <table class="table table-striped"  id="projetosdettable">
        <thead>
        <tr>
            <th class="text-center">Cliente</th>
            <th class="text-center">Projeto</th>
            <th class="text-center">Atividade</th>
            <th class="text-center">Horas Planejadas</th>
            <th class="text-center">Horas fim</th>
            <th class="text-center">Status</th>
            <th class="text-center">Tema</th>
            <th class="text-center">Descrição</th>
            <th class="text-center">Dia</th>
        </tr>
        </thead>
        <tbody>
        @foreach($escopo as $es)
            <tr>
                <td>{{$es->cliente}}</td>
                <td>{{$es->id_projeto}}</td>
                <td>{{$es->id_atv_det}}</td>
                <td>{{$es->horas_plan}}</td>
                <td>{{$es->horas_fim}}</td>
                <td>{{$es->status}}</td>
                <td>{{$es->tema}}</td>
                <td>{{$es->comentario}}</td>
                <td>{{$es->data}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>







@stop
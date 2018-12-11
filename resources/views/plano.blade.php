@extends('adminlte::page')

@section('title', 'Cadastro de Consultores')

@section('content_header')

    <h1><i class="glyphicon glyphicon-scale"></i> Planos Criados</h1>
@stop

@section('content')
    <script>
        $(document).ready(function(){

            $('#datainiciomodal').mask('00/00/0000');
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

        function addPlano() {

            $("#modalPlanos").modal('toggle');
        }
        function salvarPlano(){
            var idprojeto = $('#idprojetomodal').val();


                $.ajax({
                    type:'POST',
                    url:"{{URL::route('registrar.plano')}}",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        idprojeto:idprojeto
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
        <br>
        <button onclick="addPlano()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>


        <br><br>

        <table class="table table-striped" style="text-align: center" id="consultortable">
            <thead>
            <tr>
                <th class="text-center">Código</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Projeto</th>
                <th class="text-center">Status</th>
                <th class="text-center">Custo</th>
                <th class="text-center">Detalhes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($planos as $plano)
                <tr class="item{{$plano->planoid}}">
                    <td>{{$plano->planoid}}</td>
                    <td>{{$plano->razaosocial}}</td>
                    <td>{{$plano->nome}}</td>

                    <td><?php
                        if($plano->status =="" ||$plano->status ==0){
                            echo '<b>Orçamento</b>';
                        }else{
                            echo '<b>Execução</b>';
                        }
                        ?></td>
                    <td><?php
                        if($plano->custo ==""){
                            echo 'R$ 0,00';
                        }else{
                            echo 'R$ '.$plano->custo;
                        }
                        ?></td>



                    <td>
                        <a href="/detalhes-plano/{{$plano->planoid}}">
                            <button class="edit-modal btn btn-default" title="Detalhes do Plano">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button></a>

                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="/"><button class="btn btn-default">Voltar</button></a>

    </div>





    <!-- Modal Criar Projeto -->
    <div class="modal fade" id="modalPlanos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Criação de Plano - Escopo</h4>
                </div>
                <div class="modal-body clientebody">
                    <label for="">Selecione o Projeto</label>
                    <select class="form-control" name="" id="idprojetomodal">
                            @foreach($projetos as $projeto)
                                <option value="{{$projeto->id}}"><b>{{$projeto->nomefantasia}}</b> - {{$projeto->nome}}</option>
                            @endforeach
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    @if(Auth::user()->nivelacesso <3)
                        <button type="button" onclick="salvarPlano()" class="btn btn-primary">Criar Plano</button>
                    @endif

                </div>
            </div>
        </div>
    </div>




@stop
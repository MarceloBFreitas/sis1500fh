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
            alert(id);
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
        function abremodalalterar(id){
            $('#pegaid').val(id);
            $('#alterregistro').modal('toggle');

        }

        function alterar(){
            var dia =  $('#iddia').val();
            var qtd  =$('#idqtd').val();
            var desc= $('#iddesc').val();

            var id = $('#pegaid').val();
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
                    url:"/horas-alterar",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    data:{
                        id:id,
                        dia:dia,
                        qtd:qtd,
                        desc:desc,

                    },
                    success:function(data){
                        //swal({
                          //  title: data.msg,
                            // text: 'Do you want to continue',
                            //type: data.tipo,
                            //timer: 2000
                        //});
                        console.log(data);

                      //  location.reload();


                    }
                });

            }







            }


 </script>


    <div class="container">
            <input type="hidden" id="pegaid">
        <div class="container">

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
                                <button class="ion-android-deletebtn-danger  warning" title="Excluir" id="{{$todos->idregistro}}" onclick="excluir({{$todos->idregistro}})">
                                        <span class="glyphicon  glyphicon-trash warning danger"></span>
                                    </button>

                                </td>
                            </tr>
                         @endforeach
                    </tbody>
             </table>

        </div>


    </div>





 <!-- Modal Adicionar Detalhes do Registro de Horas-->
 <div class="modal fade" id="alterregistro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                     <label for="comment">Horas Para fim</label><input class="form-control" type="Text" id="idhoras fim" > <br/>
                     <label for="comment">Descrição:</label>
                     <textarea class="form-control" rows="5" id="iddesc"></textarea>
                 </div>


             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

                 <button type="button" onclick="alterar()" class="btn btn-primary">Alterar Horas</button>


             </div>
         </div>
     </div>
 </div>

































@stop
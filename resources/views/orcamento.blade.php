@extends('adminlte::page')

@section('title', 'Orçamento')

@section('content_header')

    <h1><i class="glyphicon glyphicon-scale"></i> Orçamento do projeto </h1>
@stop

@section('content')
    <div class="container">
        <div style="width: 20%">

        <img src="{{ asset('img/1500-logo-completo.png') }}"  class="rounded" alt="Cinque Terre" style=" width:100%;
    margin-left:-10%;" />

        </div>

        <div class="col-md-6">
        <h2>Cliente:{{$orcadet[0]->nomefantasia}}  </h2><br/>
        <label>CNPJ:{{$orcadet[0]->cnpj}}</label><br/>
        <label>Email:{{$orcadet[0]->email}}</label><br/>
        <label>Cidade:{{$orcadet[0]->cidade}}</label><br/>

        </div>


        <div class="col-md-6">
        <h2>Projeto:{{$orcadet[0]->nome}}  </h2><br/>
        <label>Valor de horas por gestão:</label>{{$orcadet[0]->gestao}} <br/>
        <label>valor de horas por Consultor:</label> </label>{{$orcadet[0]->tecn}} <br/>

        <label>Data da criação do orçamento:</label> </label>{{$orcadet[0]->created_at}}<br/>



        </div>

        <div class="col-md-12">
        <h1>Atividades do Plano</h1>

        </div>

        <div class="col-lg-12" style="float: left ;">
            <div class="col-md-8">

            </div>
            <div class="col-lg-4">

                <h4>Quantidade de Horas : <span class="label label-default">{{$orcadet[0]->total_horas}}</span></h4>
                <h4>Valor Total : <span class="label label-default">{{$orcadet[0]->valor_total}} </span></h4>

            </div>
        </div>

        <div class="col-lg-12" style="background:#0d6aad;float: left "> <label style="background: #0d6aad"></label>
        </div><br/>


            @foreach($orcadet as $or)


                    <div class="col-md-4"><h4>Atividade : {{$or->sigla}}</h4></div>
                    <div class="col-md-4"><h4>Horas estimadas  :{{$or->horas_estimadas}}</h4></div>
                    <div class="col-md-4">  <h4> Valor da atividade R$
                <?php
                        if($or->nivelacesso == 3){
                            echo $or->tecn* $or->horas_estimadas;
                        }else{
                            echo $or->gestao*$or->horas_estimadas;
                        } ?></h4> </div>
             @endforeach

        <div class="col-lg-12" style="background:#0d6aad;float: left "> <label style="background: #0d6aad"></label>
        </div><br/>
        <div class="col-md-12">
            @foreach($desc as $d)

                <div class="col-lg-4"><h4>{{$d->sigla}} : </h4> </div>
                <div class="col-lg-8"><h4>{{$d->descricao}}</h4></div>

                    @endforeach

        </div>
            <br/><br/>


    </div>




@stop
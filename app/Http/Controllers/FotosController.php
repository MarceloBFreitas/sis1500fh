<?php

namespace App\Http\Controllers;

use App\Foto;
use App\FotoDetalhe;
use App\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FotosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){


        $projeto = Projeto::find($id);
        $fotos = DB::select('select *,
                    DATEPART(dw,sisfotos.created_at) dia_semana,
                    DATEPART(wk,sisfotos.created_at) semana,
                    DATEPART(mm,sisfotos.created_at) mes,
                    DATEPART(YEAR,sisfotos.created_at) ano
                     from sisfotos left join sisgestores on sisgestores.gest_id = sisfotos.id_gestor
                     left join sisusers on sisusers.id = sisgestores.user_id
                     where sisfotos.id_projeto = '.$id.'
                     order by sisfotos.created_at asc;');

        return view('fotos',['fotos'=>$fotos,'projeto'=>$projeto]);

    }

    public function Create($id){
        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        $projeto = Projeto::find($id);
        $projetosdetalhes = DB::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$id);


        if(\Auth::user()->nivelacesso <3){
            $foto = new Foto();
            $foto->cliente =  $projeto->cliente;
            $foto->id_gestor =  $projeto->id_gestor;
            $foto->projeto = $projeto->projeto;
            $foto->id_projeto = $projeto->id;
            $foto->tecn = $projeto->tecn;
            $foto->gestao = $projeto->gestao ;
            $foto->mensuracao_descricao =  $projeto->mensuracao_descricao;
            $foto->mensuracao_data = $projeto->mensuracao_data;
            $foto->objetivo = $projeto->objetivo;
            $foto->custo_total = $projeto->custo_total ;
            $foto->valor_total = $projeto->valor_total;
            $foto->valor_planejado = $projeto->valor_planejado;
            $foto->horas_totais = $projeto->horas_totais;
            $foto->horas_estimadas = $projeto->horas_estimadas;
            $foto->horas_fim = $projeto->horas_fim;

            $foto->save();

            foreach ($projetosdetalhes as $projetosdetalhe){
                $fotodetalhe = new FotoDetalhe();
                $fotodetalhe->id_tpatv = $projetosdetalhe->id_tpatv;
                $fotodetalhe->id_foto = $foto->id;
                $fotodetalhe->id_responsavel = $projetosdetalhe->id_responsavel;
                $fotodetalhe->descricao = $projetosdetalhe->descricao;
                $fotodetalhe->horas_estimadas= (empty($projetosdetalhe->horas_estimadas)?0:$projetosdetalhe->horas_estimadas);
                $fotodetalhe->horas_reais= (empty($projetosdetalhe->horas_reais)?0:$projetosdetalhe->horas_reais);
                $fotodetalhe->predecessora= (empty($projetosdetalhe->predecessora)?0:$projetosdetalhe->predecessora);
                $fotodetalhe->horas_fim= (empty($projetosdetalhe->horas_fim)?0:$projetosdetalhe->horas_fim);
                $fotodetalhe->save();
            }


            $mensagem="Foto do Projeto Registrada com Sucesso";
            $tipo="success";
        }else{
            $mensagem="Você não tem autorização para este recurso";
            $tipo="error";

        }


        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);


    }

    public function DetalhesFoto($id){


    }
}

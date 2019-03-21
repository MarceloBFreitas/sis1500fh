<?php

namespace App\Http\Controllers;

use App\Baseline;
use App\BaselineDetalhe;
use App\Projeto;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Illuminate\Support\Facades\DB;


class BaselineController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function addbase(Request $request){


            $tipo="success";
            $mensagem="baseline Adicionada";
            $prod = Projeto::find($request->id);
            $base = new Baseline();


            $base->id_projeto = $prod->id;
            $base->id_gestor = $prod->id_gestor;
            $base->cliente = $prod->cliente;
            $base->projeto = $prod->projeto;
            $base->tecn = $prod->tecn;
            $base->gestao = $prod->gestao;
            $base->mensuracao_descricao = $prod->mensuracao_descricao;
            $base->mensuracao_data = $prod->mensuracao_data;
            $base->objetivo = $prod->objetivo;
            $base->custo_total = $prod->custo_total;
            $base->valor_total = $prod->valor_total;
            $base->valor_planejado = $prod->valor_planejado;
            $base->horas_estimadas = $prod->horas_estimadas;
            $base->horas_totais = $prod->horas_totais;
            $base->horas_fim = $prod->horas_fim;
            $base->planejado = $prod->planejado;

            $base->save();

            $idbaseline = $base->id;

            $todosproddet = db::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto = ' . $request->id);


            foreach ($todosproddet as $det) {
                $basedet = new BaselineDetalhe();


                $basedet->id_tpatv = $det->id_tpatv;
                $basedet->id_baseline = $idbaseline;
                $basedet->id_responsavel = $det->id_responsavel;
                $basedet->descricao = $det->descricao;
                $basedet->horas_reais = $det->horas_reais;
                $basedet->predecessora = $det->predecessora;
                $basedet->horas_estimadas = $det->horas_estimadas;
                $basedet->horas_fim = $det->horas_fim;
                $basedet->data_inicio = $det->data_inicio;
                $basedet->data_fim  =  $det->data_fim;
                $basedet->situacao = $det->situacao;



                $basedet->save();
            }



        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response);

    }


    public function edit(Request $request){



         $base = db::select('select *from sisbaseline where sisbaseline.id_projeto = '.$request->id);

         $iddabase = "";
         foreach ($base as $b){
             $iddabase =  $b->id;
         }

         $baseline = Baseline::find($iddabase);
         $prod = Projeto::find($request->id);




        $baseline->id_projeto = $prod->id;
        $baseline->id_gestor = $prod->id_gestor;
        $baseline->cliente = $prod->cliente;
        $baseline->projeto = $prod->projeto;
        $baseline->tecn = $prod->tecn;
        $baseline->gestao = $prod->gestao;
        $baseline->mensuracao_descricao = $prod->mensuracao_descricao;
        $baseline->mensuracao_data = $prod->mensuracao_data;
        $baseline->objetivo = $prod->objetivo;
        $baseline->custo_total = $prod->custo_total;
        $baseline->valor_total = $prod->valor_total;
        $baseline->valor_planejado = $prod->valor_planejado;
        $baseline->horas_estimadas = $prod->horas_estimadas;
        $baseline->horas_totais = $prod->horas_totais;
        $baseline->horas_fim = $prod->horas_fim;
        $baseline->planejado = $prod->planejado;

        $baseline->save();

        $basedetlista = db::select('select * from sisbaseline_detalhe where sisbaseline_detalhe.id_baseline ='.$baseline->id);


        foreach ($basedetlista as $bdet){
            $det = BaselineDetalhe::find($bdet->id);

            $det->delete();
        }

        $todosproddet = db::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto = ' . $request->id);

        foreach ($todosproddet as $det) {
            $basedet = new BaselineDetalhe();


            $basedet->id_tpatv = $det->id_tpatv;
            $basedet->id_baseline = $baseline->id;
            $basedet->id_responsavel = $det->id_responsavel;
            $basedet->descricao = $det->descricao;
            $basedet->horas_reais = $det->horas_reais;
            $basedet->predecessora = $det->predecessora;
            $basedet->horas_estimadas = $det->horas_estimadas;
            $basedet->horas_fim = $det->horas_fim;
            $basedet->data_inicio = $det->data_inicio;
            $basedet->data_fim  =  $det->data_fim;
            $basedet->situacao = $det->situacao;




            $basedet->save();
        }


        $tipo="success";
        $mensagem="baseline Alterada";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response);

    }

    public  function  index($id){


        $base = db::select(' select sisbaseline.id  idbase,* from sisbaseline
  left join sisgestores on sisbaseline.id_gestor = sisgestores.gest_id
  left join sisusers on sisusers.id = sisgestores.user_id
  where sisbaseline.id_projeto ='.$id);
        $idbaseline = 0;
        foreach ($base as $b){
            $idbaseline =  $b->idbase;
        }

        $baseline = Baseline::find($idbaseline);

        $basedet = db::select('   select sisbaseline_detalhe.id idbase , sisbaseline_detalhe.descricao descri,* from sisbaseline_detalhe
  left join sisusers on sisbaseline_detalhe.id_responsavel = sisusers.id
  inner join sistipo_atividades on sistipo_atividades.id =  sisbaseline_detalhe.id_tpatv
  where sisbaseline_detalhe.id_baseline ='.$baseline->id);




        return view('baseline',['baseline'=>$baseline,'basedet'=>$basedet,'base'=>$base]);





    }


}

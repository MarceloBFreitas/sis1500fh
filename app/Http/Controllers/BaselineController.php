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

                $basedet->save();
            }


        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response);

    }


}

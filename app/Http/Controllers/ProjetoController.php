<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\OrcamentoEscopo;
use App\Projeto;
use App\ProjetoDetalhe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function criarProjeto($id){

       $mensagem="Erro no Controller, favor consultar API";
       $tipo="error";

        $orcamentoescopo = OrcamentoEscopo::find($id);
        $orcamentoDetalhes = DB::select('select * from sisescopo_orcamento_detalhe
                        inner join sisescopo_orcamento on sisescopo_orcamento.id = sisescopo_orcamento_detalhe.id_eo
                        where sisescopo_orcamento.id = '.$id);

        $projeto = new Projeto();
        $projeto->cliente = $orcamentoescopo->cliente;
        $projeto->projeto = $orcamentoescopo->projeto;
        $projeto->tecn = $orcamentoescopo->tecn;
        $projeto->gestao = $orcamentoescopo->gestao;
        $projeto->mensuracao_descricao = $orcamentoescopo->mensuracao_descricao;
        $projeto->mensuracao_data = $orcamentoescopo->mensuracao_data;
        $projeto->objetivo = $orcamentoescopo->objetivo;
        $projeto->objetivo = $orcamentoescopo->objetivo;
        $projeto->custo_total = 0.0;
        $projeto->valor_total = $orcamentoescopo->valor_total;
        $projeto->horas_totais = 0.0;
        $projeto->horas_estimadas = $orcamentoescopo->horas_totais;
        $orcamentoescopo->objetivo = 1;



       if(\Auth::user()->nivelacesso <3){
           $orcamentoescopo->save();
           $projeto->save();

           foreach ($orcamentoDetalhes as $orc_det){
               $pdetalhe = new ProjetoDetalhe();
               $pdetalhe->id_tpatv = $orc_det->atvid;
               $pdetalhe->id_projeto = $projeto->id;
               $pdetalhe->descricao = $orc_det->descricao;
               $pdetalhe->horas_estimadas = $orc_det->horas_estimadas;
               $pdetalhe->horas_reais = 0;
               $pdetalhe->horas_fim = $orc_det->horas_estimadas;
               $pdetalhe->save();
           }
           $mensagem="Projeto Criado com Sucesso";
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
}

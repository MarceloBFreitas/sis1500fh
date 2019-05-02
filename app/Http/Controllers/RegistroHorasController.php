<?php

namespace App\Http\Controllers;

use App\Consultor;

use App\Gestor;
use App\Alertavalida;
use App\Logregistros;
use App\Projeto;
use App\ProjetoDetalhe;
use App\TipoAtividade;
use App\OrcamentoDetalhe;
use App\orcamentoEscopo;
use App\Registros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroHorasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){


        $itensTabela = DB::select('select sisprojeto_detalhe.id iddet,sisprojeto_detalhe.horas_estimadas horas_estimadasdet, sisprojeto_detalhe.horas_reais horas_reaisdet,sisprojeto_detalhe.horas_fim horas_fimdet, *  from
   sisprojeto_detalhe 
inner join sisprojetos on sisprojeto_detalhe.id_projeto = sisprojetos.id
inner join sistipo_atividades on sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
inner join sisusers on sisusers.id  = sisprojeto_detalhe.id_responsavel  where 

sisusers.id ='.auth()->user()->id);

        $itensfinalizados = DB::select('select sisprojeto_detalhe.id iddet,sisprojeto_detalhe.horas_estimadas horas_estimadasdet, sisprojeto_detalhe.horas_reais horas_reaisdet,sisprojeto_detalhe.horas_fim horas_fimdet, *  from
   sisprojeto_detalhe 
inner join sisprojetos on sisprojeto_detalhe.id_projeto = sisprojetos.id
inner join sistipo_atividades on sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
inner join sisusers on sisusers.id  = sisprojeto_detalhe.id_responsavel  where sisprojeto_detalhe.horas_fim > 0 and 

sisusers.id ='.auth()->user()->id);


        return view('registro-horas',['itensTabela'=>$itensTabela,'itensabertostabela'=>$itensfinalizados]);
    }

    public function  salvar(Request $request){

        $lr = new Logregistros();
        $re = new Registros();
        $re->dia = $request->dia;
        $re->descricao = $request->desc;
        $re->qtd_horas = str_replace(',','.',$request->qtd);
        $re->id_projetodetalhe = $request->id;
        $re->id_user =  auth()->user()->id;
        $lr->qtd_horas_registradas = $request->qtd;




        $projetodetalhe = ProjetoDetalhe::find($request->id);


        $lr->hora_fim_sugerida =  $projetodetalhe->horas_fim ;
        $lr->id_projetodetalhe = $projetodetalhe->id;

        if($projetodetalhe->horas_fim == $request->horasf ){
            $aux  =  $projetodetalhe->horas_fim - $request->qtd;
                if($aux < 0){
                    $projetodetalhe->horas_fim = 0;
                }else{
                    $projetodetalhe->horas_fim  = $projetodetalhe->horas_fim - $request->qtd;
            }

        }else{
            $projetodetalhe->horas_fim = $request->horasf;
        }

        $lr->hora_fim_cadastrada =   $request->horasf - $request->qtd;
        $projetodetalhe->horas_reais = $projetodetalhe->horas_reais + $re->qtd_horas;
        $projetodetalhe->save();
      // =  $projetodetalhe->horas_fim;

            $re->save();
            $lr->id_registro = $re->id;

            $proj = Projeto::find($projetodetalhe->id_projeto);
             if($proj->horas_estimadas < $proj->horas_totais){

                 $va = DB::select('select * from sis_alertavalidacao where sis_alertavalidacao.id_projeto ='.$projetodetalhe->id_projeto);
                 $id =0;
                 foreach ($va as $v){
                     $id =  $v->id;
                 }


                 $valida = alertavalida::find($id);


                 $valida->produtividade =1;

                 $valida->save();
             }


            $lr->save();
            $tipo = "success";
            $mensagem = "Registro realizado com Sucesso";




        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);


    }

    public function horafim($id){

        $prodet=ProjetoDetalhe::find($id);


       // return response()->json($horasFim);



    }

    /////////////Controles de Horas Detalhe

    public function resHorasDet($idProjetoDet){


        $todosRegistros = DB::select('select sisregistros.id idregistro, * from sisregistros inner join sisusers on
sisregistros.id_user = sisusers.id where sisregistros.id_projetodetalhe ='.$idProjetoDet);

        return view('horas-atividade',['todosRegistros'=>$todosRegistros]);
    }


    public function delDet($id){

        $regristro = Registros::find($id);

      //  $idRegistroHora = (integer) DB::select('select id  from sislogregistros where sislogregistros.id_registro ='.$id);


        $logRegistro = Logregistros::find($id);





        $prodet = ProjetoDetalhe::find($regristro->id_projetodetalhe);

        $prodet->horas_reais = $prodet->horas_reais - $regristro->qtd_horas;

        $horascadastradas =$logRegistro->hora_fim_cadastrada;

          $prodet->horas_fim =  ($logRegistro->hora_fim_sugerida + $prodet->horas_fim) -$horascadastradas ;



        $prodet->save();

        $regristro->delete();

        $mensagem = "Registro Removido";
        $tipo = "error";

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);

}
    public function alterRegistro(Request $request){

    try{

        $registro = Registros::find($request->id);



        $projetodet = ProjetoDetalhe::find($registro->id_projetodetalhe);


        $projetodet->horas_reais =  $projetodet->horas_reais - $registro->qtd_horas;
        $projetodet->horas_fim =  $projetodet->horas_fim + $registro->qtd_horas;
        $projetodet->save();
        $projetodetalter = ProjetoDetalhe::find($registro->id_projetodetalhe);
        $registro->dia = $request->dia;
        $registro->qtd_horas = $request->qtd;
        $registro->descricao = $request->desc;
        $registro->save();

        $projetodetalter->horas_reais =  $projetodetalter->horas_reais + $request->qtd;
        $projetodetalter->horas_fim =  $projetodetalter->horas_fim - $request->qtd;
        $projetodetalter->save();

    $mensagem = "Registro Alterado";
    $tipo = "success";
}catch  (Exception $e) {
    $mensagem = "Erro";
    $tipo = "error";

}

    $response = array(
        'tipo' => $tipo,
        'msg' => $mensagem,
    );
    return response()->json($response);





}

    public function todosRegistros(){

        $todosRegistros = DB::select('  select sisregistros.descricao descricaodoregistro, * from sisregistros inner join sisprojeto_detalhe on sisregistros.id_projetodetalhe = sisprojeto_detalhe.id
  inner join sisusers on sisregistros.id_user = sisusers.id
  inner join sisprojetos on sisprojetos.id = sisprojeto_detalhe.id_projeto
  inner join sistipo_atividades on sistipo_atividades.id = sisprojeto_detalhe.id_tpatv');

        return view('todos-registros',['registro'=>$todosRegistros]);

}
































}

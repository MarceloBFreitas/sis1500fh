<?php

namespace App\Http\Controllers;

use App\Consultor;

use App\Gestor;
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


        $itensTabela = DB::select('  select sisprojeto_detalhe.id iddet,sisprojeto_detalhe.horas_estimadas horas_estimadasdet, sisprojeto_detalhe.horas_reais horas_reaisdet,sisprojeto_detalhe.horas_fim horas_fimdet, * from
   sisprojeto_detalhe 
inner join sisprojetos on sisprojeto_detalhe.id_projeto = sisprojetos.id
inner join sistipo_atividades on sisprojeto_detalhe.id_tpatv  = sistipo_atividades.id');


        return view('registro-horas',['itensTabela'=>$itensTabela]);
    }

    public function  salvar(Request $request){

        $lr = new Logregistros();
        $re = new Registros();
        $re->dia = $request->dia;
        $re->descricao = $request->desc;
        $re->qtd_horas = str_replace(',','.',$request->qtd);
        $re->id_projetodetalhe = $request->id;
        $re->id_user =  auth()->user()->id;
        $lr->qtd_horas_registradas = $re->qtd_horas;




        $projetodetalhe = ProjetoDetalhe::find($request->id);


        $lr->hora_fim_sugerida =  $projetodetalhe->horas_fim;
        $lr->id_projetodetalhe = $projetodetalhe->id;
        $projetodetalhe->horas_fim =  $request->horasf - $request->qtd;
        $projetodetalhe->horas_reais = $projetodetalhe->horas_reais + $re->qtd_horas;
        $projetodetalhe->save();
        $lr->hora_fim_cadastrada =  $projetodetalhe->horas_fim;


        $mensagem = "Você não tem autorização para realizar essa ação";
        $tipo = "error";


        if(\Auth::user()->nivelacesso <3){

            $re->save();
            $lr->id_registro = $re->id;
            $lr->save();
            $tipo = "success";
            $mensagem = "Registro realizado com Sucesso";
        }else{
            $mensagem = "Você não tem autorização para realizar essa ação";
            $tipo = "error";
        }

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

        $reg = Registros::find($id);

      //  $lrid = DB::select('  select id from sislogregistros where sislogregistros.id_registro  ='.$id);



        $lr = Logregistros::find($id);



        $prodet = ProjetoDetalhe::find($reg->id_projetodetalhe);

        $prodet->horas_reais = $prodet->horas_reais - $reg->qtd_horas;
      //  $prodet->horas_fim =  $prodet->horas_fim + $reg->qtd_horas;
        $prodet->horas_fim =  ($prodet->horas_fim + $lr->hora_fim_sugerida)- $lr->hora_fim_cadastrada;

        $prodet->save();

        $reg->delete();

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
}

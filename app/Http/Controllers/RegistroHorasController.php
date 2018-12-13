<?php

namespace App\Http\Controllers;

use App\Consultor;
use App\Gestor;
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


        $itensTabela = DB::select('	select * from sisprojeto_detalhe 
inner join sisprojetos on sisprojeto_detalhe.id_projeto = sisprojetos.id
inner join sistipo_atividades on sisprojeto_detalhe.id_tpatv  = sistipo_atividades.id');


        return view('registro-horas',['itensTabela'=>$itensTabela]);
    }

    public function  salvar(Request $request){


        $projetodetalhe = ProjetoDetalhe::find($request->id);

        if($projetodetalhe->horas_fim !=$request->horaFim){
            $projetodetalhe->horas_fim = $request->horaFim;
        }else{
            $projetodetalhe->horas_fim = $projetodetalhe->horas_fim - $request->qtd;
        }

        $projetodetalhe->save();

        $projeto = Projeto::find($projetodetalhe->id_projeto);

        $custo = 0;
        if(\Auth::user()->nivelacesso ==3){
            $consultor = Consultor::where('user_id','=',\Auth::user()->id);
            $custo = $consultor->custohora *$request->qtd;
        }else{
            $gestor = Gestor::where('user_id','=',\Auth::user()->id);
            $custo = $gestor->custohora *$request->qtd;
        }
        $projeto->custo_total = $projeto->custo_total + $custo;
        $projeto->save();

        $re = new Registros();
        $re->dia = $request->dia;
        $re->descricao = $request->desc;
        $re->qtd_horas = str_replace(',','.',$request->qtd);
        $re->id_projetodetalhe = $request->id;
        $re->horas_fim = $request->horaFim;
        $re->id_user =  auth()->user()->id;


        $mensagem = "Você não tem autorização para realizar essa ação";
        $tipo = "error";


        if(\Auth::user()->nivelacesso <3){

            $re->save();

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

    public function horafim(Request $request){
        $id = $request->idprojetodet;


        $prodet=ProjetoDetalhe::find($id);
            //Db::Select('select * from sisprojeto_detalhe   where sisprojeto_detalhe.id='.$id);
        $valdehr = $prodet->horas_reais;
        $valdeestima = $prodet->horas_estimadas;
        $horasFim =   $valdeestima - $valdehr;



        return response()->json($horasFim);



    }
}

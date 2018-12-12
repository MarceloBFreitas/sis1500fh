<?php

namespace App\Http\Controllers;

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


        $itensTabela = DB::select('select * from sisprojeto_detalhe inner join sisprojetos on sisprojeto_detalhe.id_projeto = sisprojetos.id');


        return view('registro-horas',['itensTabela'=>$itensTabela]);
    }

    public function  salvar(Request $request){


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
            $mensagem = "Plano Deletado com Sucesso";
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

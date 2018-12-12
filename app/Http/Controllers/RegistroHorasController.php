<?php

namespace App\Http\Controllers;

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


        $id = auth()->user()->id;
        $od = DB::select('select * from sisescopo_orcamento_detalhe where sisescopo_orcamento_detalhe.id_user ='.$id);

        $atv = TipoAtividade::all();
        $oe = orcamentoEscopo::all();


        return view('registro-horas',['od'=>$od,'atv'=>$atv,'oe'=>$oe]);
    }

    public function  salvar(Request $request){


        $re = new Registros();
        $re->dia = $request->dia;
        $re->descricao = $request->desc;
        $re->qtd_horas = $request->qtd;
        $re->id_atv_ed = $request->idod;
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
}

<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\OrcamentoDetalhe;
use App\orcamentoEscopo;
use App\User;
use Illuminate\Http\Request;

class OrcamentoDetalheController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
            $atv = Atividade::all();
            $eod = OrcamentoDetalhe::all();
            $user = User::all();
            $eo = $id;


        return view("orcamento-detalhe",['atv'=>$atv,'eod'=>$eod,'user'=>$user,'eo'=>$eo]);
    }
    public function salvar(Request $request){
        $teste ="marcelo";
        $od = new OrcamentoDetalhe();
        $tipo = "error";

        $od->id_user = $request->iduser;
        $od->id_eo = $request-> idoe;

        $od->id_atv = $request->idatv;
         $od->descricao = $request->desc;
          $od->horas_estimadas = $request->horasestimadas;

        if(\Auth::user()->nivelacesso <3){

            $od->save();

            $tipo = "success";
            $mensagem = "Plano adicionado com Sucesso";
        }else{
            $mensagem = "Você não tem autorização para realizar essa ação";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);



    }












}

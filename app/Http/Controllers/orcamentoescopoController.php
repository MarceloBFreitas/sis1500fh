<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\orcamentoEscopo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class orcamentoescopoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $escopo = orcamentoEscopo::all();

        return view('escopo-orcamento',['escopo'=>$escopo]);
    }
    public function salvarFinal(Request $request){
            $id = $request->id;
            $valT=0;
            $horasT=0;
            $tipoAtt = Atividade::all();



            $tdOrcDet = DB::Select('  select * from sisescopo_orcamento_detalhe eod 
  inner join sisatividades atv on atv.id = eod.id_atv
  inner join sisescopo_orcamento occ on occ.id = eod.id_eo
  where eod.id_eo ='.$id);


            $or = orcamentoEscopo::find($id);


            foreach ($tdOrcDet as $aux){
                $horasT = $horasT + $aux->horas_estimadas;
               if($aux->tipo == 'tecnica'){
                   $valT = $valT + ($aux->tecn * $aux->horas_estimadas );
                }else{
                   $valT = $valT + ($aux->gestao * $aux->horas_estimadas );
               }

            }


            $or->horas_totais = $horasT;
            $or->valor_total = $valT;
            $or->save();
            return'';


    }

    public  function salvar(Request $request){

        $oe = new orcamentoEscopo();
        $oe->cliente = $request->cliente;
        $oe->mensuracao =$request->mensuracao;
        $oe->tecn = $request->horat;
        $oe->gestao=$request->horag;
        $oe->projeto = $request->projeto;
        $oe->objetivo = $request->objetivo;
        $oe->status = 'execução';
        $oe->valor_total = 0;
        $oe->horas_totais = 0;

        if(\Auth::user()->nivelacesso <3){

            $oe->save();

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

    Public function trasItem(Request $request){
        $mensagem="ERRO API";
        $tipo="error";
        $item =  orcamentoEscopo::find($request->id);

        if(\Auth::user()->nivelacesso <3){


            $tipo = "success";

        }else{
            $mensagem = "Você não tem autorização para realizar essa ação";
            $tipo = "error";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($item);


    }

    public function edita(Request $request){
        $aux = orcamentoEscopo::find($request->id);



        $vt = $aux->valor_total;
        $ht =$aux->horas_totais;

        $aux->cliente = $request->cliente;
        $aux->mensuracao =$request->mensuracao;
        $aux->tecn = $request->horat;
        $aux->gestao=$request->horag;
        $aux->projeto = $request->projeto;
        $aux->objetivo = $request->objetivo;
        $aux->horas_totais =  $ht;
        $aux->valor_total =   $vt ;
        $aux->status = $aux->status;

        $mensagem = "Você não tem autorização para realizar essa ação";
        $tipo = "error";


        if(\Auth::user()->nivelacesso <3){

            $aux->save();

            $tipo = "success";
            $mensagem = "Plano adicionado com Sucesso";
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
    public function deleta(Request $request)
    {
        $aux = orcamentoEscopo::find($request->id);
        $mensagem = "Você não tem autorização para realizar essa ação";
        $tipo = "error";


        if(\Auth::user()->nivelacesso <3){

            $aux->delete();

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



    //
}

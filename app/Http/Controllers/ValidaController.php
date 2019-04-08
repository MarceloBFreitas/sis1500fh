<?php

namespace App\Http\Controllers;

use App\Projeto;
use App\ProjetoDetalhe;
use App\ValidaEscopo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projeto = DB::select('select * from sisprojetos');
        $projetoDet = DB::select('select * from sisprojeto_detalhe');
        $id=0;

        return view('validacao',['projeto'=>$projeto,'pdet'=>$projetoDet,'id'=>$id]);
    }

    public function addescopo($id)

    {


        $projeto = Projeto::find($id);

        $projetoDet = DB::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$id);

        $escopo = DB::select('select * from sis_validaEscopo');


        return view('escopo',['projeto'=>$projeto,'pdet'=>$projetoDet,'escopo'=>$escopo]);
    }

    public function trastipo(Request $request)
    {

        $tip = DB::select('  select * from sisprojeto_detalhe inner join sistipo_atividades 
  on sisprojeto_detalhe.id_tpatv = sistipo_atividades.id
   where sisprojeto_detalhe.id_projeto ='.$request->id);
        $tipo='';
        $estima ='';
        $fim='';
        foreach ($tip as $t){
            $tipo =   $t->tipo;
            $estima = $t->horas_estimadas;
            $fim = $t->horas_fim;
        }

        $response = array(
            'tipo' => $tipo,
            'estima' => $estima,
            'hfim' => $fim,

        );
        return response()->json($response);

    }
    public function add(Request $request){

        $vescopo = new ValidaEscopo();

        $vescopo->cliente =$request->cli;
        $vescopo->id_projeto = $request->idprojeto;
        $vescopo->tipo_atv =  $request->tipo;
        $vescopo->id_atv_det = $request->idatv;
        $vescopo->horas_plan = $request->estima;
        $vescopo->horas_fim = $request->hfim;
        $vescopo->data = $request->dia;
        $vescopo->tema = $request->tema;
        $vescopo->comentario = $request->desc;
        $vescopo->status = $request->status;

        $vescopo->save();
        $mensagem="Validação do Escopo Adicionada";
        $tipo="success";

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);
    }


}

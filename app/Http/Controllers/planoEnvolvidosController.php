<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\Plano_Detalhe;
use Illuminate\Http\Request;
use App\Plano_Envolvido;
use Illuminate\Support\Facades\DB;

class planoEnvolvidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }


    public function getDetPlanDetail($id)
    {
        $detatividade = Plano_Detalhe::find($id);
        $idescolhido = $detatividade->id;
        $envolvidos = DB::select('SELECT sisplano_envolvidos.id as "idplanenvolvido",sisplano_detalhe.id as "idpdet",sisusers.name,sisusers.id as "userid" 
 , sisplano_detalhe.horas_estimadas, sisplano_detalhe.atv_id as "atvid"
  from sisusers 
          INNER JOIN sisplano_envolvidos on sisplano_envolvidos.user_id = sisusers.id
          INNER JOIN sisplano_detalhe on sisplano_detalhe.id = sisplano_envolvidos.pdet_id
		  
          where sisplano_detalhe.id = '.$id);

             $response = array(
                 'envolvidos' => $envolvidos,
                 'idescolhida' =>$idescolhido,
                 'detatividade' =>$detatividade

             );
        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addUserEnvolvido(Request $request)
    {
        $pEnvolvido = new Plano_Envolvido();
        $pEnvolvido->user_id = $request->iduser;
        $pEnvolvido->pdet_id =  $request->idpdet;



        $sigla = DB::select('SELECT user_id , pdet_id FROM sisplano_envolvidos WHERE user_id='.$request->iduser.'AND pdet_id = '.$request->idpdet);

        if (empty($sigla)){
            if(\Auth::user()->nivelacesso <3){
                $pEnvolvido->save();

                $tipo = "success";
                $mensagem = "adicionado o Envolvido com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Usuário já está envolvido nesta atividade";
        }


        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function deleteEnvolvido(Request $request)
    {
        $mensagem ="Erro no Método de Persistência da API";
        $tipo = "error";


        if(\Auth::user()->nivelacesso <3){
            Plano_Envolvido::where('id','=', $request->id)->delete();
            $tipo = "success";
            $mensagem = "Detalhe removido com Sucesso";
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

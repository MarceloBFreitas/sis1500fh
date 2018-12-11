<?php

namespace App\Http\Controllers;

use App\Consultor;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ConsultorController extends Controller

{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }


    public function create()
    {
        $naoregistrados = User::where('nivelacesso', '=',3)->orderBy('name', 'ASC')->get();

        $consultores = DB::table('sisusers')
            ->join('sisconsultores', 'sisusers.id', '=', 'sisconsultores.user_id')
            ->select('sisusers.*', 'sisconsultores.*')
            ->get();
        return view('create-consultor',['naoregistrados'=>$naoregistrados,'consultores' =>$consultores]);

    }


    public function salvarconsultor(Request $request)
    {

        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $consultor = new Consultor;

        $consultor->user_id = $request->idconsultor;
        $consultor->custohora = $request->custohora;
        $consultor->horas_por_dia = $request->horasdia;
        $consultor->data_inicio = $request->datainicio;

        $useexist = DB::table('sisconsultores')->where('user_id','=',$consultor->user_id)->get();
        if ($useexist->isEmpty()) {
            if(\Auth::user()->nivelacesso <3){
                $consultor->save();

                $tipo = "success";
                $mensagem = "Consultor adicionado com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Usuário já está registrado como Consultor";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
       return response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultor = DB::table('sisusers')
            ->join('sisconsultores', 'sisusers.id', '=', 'sisconsultores.user_id')
            ->where('sisusers.id','=',$id)
            ->select('sisusers.id','sisusers.name','sisusers.email', 'sisconsultores.*')
            ->get();
        return $consultor;
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $mensagem="";
        $tipo="error";
        $consultor= Consultor::where('user_id', '=',$id)->first();

        //return json_encode($consultor->jsonSerialize());
        $consultor->custohora = $request->custohora;
        $consultor->horas_por_dia = $request->horasdia;
        $consultor->data_inicio = $request->datainicio;


        if(\Auth::user()->nivelacesso <3){
            try{
                $consultor->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro:" . $e->getMessage();
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Edição de Usuário";
        }
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response);
    }


    public function destroy($id)
    {
        $mensagem="";
        $tipo="error";


        if(\Auth::user()->nivelacesso <3){
            try{
                $res = Consultor::where('cons_id', '=',$id)->delete();
                $mensagem="Usuário Removido com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Remover Usuário";
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Edição de Usuário";
        }
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response); ;
    }
}

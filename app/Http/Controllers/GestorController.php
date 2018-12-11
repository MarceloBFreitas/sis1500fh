<?php

namespace App\Http\Controllers;

use App\Gestor;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class GestorController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $naoregistrados = User::where('nivelacesso', '<',3)->orderBy('name', 'ASC')->get();

        $gestores = DB::table('sisusers')
            ->join('sisgestores', 'sisusers.id', '=', 'sisgestores.user_id')
            ->select('sisusers.*', 'sisgestores.*')
            ->get();
        return view('create-gestor',['naoregistrados'=>$naoregistrados,'gestores' =>$gestores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salvargestor(Request $request)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $gestor= new Gestor();
        $gestor->user_id = $request->iduser;
        $gestor->custohora = $request->custohora;
        $gestor->horas_por_dia = $request->horasdia;
        $gestor->data_inicio = $request->datainicio;

        $useexist = DB::table('sisgestores')->where('user_id','=',$gestor->user_id)->get();
        if ($useexist->isEmpty()) {
            if(\Auth::user()->nivelacesso <3){
                $gestor->save();

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


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $gestor = DB::table('sisusers')
            ->join('sisgestores', 'sisusers.id', '=', 'sisgestores.user_id')
            ->where('sisgestores.gest_id','=',$id)
            ->select('sisusers.id','sisusers.name','sisusers.email', 'sisgestores.*')
            ->get();
        return $gestor;
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
        $mensagem="";
        $tipo="error";
        $gestor= Gestor::where('gest_id', '=',$id)->first();

        //return json_encode($consultor->jsonSerialize());
        $gestor->custohora = $request->custohora;
        $gestor->horas_por_dia = $request->horasdia;
        $gestor->data_inicio = $request->datainicio;


        if(\Auth::user()->nivelacesso <3){
            try{
                $gestor->save();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

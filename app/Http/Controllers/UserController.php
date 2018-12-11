<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->nome;
        $user->email = $request->email;
        $user->password = bcrypt($request->senha);
        $user->nivelacesso = $request->cargo;

        $useexist = User::where('email', '=',$request->email)->first();
        if ($useexist === null) {
            if(\Auth::user()->nivelacesso <3){
                $user->save();
                $request->session()->put('usuario-criado',$request->nome);

            }else{
                $request->session()->put('usuario-erro',$useexist->name);
            }
        }else{
            $request->session()->put('usuario-erro',$useexist->name);
        }
        return view('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', '=',$id)->first();
        return $user;
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
        $user = User::where('id', '=',$id)->first();
        $user->name = $request->nome;
        $user->email = $request->email;
        $user->nivelacesso = $request->cargo;

        if(\Auth::user()->nivelacesso <3){
            try{
                $user->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Atualizar dados do Usuário";
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
        $mensagem="";
        $tipo="error";


        if(\Auth::user()->nivelacesso <3){
            try{
                $res = User::where('id', '=',$id)->delete();
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

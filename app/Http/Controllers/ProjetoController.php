<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projetos = Projeto::all();
        $clientes = Cliente::all();
        return view('projetos',['projetos'=>$projetos,'clientes' => $clientes]);
    }

    public function salvarProjeto(Request $request)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";

        $projeto= new Projeto();
        $projeto->cli_id = $request->idcliente;
        $projeto->nome = $request->nomeprojeto;
        $projeto->objetivo = $request->objetivo;
        $projeto->mensuracao = $request->mensuracao;
        $projeto->dt_inicio = $request->dtinicio;

        $projetoexist = DB::table('sisprojetos')
            ->join('sisclientes', 'sisclientes.id', '=', 'sisprojetos.cli_id')
            ->where('sisprojetos.nome','=', $projeto->nome)
            ->select('sisclientes.*', 'sisprojetos.*')
            ->get();

        if ($projetoexist->isEmpty()) {
            if(\Auth::user()->nivelacesso <3){
                $projeto->save();

                $tipo = "success";
                $mensagem = "Projeto adicionado com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Já existe um projeto com esse nome para este Cliente";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }


    public function show($id)
    {
        $cliente = DB::table('sisprojetos')
            ->join('sisclientes', 'sisclientes.id', '=', 'sisprojetos.cli_id')
            ->where('sisprojetos.id','=', $id)
            ->select('sisclientes.*', 'sisprojetos.*')
            ->get();

        return $cliente;
    }

    public function update(Request $request, $id)
    {
        $mensagem="";
        $tipo="error";
        $projeto=  Projeto::where('id', '=',$id)->first();
        $projeto->nome = $request->nomeprojeto;
        $projeto->objetivo = $request->objetivo;
        $projeto->mensuracao = $request->mensuracao;
        $projeto->dt_inicio = $request->dtinicio;

        if(\Auth::user()->nivelacesso <3){
            try{
                $projeto->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Atualizar Projeto";
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Edição de Projetos";
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
                $res = Projeto::where('id', '=',$id)->delete();
                $mensagem="Projeto Removido com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Remover Projeto";
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Exclusão de Projeto";
        }
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response); ;
    }
}

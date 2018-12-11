<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes',['clientes'=>$clientes]);
    }
    public function salvarCliente(Request $request)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $cliente= new Cliente();
        $cliente->nomefantasia = $request->nomefantasia;
        $cliente->razaosocial = $request->razaosocial;
        $cliente->cnpj = $request->cnpj;
        $cliente->ie = $request->ie;
        $cliente->email = $request->emailcliente;
        $cliente->telefone = $request->telefone;
        $cliente->celular = $request->celular;
        $cliente->pais = $request->pais;
        $cliente->estado = $request->estado;
        $cliente->cidade = $request->cidade;
        $cliente->bairro = $request->bairro;
        $cliente->rua = $request->rua;
        $cliente->complemento = $request->complemento;
        $cliente->numero = $request->numero;
        $cliente->contato = $request->contato;
        $cliente->cep = $request->cep;

        $sigla = DB::table('sisclientes')->where('cnpj','=', $request->cnpj)->get();
        if ($sigla->isEmpty()) {
            if(\Auth::user()->nivelacesso <3){
                $cliente->save();

                $tipo = "success";
                $mensagem = "Cliente adicionado com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Já existe um Cliente com este CNPJ";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }

    public function show($id)
    {
        $cliente = DB::table('sisclientes')
            ->where('sisclientes.id','=',$id)
            ->get();
        return $cliente;
    }

    public function update(Request $request, $id)
    {
        $mensagem="";
        $tipo="error";
        $cliente = Cliente::where('id', '=',$id)->first();
        $cliente->nomefantasia = $request->nomefantasia;
        $cliente->razaosocial = $request->razaosocial;
        $cliente->cnpj = $request->cnpj;
        $cliente->ie = $request->ie;
        $cliente->email = $request->emailcliente;
        $cliente->telefone = $request->telefone;
        $cliente->celular = $request->celular;
        $cliente->pais = $request->pais;
        $cliente->estado = $request->estado;
        $cliente->cidade = $request->cidade;
        $cliente->bairro = $request->bairro;
        $cliente->rua = $request->rua;
        $cliente->complemento = $request->complemento;
        $cliente->numero = $request->numero;
        $cliente->contato = $request->contato;
        $cliente->cep = $request->cep;

        if(\Auth::user()->nivelacesso <3){
            try{
                $cliente->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Atualizar Cliente";
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Edição de Clientes";
        }
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response);
    }
}

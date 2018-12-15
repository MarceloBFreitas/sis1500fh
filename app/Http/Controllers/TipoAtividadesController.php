<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TipoAtividade;

class TipoAtividadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $atividades = TipoAtividade::all();
        return view('atividades',['atividades'=>$atividades]);
    }

    public function salvarAtividade(Request $request)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $atividade= new TipoAtividade();
        $atividade->nome = $request->nome;
        $atividade->sigla = $request->sigla;
        $atividade->descricao = $request->descricao;
        $atividade->tipo = $request->tipo;


        $sigla = DB::table('sistipo_atividades')->where('sigla','=', $request->sigla)->get();
        if ($sigla->isEmpty()) {
            if(\Auth::user()->nivelacesso <3){
                $atividade->save();

                $tipo = "success";
                $mensagem = "Atividade adicionada com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Já existe um Atividade com esta Sigla";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }

    public function show($id)
    {
        $atividade = DB::table('sistipo_atividades')
            ->where('sistipo_atividades.id','=',$id)
            ->get();
        return $atividade;
    }

    public function update(Request $request, $id)
    {
        $mensagem="";
        $tipo="error";
        $atividade = TipoAtividade::where('id', '=',$id)->first();
        $atividade->sigla = $request->sigla;
        $atividade->nome = $request->nome;
        $atividade->descricao = $request->descricao;
        $atividade->tipo = $request->tipo;

        if(\Auth::user()->nivelacesso <3){
            try{
                $atividade->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Atualizar Atividade";
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Edição de Atividade";
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
                $res = TipoAtividade::where('id', '=',$id)->delete();
                $mensagem="Atividade Removida com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Remover Atividade";
                $tipo="error";
            }
        }else{
            $mensagem="Usuário não tem permissão para Edição de Atividade";
        }
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );

        return response()->json($response); ;
    }

    public function grupoAtividade(){
        $grupoatividades = DB::select(' select sistipo_atividades.id as idtpv,
             sistipo_atividades.*, sisblocotipoatividade.id as blid from
             sistipo_atividades inner join sisblocotipoatividade on sisblocotipoatividade.id_tipoatividade = sistipo_atividades.id');

        return view('grupo-atividades',['grupoatividades'=>$grupoatividades]);
    }

}

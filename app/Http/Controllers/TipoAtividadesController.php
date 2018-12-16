<?php

namespace App\Http\Controllers;

use App\BlocoTipoAtividade;
use App\BlocoTipoAtividadeDetalhes;
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
        $grupoatividades = BlocoTipoAtividade::all();

        return view('grupo-atividades',['grupoatividades'=>$grupoatividades]);
    }

    public  function grupoAdicionar(Request $request){

        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $grupo = new BlocoTipoAtividade();

        $grupo->nomegrupo = $request->nome;
        $grupo->descricao = $request->desc;

        $nomegrupo = DB::select("select * from sisblocotipoatividade where sisblocotipoatividade.nomegrupo = '".$grupo->nomegrupo."'");

        if (empty($nomegrupo)) {
            if(\Auth::user()->nivelacesso <3){
                $grupo->save();

                $tipo = "success";
                $mensagem = "Grupo adicionado com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Já existe um Grupo com este nome";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }

    public function detalhesGrupo($id){
        return BlocoTipoAtividade::find($id)->toArray();
    }

    public function atualizarBlocoTipo(Request $request){
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $grupo = BlocoTipoAtividade::find($request->id);

        $grupo->nomegrupo = $request->nomegrupo;
        $grupo->descricao = $request->descricao;

        $nomegrupo = DB::select("select * from sisblocotipoatividade 
                where sisblocotipoatividade.nomegrupo = '".$grupo->nomegrupo."' and sisblocotipoatividade.id != $grupo->id");

        if (empty($nomegrupo)) {
            if(\Auth::user()->nivelacesso <3){
                $grupo->save();

                $tipo = "success";
                $mensagem = "Grupo adicionado com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }
        }else{
            $mensagem = "Já existe um Grupo com este nome";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }

    public function deletarGrupo($id){
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $grupo = BlocoTipoAtividade::find($id);
        $atividadesgrupo = DB::select('select * from sisblocotipoatividade_detalhes where sisblocotipoatividade_detalhes.id_bloco ='.$id);


            if(\Auth::user()->nivelacesso <3){
                foreach ($atividadesgrupo as $tiposatividades){
                    $blocodetalhe = BlocoTipoAtividadeDetalhes::find($tiposatividades->id);
                    $blocodetalhe->delete();
                }
                $grupo->delete();

                $tipo = "success";
                $mensagem = "Grupo Removido com Sucesso";
            }else{
                $mensagem = "Você não tem autorização para realizar essa ação";
            }


        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }

    public function adicionarTiposaoGrupo($id){

        $atividadesatreladas = DB::select('select * from sisblocotipoatividade_detalhes 
            inner join sistipo_atividades on sistipo_atividades.id = sisblocotipoatividade_detalhes.id_tipoatividade
            where sisblocotipoatividade_detalhes.id_bloco ='.$id);
        $blocoatividade = BlocoTipoAtividade::find($id);
        $tiposdeatividade = TipoAtividade::all();
        return view('grupoatividades-detalhes',[
            'atividadesatreladas' =>$atividadesatreladas,
            'blocoatividade' => $blocoatividade,
            'tiposatividade' =>$tiposdeatividade
        ]);
    }

}

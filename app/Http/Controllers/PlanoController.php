<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\Envolvidos;
use App\Plano;
use App\Plano_Detalhe;
use App\Plano_Envolvido;
use App\Registros;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $planos= DB::select('SELECT sisplanos.id as "planoid" ,sisclientes.id as "clienteid",sisclientes.razaosocial,sisprojetos.nome
        ,sisplanos.custo,sisplanos.status from sisplanos 
        INNER  JOIN sisprojetos on sisprojetos.id = sisplanos.pro_id
        INNER JOIN sisclientes on sisclientes.id = sisprojetos.cli_id');


        $projetos = DB::table('sisprojetos')->join('sisclientes','sisclientes.id','=','sisprojetos.cli_id')
        ->select('sisprojetos.*','sisclientes.nomefantasia')->get();


        return view('plano',['planos'=>$planos,'projetos'=>$projetos]);
    }

    public function salvarPlano(Request $request)
    {
        dd($request->input());
        $request->validate([
           'pro_id'
        ]);


        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $plano= new Plano();
        $plano->status = 0;
        $plano->horas_reais = 0;
        $plano->horas_fim = 0;
        $plano->custo = 0;
        $plano->gestao = 0;
        $plano->tecn = 0;
        $plano->valor = 0;
        $plano->pro_id = $request->idprojeto;


            if(\Auth::user()->nivelacesso <3){

                $plano->save();

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

    public function adicionarAtividade(Request $request,$id)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $planodetalhe = new Plano_Detalhe();
        $planodetalhe->plan_id = $id;
        $planodetalhe->atv_id = $request->atvid;
        $planodetalhe->horas_estimadas = $request->horasestimadas;
        $planodetalhe->horas_reais = 0;
        $planodetalhe->horas_fim = $request->horasestimadas;

        $planodetalhe->save();

        $envolvidos = new Envolvidos();
        $envolvidos->user_id = $request->userid;
        $envolvidos->pdet_id = $planodetalhe->id;


        $users = User::find($request->userid);

        $plano = Plano::find($id);

        if($users->nivelacesso < 3){
            $plano->valor = $plano->valor +($request->horasestimadas * $plano->gestao);
        }else{
            $plano->valor =$plano->valor +($request->horasestimadas * $plano->tecn);
        }

        $plano->save();


        if(\Auth::user()->nivelacesso <3){
            $envolvidos->save();

            $tipo = "success";
            $mensagem = "Atividade adicionada com Sucesso";
        }else{
            $mensagem = "Você não tem autorização para realizar essa ação";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
    }

    public function defineTarifa(Request $request,$id)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        try{
            $plano = Plano::find($id);

        }catch (\Exception $e){
            $mensagem = "Erro ao localizar o Plano";
        }
        $plano->gestao = $request->gestao;
        $plano->tecn = $request->tecn;


        if(\Auth::user()->nivelacesso <3){
            $plano->save();
            $tipo = "success";
            $mensagem = "Tarifa adicionada com Sucesso";
        }else{
            $mensagem = "Você não tem autorização para realizar essa ação";
        }

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);

    }

    public function Atividades($id)
    {
        $planodet= DB::table('sisplanos')
            ->join('sisprojetos','sisprojetos.id','=','sisplanos.pro_id')
            ->join('sisclientes','sisprojetos.cli_id','=','sisclientes.id')
            ->where('sisplanos.id','=',$id)
            ->select('sisplanos.*','sisclientes.*','sisprojetos.*')->get();


        if($planodet->isEmpty()){
            return "Erro na Consulta";
        }

        $nomefantasia = "";
        $objetivo = "";
        $datainicio = "";
        $nome = "";
        $gestao = 0;
        $tecn = 0;
        $idplano= 0;
        $horasreais = 0;
        $horasfim = 0;
        $status = 0;
        $horasestimadas = 0;



        $horast = 0;
        $horasg = 0;

        foreach ($planodet as $plano)
        {
            $nomefantasia = $plano->nomefantasia;
            $objetivo = $plano->objetivo;
            $datainicio = $plano->dt_inicio;
            $nome = $plano->nome;
            $gestao = $plano->gestao;
            $tecn = $plano->tecn;
        }


        //Tabela do Home de Detalhes do Plano
        $tabelahome = DB::select('SELECT U.*, U.id as "usaid", sisatividades.*, sisatividades.id as "atvid",sisplano_detalhe.*
        ,sisplano_detalhe.id as "pdetid" FROM sisplanos INNER JOIN sisplano_detalhe ON sisplano_detalhe.plan_id = sisplanos.id 
            INNER JOIN sisatividades ON sisatividades.id = sisplano_detalhe.atv_id 
            INNER JOIN sisplano_envolvidos on sisplano_envolvidos.pdet_id = sisplano_detalhe.id 
            INNER JOIN sisusers U ON U.id = sisplano_envolvidos.user_id 
              WHERE sisplanos.id ='.$id);

        $custogestao = 0;
        $custotecn = 0;
        foreach ($tabelahome as $t){
            $horasreais = $horasreais + $t->horas_reais;

            if($t->nivelacesso == 3){
                $custohoras = DB::select('SELECT * FROM sisusers INNER JOIN sisconsultores ON sisconsultores.user_id = sisusers.id WHERE sisusers.id ='.$t->usaid);
                foreach ($custohoras as $c){
                    $custotecn = $custotecn + ($c->custohora * $t->horas_reais) ;
                }
                }else{
                    $custohoras = DB::select('SELECT * FROM sisusers INNER JOIN sisgestores ON sisgestores.user_id = sisusers.id WHERE sisusers.id ='.$t->usaid);
                    foreach ($custohoras as $c){
                        $custogestao = $custogestao + ($c->custohora * $t->horas_reais) ;
                    }
                }

            $horasestimadas = $horasestimadas + $t->horas_estimadas;
            if($t->nivelacesso == 3){
                $horast = $horast+ $t->horas_reais;
            }else{
                $horasg = $horasg+ $t->horas_reais;
            }
        }


        $horasfim = $horasestimadas - $horasreais;

        //Nome dos Envolvidos
        $envolvidos = DB::select('SELECT  DISTINCT sisusers.name,sisusers.nivelacesso ,sisusers.id FROM sisplanos 
	INNER JOIN sisplano_detalhe ON sisplanos.id = sisplano_detalhe.plan_id
    INNER JOIN sisplano_envolvidos ON sisplano_envolvidos.pdet_id = sisplano_detalhe.id
    INNER JOIN sisusers ON sisusers.id = sisplano_envolvidos.user_id
   
    WHERE sisplano_detalhe.plan_id = '.$id);

        $plano = Plano::find($id);
        $valor = 0;
        if($plano->status == 0){
            $valor = $plano->valor;
        }else{
            $valor = ($horasg * $plano->gestao)+($horast*$plano->tecn);
        }
        $plano->horas_fim = $horasfim;
        $plano->custo = $custogestao +$custotecn;
        $plano->horas_reais = $horasreais;




        $idplano = $plano->id;
        $plano->save();
        $users = User::all()->where('nivelacesso','>','1');
        $atividades = Atividade::all();

        $usuariosenv = User::all();

        return view('plano-detalhes',
            [
            'nomefantasia'=> $nomefantasia,
            'objetivo'=>$objetivo,
            'datainicio'=>$datainicio,
            'nomeprojeto'=>$nome,
            'envolvidos'=>$envolvidos,
            'gestao'=>$gestao,
            'tecn' => $tecn,
            'idplano'=>$idplano,
            'atividades'=>$tabelahome,
            'horasreais'=> $plano->horas_reais,
            'horasfim'=>$plano->horas_fim,
            'status'=>$plano->staus,
            'valor'=>$valor,
            'custogestao'=>$custogestao,
            'custotecn'=>$custotecn,
            'custogeral'=>$plano->custo,
            'responsaveis'=>$users,
            'atividadesgeral'=>$atividades,
            'usuarios' => $usuariosenv
        ]);
    }

    public function destroyAtividade($id)
    {
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";

        $planodetalhe = Plano_Detalhe::find($id);
        $envolvidos = Envolvidos::where('pdet_id','=',$planodetalhe->id)->delete();
        $registros = Registros::where('pdet_id','=',$planodetalhe->id)->delete();
        if(\Auth::user()->nivelacesso <3){
            $planodetalhe = Plano_Detalhe::find($id);
            $envolvidos = Envolvidos::where('pdet_id','=',$planodetalhe->id)->delete();
            $registros = Registros::where('pdet_id','=',$planodetalhe->id)->delete();
            $planoid =$planodetalhe->plan_id;
            $planodetalhe->delete();
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

    public function atualizaPlanoDet(Request $request){

        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $planodetalhe =  Plano_Detalhe::where('id', '=',$id)->first();
        $planodetalhe = new Plano_Detalhe();
        $planodetalhe->atv_id = $request->atvid;
        $planodetalhe->horas_estimadas = $request->horasestimadas;
        $planodetalhe->horas_reais = 0;
        $planodetalhe->horas_fim = $request->horasestimadas;

        $planodetalhe->up;


        if(\Auth::user()->nivelacesso <3){
            try{
                $planodetalhe->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao Atualizar Atividade";
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

    public function upPlanoDet(Request $request){
        $mensagem="Erro no Método de Persistência da API";
        $tipo="error";
        $obj = Plano_Detalhe::find($request->idpdet);

        $obj->atv_id = $request->idatv;
        $obj->horas_estimadas = $request->he;



        if(\Auth::user()->nivelacesso <3){
            try{
                $obj->save();
                $mensagem="Dados Atualizados com Sucesso";
                $tipo="success";
            }
            catch(\Exception $e){
                $mensagem="Erro ao editar Atividade";
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

    public function addhoras(){
        return view('registro-horas');
    }

}

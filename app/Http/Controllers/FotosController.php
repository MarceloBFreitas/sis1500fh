<?php

namespace App\Http\Controllers;

use App\Foto;
use App\FotoDetalhe;
use App\Gestor;
use App\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FotosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){


        $projeto = Projeto::find($id);
        $fotos = DB::select('select *,sisfotos.id as idfoto,
                    DATEPART(dw,sisfotos.created_at) dia_semana,
                    DATEPART(wk,sisfotos.created_at) semana,
                    DATEPART(mm,sisfotos.created_at) mes,
                    DATEPART(YEAR,sisfotos.created_at) ano
                     from sisfotos left join sisgestores on sisgestores.gest_id = sisfotos.id_gestor
                     left join sisusers on sisusers.id = sisgestores.user_id
                     where sisfotos.id_projeto = '.$id.'
                     order by sisfotos.created_at asc;');

        return view('fotos',['fotos'=>$fotos,'projeto'=>$projeto]);

    }

    public function Create(Request $request,$id){
        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        $projeto = Projeto::find($id);
        $totalhoras = 0;
        $registrosdefotohoje = DB::select("SELECT count(*) registros
            from sisfotos where convert(date,sisfotos.created_at) ='".$request->datafoto."'
            and sisfotos.id_projeto = ".$id);


        foreach ($registrosdefotohoje as $registrosdefoto){
            $totalhoras = $registrosdefoto->registros;
        }

        if($totalhoras>2){
            $mensagem="Existe mais de uma Foto registrada para a data informada, por favor informar ao Desenvolvedor";
            $tipo="error";
            $response = array(
                'tipo' => $tipo,
                'msg' => $mensagem,

            );
            return response()->json($response);
        }

        if($totalhoras==0){

            $projetosdetalhes = DB::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$id);


            if(\Auth::user()->nivelacesso <3){
                $foto = new Foto();
                $foto->cliente =  $projeto->cliente;
                $foto->id_gestor =  $projeto->id_gestor;
                $foto->projeto = $projeto->projeto;
                $foto->id_projeto = $projeto->id;
                $foto->tecn = $projeto->tecn;
                $foto->gestao = $projeto->gestao ;
                $foto->mensuracao_descricao =  $projeto->mensuracao_descricao;
                $foto->mensuracao_data = $projeto->mensuracao_data;
                $foto->objetivo = $projeto->objetivo;
                $foto->custo_total = $projeto->custo_total ;
                $foto->valor_total = $projeto->valor_total;
                $foto->valor_planejado = $projeto->valor_planejado;
                $foto->horas_totais = $projeto->horas_totais;
                $foto->horas_estimadas = $projeto->horas_estimadas;
                $foto->horas_fim = $projeto->horas_fim;
                $foto->data_foto=$request->datafoto;

                $foto->save();

                foreach ($projetosdetalhes as $projetosdetalhe){
                    $fotodetalhe = new FotoDetalhe();
                    $fotodetalhe->id_tpatv = $projetosdetalhe->id_tpatv;
                    $fotodetalhe->id_foto = $foto->id;
                    $fotodetalhe->id_responsavel = $projetosdetalhe->id_responsavel;
                    $fotodetalhe->descricao = $projetosdetalhe->descricao;
                    $fotodetalhe->horas_estimadas= (empty($projetosdetalhe->horas_estimadas)?0:$projetosdetalhe->horas_estimadas);
                    $fotodetalhe->horas_reais= (empty($projetosdetalhe->horas_reais)?0:$projetosdetalhe->horas_reais);
                    $fotodetalhe->predecessora= (empty($projetosdetalhe->predecessora)?0:$projetosdetalhe->predecessora);
                    $fotodetalhe->horas_fim= (empty($projetosdetalhe->horas_fim)?0:$projetosdetalhe->horas_fim);
                    $fotodetalhe->save();
                }


                $mensagem="Foto do Projeto Registrada com Sucesso";
                $tipo="success";
            }else{
                $mensagem="Você não tem autorização para este recurso";
                $tipo="error";

            }


            $response = array(
                'tipo' => $tipo,
                'msg' => $mensagem,

            );
            return response()->json($response);
        }else{
            $queryfoto = DB::select("SELECT *
                    from sisfotos where convert(date,sisfotos.created_at) = '".$request->datafoto."'
                    and sisfotos.id_projeto = ".$id );
            $idfoto = 0;
            foreach ($queryfoto as $query){
                $idfoto = $query->id;
            }

            if(\Auth::user()->nivelacesso <3){
                $foto = Foto::find($idfoto);
                $foto->cliente =  $projeto->cliente;
                $foto->id_gestor =  $projeto->id_gestor;
                $foto->projeto = $projeto->projeto;
                $foto->id_projeto = $projeto->id;
                $foto->tecn = $projeto->tecn;
                $foto->gestao = $projeto->gestao ;
                $foto->mensuracao_descricao =  $projeto->mensuracao_descricao;
                $foto->mensuracao_data = $projeto->mensuracao_data;
                $foto->objetivo = $projeto->objetivo;
                $foto->custo_total = $projeto->custo_total ;
                $foto->valor_total = $projeto->valor_total;
                $foto->valor_planejado = $projeto->valor_planejado;
                $foto->horas_totais = $projeto->horas_totais;
                $foto->horas_estimadas = $projeto->horas_estimadas;
                $foto->horas_fim = $projeto->horas_fim;
                $foto->data_foto=$request->datafoto;

                $foto->save();

                $queryfotodetalheupdate = DB::select('select * from sisfoto_detalhe where sisfoto_detalhe.id_foto = '.$idfoto);
                foreach ($queryfotodetalheupdate as $projetosdetalhe){
                    $fotodetalhe = new FotoDetalhe();
                    $fotodetalhe->id_tpatv = $projetosdetalhe->id_tpatv;
                    $fotodetalhe->id_foto = $foto->id;
                    $fotodetalhe->id_responsavel = $projetosdetalhe->id_responsavel;
                    $fotodetalhe->descricao = $projetosdetalhe->descricao;
                    $fotodetalhe->horas_estimadas= (empty($projetosdetalhe->horas_estimadas)?0:$projetosdetalhe->horas_estimadas);
                    $fotodetalhe->horas_reais= (empty($projetosdetalhe->horas_reais)?0:$projetosdetalhe->horas_reais);
                    $fotodetalhe->predecessora= (empty($projetosdetalhe->predecessora)?0:$projetosdetalhe->predecessora);
                    $fotodetalhe->horas_fim= (empty($projetosdetalhe->horas_fim)?0:$projetosdetalhe->horas_fim);
                    $fotodetalhe->save();
                }


                $mensagem="Foto do Projeto Registrada com Sucesso";
                $tipo="success";
            }else{
                $mensagem="Você não tem autorização para este recurso";
                $tipo="error";

            }


            $response = array(
                'tipo' => $tipo,
                'msg' => $mensagem,

            );
            return response()->json($response);


        }

    }

    public function DetalhesFoto($id){
        $foto = Foto::find($id);
        $detalhesfoto = DB::select('select * ,sisfoto_detalhe.id as id_fotodet
            from sisfoto_detalhe 
            inner join sistipo_atividades on sistipo_atividades.id = sisfoto_detalhe.id_tpatv
            left join sisusers on sisusers.id = sisfoto_detalhe.id_responsavel 
            where sisfoto_detalhe.id_foto = '.$id);


        if(empty($foto->id_gestor)){
            return view('foto-detalhe',[
                'detalhesfoto' => $detalhesfoto,
                'foto' =>$foto,
                'gestores'=>'Sem Gestor Atrelado'
            ]);
        }else{


            $gestores = DB::select('select * from sisgestores inner join sisusers on sisusers.id = sisgestores.user_id
          WHERE sisgestores.gest_id = '.$foto->id_gestor);
            $nome ="";
            foreach ($gestores as $gestor){
                $nome = $gestor->name;
            }
            return view('foto-detalhe',[
                'detalhesfoto' => $detalhesfoto,
                'foto' =>$foto,
                'gestores'=>$nome
            ]);

        }

    }

    public function remover($id){

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        if(\Auth::user()->nivelacesso <3){

            $foto = Foto::find($id);
            $fotosdetalhes = DB::select(' select * from sisfoto_detalhe where id_foto ='.$id);

            foreach ($fotosdetalhes as $fotosdetalhe){
                $fotodetalhe = FotoDetalhe::find($fotosdetalhe->id);
                $fotodetalhe->delete();
            }
            $foto->delete();

            $mensagem="Foto do Projeto Removida com Sucesso";
            $tipo="success";
        }else{
            $mensagem="Você não tem autorização para este recurso";
            $tipo="error";

        }


        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);

    }
}

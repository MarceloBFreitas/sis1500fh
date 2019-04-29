<?php

namespace App\Http\Controllers;

use App\Baseline;
use App\BaselineDetalhe;
use App\validaOrcamento;
use App\validaObjetivo;
use App\Projeto;
use App\ProjetoDetalhe;
use App\ValidaData;
use App\ValidaEscopo;
use App\PendenciasCliente;
use App\ValidaProdutividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projeto = DB::select('select sisprojetos.id as pjid, * from sisprojetos left join sisgestores on sisprojetos.id_gestor = sisgestores.gest_id 
   left join sisusers on sisusers.id = sisgestores.user_id');
        $projetoDet = DB::select('select * from sisprojeto_detalhe');


        $id=0;

        return view('validacao',['projeto'=>$projeto,'pdet'=>$projetoDet,'id'=>$id]);
    }
    public function itendpendencia(Request $request){

        $pdet = ProjetoDetalhe::find($request->id);

        $datafim = $pdet->data_fim;
        $datainicio = $pdet->data_inicio;

        $response = array(
            'datafim' => $datafim,
            'datainicio' => $datainicio

        );
        return response()->json($response);
    }

    public function addescopo($id)

    {

        $orcamentos = DB::select('select * from sis_validaorcamento where sis_validaorcamento.id_projeto = '.$id);
        $produtividade = DB::select(' select sis_validaProdutividade.cliente cli,* from sis_validaProdutividade inner join sisprojetos on sisprojetos.id = sis_validaProdutividade.id_projeto where sis_validaProdutividade.id_projeto ='.$id);

        $projeto = Projeto::find($id);

        $projetoDet = DB::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$id);

        $projetoDetf = DB::select('select max(data_fim) as datafim from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$id);



        $escopo = DB::select('select * from sis_validaEscopo');
        $baseline ='';
        $valorbase='';
        $base = DB::select('Select * from sisbaseline where sisbaseline.id_projeto ='.$id);
        foreach ($base as $b){
            $baseline = $b->id;
            $valorbase = $b->valor_planejado;
        }


        $basefim = DB::select(' select MAX(sisbaseline_detalhe.data_fim) as datafim from sisbaseline_detalhe where sisbaseline_detalhe.id_baseline ='.$baseline);

        $foto = db::select(' select * from sisfotos where sisfotos.id_projeto = '.$id.' AND DATEPART(WEEK,sisfotos.data_foto) = DATEPART(WEEK,GETDATE ( ))-1 and DATEPART(Year,sisfotos.data_foto) =  DATEPART(Year,GETDATE())');
        $idfoto='';
        $valorfoto='';
        foreach ($foto as $f){
            $idfoto = $f->id;
            $valorfoto = $f->valor_planejado;
        }

        $fotodet = db::select('  select max(sisfoto_detalhe.data_fim) as datafim from sisfoto_detalhe where sisfoto_detalhe.id='.$idfoto);

        $validadata = db::select('select * from sis_validadata where sis_validadata.id_projeto ='.$id);

        $datafimbase='';
        $datafimfoto='';
        $datafimatual='';
        foreach ($projetoDetf as $df){
            $datafimbase = $df->datafim;
        }

        foreach ($basefim as $df){
            $datafimatual = $df->datafim;
        }
        foreach ($fotodet as $df){
            $datafimfoto = $df->datafim;
        }
        $validaobj = DB::select('select * from sis_validaobjetivo where sis_validaobjetivo.id_projeto ='.$id);
        $validapendencias = DB::select(' select * from sis_validaPendencias inner join sisprojeto_detalhe on sisprojeto_detalhe.id = sis_validaPendencias.id_atv_det 
	  where sis_validaPendencias.id_projeto = '.$id);


        return view('escopo',['validaobj'=>$validaobj,'orcamentos'=>$orcamentos,'validapendencia'=>$validapendencias,'valorfoto'=>$valorfoto,'valorbase'=>$valorbase,'validadata'=>$validadata,'datafimfoto'=>$datafimfoto,'datafimatual'=>$datafimatual,'datafimbase'=>$datafimbase,'projeto'=>$projeto,'pdet'=>$projetoDet,'escopo'=>$escopo,'produtividade'=>$produtividade]);
    }

    public function trastipo(Request $request)
    {

        $tip = DB::select('  select * from sisprojeto_detalhe inner join sistipo_atividades 
        on sisprojeto_detalhe.id_tpatv = sistipo_atividades.id
       where sisprojeto_detalhe.id ='.$request->id);


        $tipo='';
        $estima ='';
        $fim='';
        foreach ($tip as $t){
            $tipo =   $t->tipo;
            $estima = $t->horas_estimadas;
            $fim = $t->horas_fim;
        }

        $response = array(
            'tipo' => $tipo,
            'estima' => $estima,
            'hfim' => $fim,

        );
        return response()->json($response);

    }
    public function add(Request $request){

        $vescopo = new ValidaEscopo();

        $vescopo->cliente =$request->cli;
        $vescopo->id_projeto = $request->idprojeto;
        $vescopo->tipo_atv =  $request->tipo;
        $vescopo->id_atv_det = $request->idatv;
        $vescopo->horas_plan = $request->estima;
        $vescopo->horas_fim = $request->hfim;
        $vescopo->data = $request->dia;
        $vescopo->tema = $request->tema;
        $vescopo->comentario = $request->desc;
        $vescopo->status = $request->status;

        $vescopo->save();
        $mensagem="Validação do Escopo Adicionada";
        $tipo="success";

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);
    }
    public function addobj(Request $request){
         $ob = new Validaobjetivo();
         $ob->cliente = $request->cliente;
         $ob->id_projeto = $request->projeto;
         $ob->data = $request->data;
         $ob->tema = $request->tema;
         $ob->resultado = $request->resultado;
         $ob->comentario = $request->comentario;
         $ob->status = $request->status;
         $ob->mensuracao = $request->mensuracao;
         $ob->mensuracao_data = $request->mensuracaodata;


         $ob->save();

        $mensagem="Validação de Objetivo Adicionada";
        $tipo="success";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);


    }

    public function addprod(Request $request){

        $prod = new ValidaProdutividade();

        $prod->cliente = $request->cliente;
        $prod->horas_plan = $request->horas_plan;
        $prod->id_projeto = $request->projeto;
        $prod->horas_projeto = $request->horas_projeto;
        $prod->data = $request->data;
        $prod->tema = $request->tema;
        $prod->comentario = $request->comentario;
        $prod->status = $request->status;


        $prod->save();
        $mensagem="Validação de Produtividade Adicionada";
        $tipo="success";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);

    }

    public function adddata(Request $request){



        $prod = new ValidaData();

        $prod->cliente = $request->cliente;

        $prod->id_projeto = $request->projeto;
        $prod->data_fim_base = $request->database;
        $prod->data_fim_atual = $request->datareal;
        $prod->fim_semana = $request->datafoto;
        $prod->data = $request->data;
        $prod->tema = $request->tema;
        $prod->comentario = $request->comentario;
        $prod->status = $request->status;


        $prod->save();


        $mensagem="Validação de Datas Adicionada";
        $tipo="success";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);









    }

    public function addorcamento(Request $request){


        $pen = new validaOrcamento();

        $pen->cliente = $request->cliente;
        $pen->valor_base = $request->valorbase;
        $pen->valor_foto = $request->valorfoto;
        $pen->valor_Atual = $request->valoratual;
        $pen->id_projeto = $request->projeto;
        $pen->data = $request->data;
        $pen->tema = $request->tema;
        $pen->status = $request->status;

        $pen->comentario = $request->comentario;

        $pen->save();
        $mensagem="Validação de Orçamento Adicionada";
        $tipo="success";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);
    }

    public function addpendencia(Request $request){

        $pen = new PendenciasCliente();

                $pen->cliente = $request->cliente;
                $pen->tipo_atv = $request->atvdet;
                $pen->data_fim = $request->datafim;
                $pen->data_inicio = $request->datainicio;
                $pen->id_projeto = $request->projeto;
                $pen->data = $request->data;
                $pen->tema = $request->tema;
                $pen->status = $request->status;
                $pen->id_atv_det = $request->atvdet;
                $pen->comentario = $request->comentario;

        $pen->save();


        $mensagem="Validação de Pendências de Cliente Adicionada";
        $tipo="success";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);
    }

}

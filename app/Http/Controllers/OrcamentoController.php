<?php

namespace App\Http\Controllers;

use App\Orcamento;
use App\OrcamentoDetalhe;
use App\OrcamentoEscopo;
use App\TipoAtividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PhpParser\filesInDir;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orcamentoescopo = DB::select('select sisescopo_orcamento.id as eo_id,
                                                sisescopo_orcamento.cliente as eo_cliente,
                                                sisescopo_orcamento.mensuracao_data as eo_mensuracao,
                                                sisescopo_orcamento.tecn as eo_horatecn,
                                                sisescopo_orcamento.gestao as eo_horagestao,
                                                sisescopo_orcamento.objetivo,
                                                sisescopo_orcamento.status as situacao
                                                from sisescopo_orcamento');

        return view('orcamento-create',['orcamentosescopo'=>$orcamentoescopo]);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $detorc = DB::select('   select  sisorcamento.total_horas, sisatividades.sigla, sisclientes.cnpj,sisclientes.email,sisclientes.cidade ,sisusers.nivelacesso , sisusers.name as Colaborador  , sisclientes.nomefantasia, sisorcamento.valor_total,sisprojetos.nome, sisplano_detalhe.horas_estimadas, sisplanos.tecn, sisplanos.gestao, sisorcamento.created_at
  from sisorcamento inner join sisplanos on sisorcamento.plano_id =  sisplanos.id inner join sisplano_detalhe on sisplano_detalhe.plan_id = sisplanos.id
  inner join sisatividades on sisplano_detalhe.atv_id = sisatividades.id inner join sisprojetos on sisplanos.pro_id = sisprojetos.id inner join sisclientes on sisprojetos.cli_id = sisclientes.id
  inner join sisplano_envolvidos on sisplano_envolvidos.pdet_id = sisplano_detalhe.id
  inner join sisusers on sisusers.id = sisplano_envolvidos.user_id
  where sisorcamento.plano_id='.$id);

        $atv = DB::select(' select distinct sisatividades.descricao , sisatividades.sigla
  from sisorcamento inner join sisplanos on sisorcamento.plano_id =  sisplanos.id inner join sisplano_detalhe on sisplano_detalhe.plan_id = sisplanos.id
  inner join sisatividades on sisplano_detalhe.atv_id = sisatividades.id inner join sisprojetos on sisplanos.pro_id = sisprojetos.id inner join sisclientes on sisprojetos.cli_id = sisclientes.id
  inner join sisplano_envolvidos on sisplano_envolvidos.pdet_id = sisplano_detalhe.id
  inner join sisusers on sisusers.id = sisplano_envolvidos.user_id
  where sisorcamento.plano_id='.$id);




        return view('orcamento',['orcadet'=>$detorc,'desc'=>$atv]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function adicionarOrcamentoEscopo(Request $request){

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        $orcamento = new OrcamentoEscopo();
        $orcamento->cliente = $request->cliente;
        $orcamento->projeto = $request->projeto;
        $orcamento->tecn = str_replace(" ","",str_replace(",",".",$request->tarifatecn));
        $orcamento->gestao =str_replace(" ","",str_replace(",",".",$request->tarifagestao));
        $orcamento->mensuracao_descricao = $request->mensuracao;
        $orcamento->mensuracao_data = $request->mensuracaodata;
        $orcamento->objetivo = $request->objetivo;
        $orcamento->status = 0;
        $orcamento->valor_total = 0.0;
        $orcamento->horas_totais = 0.0;

        if(\Auth::user()->nivelacesso <3){

            $orcamento->save();
            $mensagem="Orçamento Iniciado com Sucesso";
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

    public function homeEditarOrcamento($id){
        $orcamentoescopo = OrcamentoEscopo::find($id);

        $atividades = DB::select('select *,sisescopo_orcamento_detalhe.id as eod_id,
sisescopo_orcamento_detalhe.descricao as oed_decricao
		from sisescopo_orcamento_detalhe
		inner join sisescopo_orcamento on sisescopo_orcamento.id = sisescopo_orcamento_detalhe.id_eo
		inner join sistipo_atividades on sistipo_atividades.id = sisescopo_orcamento_detalhe.id_atv
		where sisescopo_orcamento_detalhe.id_eo = '.$id);

        $tipoatividade = TipoAtividade::all();
        return view('orcamento-detalhe',[
            'atividades'=>$atividades,
            'idorcamentoescopo'=>$id,
            'cliente'=>$orcamentoescopo->cliente,
            'projeto'=>$orcamentoescopo->projeto,
            'tarifatecn' =>$orcamentoescopo->tecn,
            'tarifagestao' =>$orcamentoescopo->gestao,
            'mensuracaotexto' => $orcamentoescopo->mensuracao_descricao,
            'mensuracaodata' =>$orcamentoescopo->mensuracao_data,
            'status' => $orcamentoescopo->status,
            'valortotal' => $orcamentoescopo->valor_total,
            'horastotais' => $orcamentoescopo->horas_totais,
            'tiposatividade' =>$tipoatividade

        ]);
    }


    public function adicionarAtividadeEscopoOrcamento(Request $request)
    {

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        $orcamentoescopo = OrcamentoEscopo::find($request->escopoid);

        $orcamentodetalhe = new OrcamentoDetalhe();
        $atividade = TipoAtividade::find($request->atvid);
        $orcamentodetalhe->id_atv = $request->atvid;
        $orcamentodetalhe->id_eo = $request->escopoid;
        $orcamentodetalhe->descricao = $request->descricao;
        $orcamentodetalhe->horas_estimadas = str_replace(",",".",$request->horasestimadas);

        if(\Auth::user()->nivelacesso <3){



            if($atividade->tipo == "Técnica"){
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total + ($orcamentodetalhe->horas_estimadas *$orcamentoescopo->tecn);
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais + $orcamentodetalhe->horas_estimadas;
            }
            if($atividade->tipo == "Gestão"){
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total + ($orcamentodetalhe->horas_estimadas *$orcamentoescopo->gestao);
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais + $orcamentodetalhe->horas_estimadas;
            }

            $orcamentoescopo->save();
            $orcamentodetalhe->save();

            $mensagem="Atividade adicionada com Sucesso";
            $tipo="success";
        }else{
            $mensagem="Você não tem autorização para este recurso";
            $tipo="error";

        }

//        $table->integer('id_atv')->unsigned();
//        $table->integer('id_eo')->unsigned();
//        $table->String('descricao');
//        $table->float('horas_estimadas');

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);
    }

    public function atualizarAtividadeEscopoOrcamento(Request $request,$id)
    {

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";
        $orcamentoDetalhe = OrcamentoDetalhe::find($id);
        $orcamentoescopo = OrcamentoEscopo::find($orcamentoDetalhe->id_eo);
        $atividade = TipoAtividade::find($orcamentoDetalhe->id_atv);

        $horasremover = $orcamentoDetalhe->horas_estimadas;
        $orcamentoDetalhe->horas_estimadas = str_replace(",",".",$request->horas);
        $orcamentoDetalhe->descricao = $request->descricao;


        if(\Auth::user()->nivelacesso <3){



            if($atividade->tipo == "Técnica"){
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total - ($horasremover *$orcamentoescopo->tecn);
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total + ($orcamentoDetalhe->horas_estimadas *$orcamentoescopo->tecn);
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais - $horasremover;
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais + $orcamentoDetalhe->horas_estimadas;
            }
            if($atividade->tipo == "Gestão"){
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total - ($horasremover *$orcamentoescopo->gestao);
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total + ($orcamentoDetalhe->horas_estimadas *$orcamentoescopo->gestao);
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais - $horasremover;
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais + $orcamentoDetalhe->horas_estimadas;
            }

            $orcamentoescopo->save();
            $orcamentoDetalhe->save();

            $mensagem="Detalhe atualziado com Sucesso";
            $tipo="success";
        }else{
            $mensagem="Você não tem autorização para este recurso";
            $tipo="error";

        }

//        $table->integer('id_atv')->unsigned();
//        $table->integer('id_eo')->unsigned();
//        $table->String('descricao');
//        $table->float('horas_estimadas');

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);
    }

    public function RemoverAtividadeEscopoOrcamento($id){

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";
        $orcamentoDetalhe = OrcamentoDetalhe::find($id);
        $orcamentoescopo = OrcamentoEscopo::find($orcamentoDetalhe->id_eo);
        $atividade = TipoAtividade::find($orcamentoDetalhe->id_atv);

        $horasremover = $orcamentoDetalhe->horas_estimadas;


        if(\Auth::user()->nivelacesso <3){



            if($atividade->tipo == "Técnica"){
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total - ($horasremover *$orcamentoescopo->tecn);
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais - $horasremover;
            }
            if($atividade->tipo == "Gestão"){
                $orcamentoescopo->valor_total = $orcamentoescopo->valor_total - ($horasremover *$orcamentoescopo->gestao);
                $orcamentoescopo->horas_totais = $orcamentoescopo->horas_totais - $horasremover;
            }

            $orcamentoescopo->save();
            $orcamentoDetalhe->delete();

            $mensagem="Atividade removida com Sucesso";
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

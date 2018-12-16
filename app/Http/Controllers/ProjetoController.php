<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Consultor;
use App\Gestor;
use App\OrcamentoEscopo;
use App\Projeto;
use App\ProjetoDetalhe;
use App\TipoAtividade;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $projetosquery = DB::select(' select id, id_gestor,cliente ,projeto,tecn,gestao,mensuracao_descricao,mensuracao_data,
                     objetivo,custo_total,valor_total,horas_estimadas,horas_totais,
                     horas_fim,
                     created_at,updated_at ,
                        (select sisusers.name from sisgestores inner join sisusers on 
                            sisusers.id = sisgestores.user_id and sisgestores.gest_id = b.id_gestor) gestor,
                        (select sum(sisregistros.qtd_horas) from sisregistros
                        inner join sisprojeto_detalhe on sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
                        inner join sisprojetos on sisprojetos.id = sisprojeto_detalhe.id_projeto and sisprojetos.id = b.id) 
                        as totalhorasregistradas,
                        (
                        select sum(sisprojeto_detalhe.horas_estimadas) from sisprojeto_detalhe inner join sisprojetos
                        on sisprojetos.id = sisprojeto_detalhe.id_projeto and sisprojetos.id = b.id
                        ) as totalhorasestimadas,
                        (select sum(sisprojeto_detalhe.horas_fim) from sisprojeto_detalhe inner join sisprojetos
                        on sisprojetos.id = sisprojeto_detalhe.id_projeto and sisprojetos.id = b.id
                        ) as horasfim
                        
                        from  sisprojetos b');

        foreach ($projetosquery as $p){
            $projeto = Projeto::find($p->id);
            $projeto->horas_totais = (empty($p->totalhorasregistradas)?0:$p->totalhorasregistradas);
            $projeto->horas_estimadas =(empty($p->totalhorasestimadas)?0:$p->totalhorasestimadas);
            $projeto->horas_fim = (empty($p->horasfim)?0:$p->horasfim);
            $projeto->save();
        }
        return view('projetos',['projetos' =>$projetosquery]);
    }

    public function criarProjeto($id){

       $mensagem="Erro no Controller, favor consultar API";
       $tipo="error";

        $orcamentoescopo = OrcamentoEscopo::find($id);

        if($orcamentoescopo->status ==0){
            $orcamentoDetalhes = DB::select('select * from sisescopo_orcamento_detalhe
                        inner join sisescopo_orcamento on sisescopo_orcamento.id = sisescopo_orcamento_detalhe.id_eo
                        where sisescopo_orcamento.id = '.$id);

            $projeto = new Projeto();
            $projeto->cliente = $orcamentoescopo->cliente;
            $projeto->projeto = $orcamentoescopo->projeto;
            $projeto->tecn = $orcamentoescopo->tecn;
            $projeto->gestao = $orcamentoescopo->gestao;
            $projeto->mensuracao_descricao = $orcamentoescopo->mensuracao_descricao;
            $projeto->mensuracao_data = $orcamentoescopo->mensuracao_data;
            $projeto->objetivo = $orcamentoescopo->objetivo;
            $projeto->objetivo = $orcamentoescopo->objetivo;
            $projeto->custo_total = 0.0;
            $projeto->valor_total = $orcamentoescopo->valor_total;
            $projeto->horas_totais = 0.0;
            $projeto->horas_estimadas = $orcamentoescopo->horas_totais;
            $orcamentoescopo->status = 1;



            if(\Auth::user()->nivelacesso <3){
                $orcamentoescopo->save();
                $projeto->save();

                foreach ($orcamentoDetalhes as $orc_det){
                    $pdetalhe = new ProjetoDetalhe();
                    $pdetalhe->id_tpatv = $orc_det->id_atv;
                    $pdetalhe->id_projeto = $projeto->id;
                    $pdetalhe->descricao = $orc_det->descricao;
                    $pdetalhe->horas_estimadas = $orc_det->horas_estimadas;
                    $pdetalhe->horas_reais = 0;
                    $pdetalhe->horas_fim = $orc_det->horas_estimadas;
                    $pdetalhe->save();
                }
                $mensagem="Projeto Criado com Sucesso";
                $tipo="success";
            }else{
                $mensagem="Você não tem autorização para este recurso";
                $tipo="error";

            }

        }else{
            $mensagem="Este Orçamento já está em fase de Projeto";
            $tipo="warning";
        }

       $response = array(
           'tipo' => $tipo,
           'msg' => $mensagem,

       );
       return response()->json($response);

   }

    public function projetoDetalhes($id){


        $projetodetalhesquery = DB::select('
                SELECT sisprojeto_detalhe.*,
                        (
                            select sum(sisregistros.qtd_horas) from sisregistros
                                inner join sisprojeto_detalhe on sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
                                where sisprojeto_detalhe.id_projeto =  sisprojeto_detalhe.id
                        ) as totalhorasregistradas,
                        sisprojeto_detalhe.horas_estimadas
                                -
                                (
                                     select sum(sisregistros.qtd_horas) from sisregistros
                                     inner join sisprojeto_detalhe on sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
                                    where sisprojeto_detalhe.id_projeto =  sisprojeto_detalhe.id
                                    )
                                    as horasfim,
                                          sistipo_atividades.*
                                    from sisprojeto_detalhe
                                    inner join sistipo_atividades on sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
                                    inner join sisprojetos on sisprojetos.id = sisprojeto_detalhe.id_projeto
                                    where sisprojeto_detalhe.id_projeto='.$id);
        $projeto = Projeto::find($id);
        $tiposatividade = TipoAtividade::all();
        $consultores = DB::select('select * from sisusers inner join sisconsultores on sisconsultores.user_id = sisusers.id');
        $gestores = DB::select('select * from sisusers inner join sisgestores on sisgestores.user_id = sisusers.id');

        return view('projeto-detalhe',[
            'projetodetalhesquery' => $projetodetalhesquery,
            'projeto' =>$projeto,
            'consultores' => $consultores,
            'gestores' => $gestores,
            'tiposatividade' =>$tiposatividade
        ]);

    }

    public function atualizarProjetoHeader(Request $request,$id){

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";
        $projeto = Projeto::find($id);

        $projeto->cliente = $request->cliente;
        $projeto->projeto = $request->nomeprojeto;
        $projeto->tecn = str_replace(',','.',str_replace('R$',"",str_replace(' ',"",$request->tecn)));
        $projeto->gestao = str_replace(',','.',str_replace('R$',"",str_replace(' ',"",$request->gestao)));
        $projeto->mensuracao_descricao = $request->mensuracaotexto;
        $projeto->mensuracao_data = $request->mensuracaodata;
        $projeto->id_gestor = $request->gerente;

        $projetodetalhes = DB::select('select * from sisprojeto_detalhe 
            inner join sistipo_atividades on sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
            where sisprojeto_detalhe.id_projeto = '.$id);

        $valortotalatualizandogestaotecn = 0.0;
        $valortotalhorasreais = 0.0;
        $cutototal = 0.0;
        $totalhorasreais = 0.0;
        foreach ($projetodetalhes as $projetodetalhe){
            if($projetodetalhe->tipo == "Técnica"){
                $valortotalatualizandogestaotecn = $valortotalatualizandogestaotecn +($projetodetalhe->horas_estimadas *$projeto->tecn);
                $cutototal = $cutototal + ProjetoController::retornaCustopd($projetodetalhe->id);
                $valortotalhorasreais = $projeto->tecn * ProjetoController::totalHorasReais($projetodetalhe->id);
            }else{
                $valortotalatualizandogestaotecn = $valortotalatualizandogestaotecn +($projetodetalhe->horas_estimadas *$projeto->gestao);
                $cutototal = $cutototal + ProjetoController::retornaCustopd($projetodetalhe->id);
                $valortotalhorasreais = $projeto->gestao * ProjetoController::totalHorasReais($projetodetalhe->id);
            }
            $totalhorasreais = $totalhorasreais+ProjetoController::totalHorasReais($projetodetalhe->id);
        }

        $projeto->custo_total = $cutototal;
        if($projeto->horas_estimadas > $totalhorasreais){
            $projeto->valor_total = $valortotalatualizandogestaotecn;
        }else{
            $projeto->valor_total = $valortotalhorasreais;
        }

        if(\Auth::user()->nivelacesso <3){

            $projeto->save();
            $mensagem="Projeto Atualizado com Sucesso";
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

    //Passando ID do Projeto Detalhe = Vulgo Atividade
    public function retornaCustopd($id){
        $registrosdaatividade = DB::select('select * from sisregistros 
        where sisregistros.id_projetodetalhe = '.$id);
        $custo = 0;
        foreach ($registrosdaatividade as $reg){
            $valorhora = 0;
            $consultor = DB::select('select * from sisconsultores where sisconsultores.user_id = '.$reg->id_user);
            $gestor= DB::select('select * from sisgestores where sisgestores.user_id = '.$reg->id_user);
            if(empty($gestor)){
                $consultor = Consultor::where('user_id','=',$reg->id_user);
                $valorhora = $valorhora + $consultor->custohora;
            }else{
                $gestor = Gestor::where('user_id','=',$reg->id_user);
                $valorhora = $valorhora + $consultor->custohora;
            }
            $custo = $custo + ($reg->qtd_horas *$valorhora);
        }
        return $custo;
    }

    public function totalHorasReais($idatividade){
        $registrosdaatividade = DB::select('select * from sisregistros 
        where sisregistros.id_projetodetalhe = '.$idatividade);
        $horas = 0;
        foreach ($registrosdaatividade as $reg){
            $horas = $horas+ $reg->qtd_horas;
        }
        return $horas;
    }
}

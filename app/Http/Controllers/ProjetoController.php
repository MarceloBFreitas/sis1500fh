<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\OrcamentoEscopo;
use App\Projeto;
use App\ProjetoDetalhe;
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
        $projetosquery = DB::select('  select 
	 b.* ,
	(select sum(sisprojeto_detalhe.horas_reais) from sisprojeto_detalhe 
	inner join sisprojetos a on sisprojeto_detalhe.id_projeto = b.id ) as totalhorasregistradas
	from  sisprojetos b');

        foreach ($projetosquery as $p){
            $projeto = Projeto::find($p->id);
            $projeto->horas_totais = $p->totalhorasregistradas;
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
        $projeto = Projeto::find($id);
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
                    where sisprojeto_detalhe.id_projeto='.$projeto->id);

        foreach ($projetodetalhesquery as $query){
            $projetodetalhe = ProjetoDetalhe::find($query->id);
            $totalhoras = 0;
            $horasfim = 0;
            if(empty($query->totalhorasregistradas)){
                $projetodetalhe->horas_reais = $totalhoras;
            }else{
                $projetodetalhe->horas_reais = $query->totalhorasregistradas;
            }
            if(empty($query->horasfim)){
                $projetodetalhe->horas_reais = $horasfim;
            }else{
                $projetodetalhe->horas_reais = $query->totalhorasregistradas;
            }
            $projetodetalhe->save();
        }

        return view('projeto-detalhe',[
            'projetodetalhesquery' => $projetodetalhesquery,
            'projeto' =>$projeto
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

        $projetodetalhes = DB::select('select * from sisprojeto_detalhe 
            inner join sistipo_atividades on sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
            where sisprojeto_detalhe.id_projeto = '.$id);

        $valortotal = 0;
        $cutototal = 0;
        foreach ($projetodetalhes as $projetodetalhe){
            if($projetodetalhe->tipo == "Técnica"){
                $valortotal = $valortotal +($projetodetalhe->horas_estimadas *$projeto->tecn);
                $cutototal = $cutototal + retornaCusto($projetodetalhe->id);
            }else{
                $valortotal = $valortotal +($projetodetalhe->horas_estimadas *$projeto->gestao);
            }
        }


//        $table->float('valor_total');




        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );
        return response()->json($response);

    }

    //Passando ID do Projeto Detalhe = Vulgo Atividade
    private function retornaCusto($id){
        $projetodetalhe = ProjetoDetalhe::find($id);

        $registrosdaatividade = DB::select('select * from sisregistros 
        where sisregistros.id_projetodetalhe = '.$id);

        foreach ($registrosdaatividade as $reg){
            $user = User::find($reg->id_user);
        }
    }
}

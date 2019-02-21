<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Consultor;
use App\ExplosaoAtv;
use App\Gestor;
use App\OrcamentoEscopo;
use App\Projeto;
use App\ProjetoDetalhe;
use App\TipoAtividade;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;


class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $projetosquery = DB::select(' select id,status, id_gestor,cliente ,projeto,tecn,gestao,mensuracao_descricao,mensuracao_data,
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
            $projeto->custo_total = 0.0;
            $projeto->valor_total = 0.0;
            $projeto->valor_planejado = $orcamentoescopo->valor_total;
            $projeto->status ='execucao';


            $projeto->horas_totais = 0.0;
            $projeto->horas_estimadas = $orcamentoescopo->horas_totais;
            $projeto->horas_fim = $orcamentoescopo->horas_totais;




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


                $projetodetalhes = DB::select(' select *,
                                     (
                                                select sum(sisregistros.qtd_horas) from sisprojeto_detalhe 
                                        inner join sisregistros on sisregistros.id_projetodetalhe = sisprojeto_detalhe.id
                                        where sisprojeto_detalhe.id = spd.id
                                                and sisprojeto_detalhe.id_responsavel = spd.id_responsavel
                                     ) horasreais,
                                     (
                                     select sisgestores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoragestor,
                                     (
                                     select sisconsultores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoraconsultor
                                    
                                      from sisprojeto_detalhe spd
                                      inner join sistipo_atividades on sistipo_atividades.id = spd.id_tpatv
                                       where spd.id_projeto = '.$projeto->id);

                $custototal = 0.0;
                $valortotal = 0.0;
                $valoestimado = 0.0;
                $horasestimadas = 0.0;
                $horastotais = 0.0;
                $horasfim = 0.0;

                foreach ($projetodetalhes as $projetodetalhe){
                    //custo real
                    if(empty($projetodetalhe->custohoraconsultor)){
                        $custotemp = $projetodetalhe->custohoragestor;
                        if(!empty($projetodetalhe->horasreais)){
                            $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                        }
                    }else{
                        $custotemp = $projetodetalhe->custohoraconsultor;
                        if(!empty($projetodetalhe->horasreais)){
                            $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                        }
                    }
                    $horasestimadas = $horasestimadas + $projetodetalhe->horas_estimadas;

                    if(!empty($projetodetalhe->horasreais)){
                        $horastotais = $horastotais+$projetodetalhe->horasreais;
                    }
                    if($projetodetalhe->tipo == "Técnica"){
                        $valoestimado = $valoestimado + ($projeto->tecn *$projetodetalhe->horas_estimadas);
                        $valortotal = $valortotal + ($projeto->tecn * $projetodetalhe->horasreais);
                    }else{
                        $valoestimado = $valoestimado + ($projeto->gestao *$projetodetalhe->horas_estimadas);
                        $valortotal = $valortotal + ($projeto->gestao * $projetodetalhe->horasreais);
                    }
                }

                $horasfim = $horasestimadas - $horastotais;

                $projeto->custo_total = $custototal;
                $projeto->valor_total = $valortotal;
                $projeto->valor_planejado = $valoestimado;
                $projeto->horas_estimadas = $horasestimadas;
                $projeto->horas_totais = $horastotais;
                $projeto->horas_fim = $horasfim;

                $projeto->save();

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


        $projetodetalhesquery = DB::select('SELECT
  sisprojeto_detalhe.descricao descri,sisprojeto_detalhe.horas_estimadas horas_estimadas_det ,
   sisprojeto_detalhe.horas_fim horas_fim_det ,
  *,
  sisusers.name AS responsavel,
  sisusers.id AS userid,
  sisprojeto_detalhe.id AS id_projetodetalhe,
  sistipo_atividades.*,
  (SELECT
    SUM(sisregistros.qtd_horas)
  FROM sisregistros
  INNER JOIN sisprojeto_detalhe
    ON sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
  WHERE sisprojeto_detalhe.id_projeto = sisprojeto_detalhe.id)
  AS totalhorasregistradas,
  sisprojeto_detalhe.horas_estimadas
  - (SELECT
    SUM(sisregistros.qtd_horas)
  FROM sisregistros
  INNER JOIN sisprojeto_detalhe
    ON sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
  WHERE sisprojeto_detalhe.id_projeto = sisprojeto_detalhe.id)
  AS horasfim
FROM sisprojeto_detalhe
INNER JOIN sistipo_atividades
  ON sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
INNER JOIN sisprojetos
  ON sisprojetos.id = sisprojeto_detalhe.id_projeto
LEFT JOIN sisusers
  ON sisusers.id = sisprojeto_detalhe.id_responsavel
WHERE sisprojeto_detalhe.id_projeto = '.$id);


        $projetodetalhesfiltradahorasfimquery = DB::select('SELECT
  sisprojeto_detalhe.descricao descri,sisprojeto_detalhe.horas_estimadas horas_estimadas_det ,
   sisprojeto_detalhe.horas_estimadas horas_fim_det ,
  *,
  sisusers.name AS responsavel,
  sisusers.id AS userid,
  sisprojeto_detalhe.id AS id_projetodetalhe,
  sistipo_atividades.*,
  (SELECT
    SUM(sisregistros.qtd_horas)
  FROM sisregistros
  INNER JOIN sisprojeto_detalhe
    ON sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
  WHERE sisprojeto_detalhe.id_projeto = sisprojeto_detalhe.id)
  AS totalhorasregistradas,
  sisprojeto_detalhe.horas_estimadas
  - (SELECT
    SUM(sisregistros.qtd_horas)
  FROM sisregistros
  INNER JOIN sisprojeto_detalhe
    ON sisprojeto_detalhe.id = sisregistros.id_projetodetalhe
  WHERE sisprojeto_detalhe.id_projeto = sisprojeto_detalhe.id)
  AS horasfim
FROM sisprojeto_detalhe
INNER JOIN sistipo_atividades
  ON sistipo_atividades.id = sisprojeto_detalhe.id_tpatv
INNER JOIN sisprojetos
  ON sisprojetos.id = sisprojeto_detalhe.id_projeto
LEFT JOIN sisusers
  ON sisusers.id = sisprojeto_detalhe.id_responsavel
WHERE 
sisprojeto_detalhe.horas_fim >0 and
sisprojeto_detalhe.id_projeto = '.$id);






        $projeto = Projeto::find($id);

        $projetodetalhes = DB::select(' select *,
                                     (
                                                select sum(sisregistros.qtd_horas) from sisprojeto_detalhe 
                                        inner join sisregistros on sisregistros.id_projetodetalhe = sisprojeto_detalhe.id
                                        where sisprojeto_detalhe.id = spd.id
                                                and sisprojeto_detalhe.id_responsavel = spd.id_responsavel
                                     ) horasreais,
                                     (
                                     select sisgestores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoragestor,
                                     (
                                     select sisconsultores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoraconsultor
                                    
                                      from sisprojeto_detalhe spd
                                      inner join sistipo_atividades on sistipo_atividades.id = spd.id_tpatv
                                       where spd.id_projeto = '.$projeto->id);

        $custototal = 0.0;
        $valortotal = 0.0;
        $valoestimado = 0.0;
        $horasestimadas = 0.0;
        $horastotais = 0.0;
        $horasfim = 0.0;

        foreach ($projetodetalhes as $projetodetalhe){
            //custo real
            if(empty($projetodetalhe->custohoraconsultor)){
                $custotemp = $projetodetalhe->custohoragestor;
                if(!empty($projetodetalhe->horasreais)){
                    $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                }
            }else{
                $custotemp = $projetodetalhe->custohoraconsultor;
                if(!empty($projetodetalhe->horasreais)){
                    $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                }
            }
            $horasestimadas = $horasestimadas + $projetodetalhe->horas_estimadas;

            if(!empty($projetodetalhe->horasreais)){
                $horastotais = $horastotais+$projetodetalhe->horasreais;
            }
            if($projetodetalhe->tipo == "Técnica"){
                $valoestimado = $valoestimado + ($projeto->tecn *$projetodetalhe->horas_estimadas);
                $valortotal = $valortotal + ($projeto->tecn * $projetodetalhe->horasreais);
            }else{
                $valoestimado = $valoestimado + ($projeto->gestao *$projetodetalhe->horas_estimadas);
                $valortotal = $valortotal + ($projeto->gestao * $projetodetalhe->horasreais);
            }
        }

        $horasfim = $horasestimadas - $horastotais;

        $projeto->custo_total = $custototal;
        $projeto->valor_total = $valortotal;

        $projeto->valor_planejado = $valoestimado;

        $projeto->horas_estimadas = $horasestimadas;
        $projeto->horas_totais = $horastotais;
        $projeto->horas_fim = $horasfim;

        $projeto->save();


        $tiposatividade = TipoAtividade::all();
        $consultores = DB::select('select * from sisusers inner join sisconsultores on sisconsultores.user_id = sisusers.id');
        $gestores = DB::select('select * from sisusers inner join sisgestores on sisgestores.user_id = sisusers.id');

        $usuarios = DB::select('	select * from sisusers 
                   left join sisgestores on sisusers.id = sisgestores.user_id
                   left join sisconsultores on sisconsultores.user_id =sisusers.id');


        $baseline = db::select(' select count(*) dados from sisbaseline where sisbaseline.id_projeto ='.$projeto->id);
        $flag = 0;
        foreach ($baseline as $b){
            if($b->dados > 0){
                $flag = 1;
            }else{
                $flag = 0;
            }

        }

        return view('projeto-detalhe',[
            'projetodetalhesquery' => $projetodetalhesquery,
            'projeto' =>$projeto,
            'consultores' => $consultores,
            'gestores' => $gestores,
            'tiposatividade' =>$tiposatividade,
            'usuarios' => $usuarios,
            'flag'=>$flag,
            'projetodetalhesfiltradahorasfimquery' => $projetodetalhesfiltradahorasfimquery
        ]);

    }

    public function atribuirUserAtividade(Request $request){
        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        //return "ERRO:".$request->iduser."-".$request->idprodet;

        $projetodetalhe = ProjetoDetalhe::find($request->idprodet);

        $projetodetalhe->id_responsavel = $request->iduser;

        if(\Auth::user()->nivelacesso <3){
            $projetodetalhe->save();
            $mensagem="Usuário Envolvido com Sucesso";
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


    public function removerProjetoDetalhe($id){
        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";

        $projetodetalhe = ProjetoDetalhe::find($id);
        $idprojeto = $projetodetalhe->id_projeto;


        if(\Auth::user()->nivelacesso <3){
            try{
                DB::statement('ALTER TABLE [dbo].[sisprojeto_detalhe]  NOCHECK CON STRAINT [sisprojeto_detalhe_id_responsavel_foreign] ');
                $projetodetalhe->delete();
                DB::statement('ALTER TABLE [dbo].[sisprojeto_detalhe]  WITH CHECK CHECK CONSTRAINT [sisprojeto_detalhe_id_responsavel_foreign]');
                $mensagem="Atividade Removida com Sucesso";
                $tipo="success";
            }catch (\Exception $e){
                $mensagem="Existem registros de horas nesta atividade";
                $tipo="error";
            }
        }else{
            $mensagem="Você não tem autorização para este recurso";
            $tipo="error";

        }

        $projeto = Projeto::find($idprojeto);

        $projetodetalhes = DB::select(' select *,
                                     (
                                                select sum(sisregistros.qtd_horas) from sisprojeto_detalhe 
                                        inner join sisregistros on sisregistros.id_projetodetalhe = sisprojeto_detalhe.id
                                        where sisprojeto_detalhe.id = spd.id
                                                and sisprojeto_detalhe.id_responsavel = spd.id_responsavel
                                     ) horasreais,
                                     (
                                     select sisgestores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoragestor,
                                     (
                                     select sisconsultores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoraconsultor
                                    
                                      from sisprojeto_detalhe spd
                                      inner join sistipo_atividades on sistipo_atividades.id = spd.id_tpatv
                                       where spd.id_projeto = '.$projeto->id);

        $custototal = 0.0;
        $valortotal = 0.0;
        $valoestimado = 0.0;
        $horasestimadas = 0.0;
        $horastotais = 0.0;
        $horasfim = 0.0;

        foreach ($projetodetalhes as $projetodetalhe){
            //custo real
            if(empty($projetodetalhe->custohoraconsultor)){
                $custotemp = $projetodetalhe->custohoragestor;
                if(!empty($projetodetalhe->horasreais)){
                    $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                }
            }else{
                $custotemp = $projetodetalhe->custohoraconsultor;
                if(!empty($projetodetalhe->horasreais)){
                    $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                }
            }
            $horasestimadas = $horasestimadas + $projetodetalhe->horas_estimadas;

            if(!empty($projetodetalhe->horasreais)){
                $horastotais = $horastotais+$projetodetalhe->horasreais;
            }
            if($projetodetalhe->tipo == "Técnica"){
                $valoestimado = $valoestimado + ($projeto->tecn *$projetodetalhe->horas_estimadas);
                $valortotal = $valortotal + ($projeto->tecn * $projetodetalhe->horasreais);
            }else{
                $valoestimado = $valoestimado + ($projeto->gestao *$projetodetalhe->horas_estimadas);
                $valortotal = $valortotal + ($projeto->gestao * $projetodetalhe->horasreais);
            }
        }

        $horasfim = $horasestimadas - $horastotais;

        $projeto->custo_total = $custototal;
        $projeto->valor_total = $valortotal;

        $projeto->valor_planejado = $valoestimado;

        $projeto->horas_estimadas = $horasestimadas;
        $projeto->horas_totais = $horastotais;
        $projeto->horas_fim = $horasfim;

        $projeto->save();




        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,
        );
        return response()->json($response);
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
                $gestor = DB::select('select custohora from sisgestores where sisgestores.user_id ='.$reg->id_user);
                foreach ($gestor as $g){
                    $valorhora = $valorhora + $g->custohora;
                }
            }
            $custo = $custo + ($reg->qtd_horas *$valorhora);
        }
        return $custo;
    }

    public function adicionarAtividadeProjetoDetalhe(Request $request){

        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";
        $projetodetalhe = new ProjetoDetalhe();
        $projetodetalhe->id_tpatv = $request->atvid;
        $projetodetalhe->id_projeto = $request->idprojeto;
        $projetodetalhe->descricao = $request->descricao;
        $projetodetalhe->horas_estimadas = str_replace(',','.',$request->horasestimadas);
        $projetodetalhe->horas_reais = 0.0;
        $projetodetalhe->horas_fim = str_replace(',','.',$request->horasestimadas);




        if(\Auth::user()->nivelacesso <3){
            $projetodetalhe->save();

            $projeto = Projeto::find($request->idprojeto);
            $projetodetalhes = DB::select(' select *,
                                     (
                                                select sum(sisregistros.qtd_horas) from sisprojeto_detalhe 
                                        inner join sisregistros on sisregistros.id_projetodetalhe = sisprojeto_detalhe.id
                                        where sisprojeto_detalhe.id = spd.id
                                                and sisprojeto_detalhe.id_responsavel = spd.id_responsavel
                                     ) horasreais,
                                     (
                                     select sisgestores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoragestor,
                                     (
                                     select sisconsultores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoraconsultor
                                    
                                      from sisprojeto_detalhe spd
                                      inner join sistipo_atividades on sistipo_atividades.id = spd.id_tpatv
                                       where spd.id_projeto = '.$projeto->id);

            $custototal = 0.0;
            $valortotal = 0.0;
            $valoestimado = 0.0;
            $horasestimadas = 0.0;
            $horastotais = 0.0;
            $horasfim = 0.0;

            foreach ($projetodetalhes as $projetodetalhe){
                //custo real
                if(empty($projetodetalhe->custohoraconsultor)){
                    $custotemp = $projetodetalhe->custohoragestor;
                    if(!empty($projetodetalhe->horasreais)){
                        $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                    }
                }else{
                    $custotemp = $projetodetalhe->custohoraconsultor;
                    if(!empty($projetodetalhe->horasreais)){
                        $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                    }
                }
                $horasestimadas = $horasestimadas + $projetodetalhe->horas_estimadas;

                if(!empty($projetodetalhe->horasreais)){
                    $horastotais = $horastotais+$projetodetalhe->horasreais;
                }
                if($projetodetalhe->tipo == "Técnica"){
                    $valoestimado = $valoestimado + ($projeto->tecn *$projetodetalhe->horas_estimadas);
                    $valortotal = $valortotal + ($projeto->tecn * $projetodetalhe->horasreais);
                }else{
                    $valoestimado = $valoestimado + ($projeto->gestao *$projetodetalhe->horas_estimadas);
                    $valortotal = $valortotal + ($projeto->gestao * $projetodetalhe->horasreais);
                }
            }

            $horasfim = $horasestimadas - $horastotais;

            $projeto->custo_total = $custototal;
            $projeto->valor_total = $valortotal;

            $projeto->valor_planejado = $valoestimado;

            $projeto->horas_estimadas = $horasestimadas;
            $projeto->horas_totais = $horastotais;
            $projeto->horas_fim = $horasfim;

            $projeto->save();

            $mensagem="Atividade Adicionada com Sucesso ao Projeto";
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

    public function atualizarProjetoDetalhe(Request $request){
        $mensagem="Erro no Controller, favor consultar API";
        $tipo="error";
        $projetodetalhe = ProjetoDetalhe::find($request->idprojetodetalhe);
        $projetodetalhe->horas_estimadas = str_replace(',','.',$request->horasestimadas);
        $projetodetalhe->horas_fim = str_replace(',','.',$request->horasfim);
        $projetodetalhe->predecessora = str_replace(" ",",",str_replace("-",",",str_replace(';',',',$request->tarefas)));


        if(\Auth::user()->nivelacesso <3){
            $idprojeto = $projetodetalhe->id_projeto;
            $projetodetalhe->save();
            $projeto = Projeto::find($idprojeto);
            $projetodetalhes = DB::select(' select *,
                                     (
                                                select sum(sisregistros.qtd_horas) from sisprojeto_detalhe 
                                        inner join sisregistros on sisregistros.id_projetodetalhe = sisprojeto_detalhe.id
                                        where sisprojeto_detalhe.id = spd.id
                                                and sisprojeto_detalhe.id_responsavel = spd.id_responsavel
                                     ) horasreais,
                                     (
                                     select sisgestores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoragestor,
                                     (
                                     select sisconsultores.custohora from sisusers 
                                       left join sisgestores on sisusers.id = sisgestores.user_id
                                       left join sisconsultores on sisconsultores.user_id =sisusers.id
                                       where sisusers.id = spd.id_responsavel
                                     ) custohoraconsultor
                                    
                                      from sisprojeto_detalhe spd
                                      inner join sistipo_atividades on sistipo_atividades.id = spd.id_tpatv
                                       where spd.id_projeto = '.$projeto->id);

            $custototal = 0.0;
            $valortotal = 0.0;
            $valoestimado = 0.0;
            $horasestimadas = 0.0;
            $horastotais = 0.0;
            $horasfim = 0.0;

            foreach ($projetodetalhes as $projetodetalhe){
                //custo real
                if(empty($projetodetalhe->custohoraconsultor)){
                    $custotemp = $projetodetalhe->custohoragestor;
                    if(!empty($projetodetalhe->horasreais)){
                        $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                    }
                }else{
                    $custotemp = $projetodetalhe->custohoraconsultor;
                    if(!empty($projetodetalhe->horasreais)){
                        $custototal = $custototal + ($projetodetalhe->horasreais *$custotemp );
                    }
                }
                $horasestimadas = $horasestimadas + $projetodetalhe->horas_estimadas;

                if(!empty($projetodetalhe->horasreais)){
                    $horastotais = $horastotais+$projetodetalhe->horasreais;
                }
                if($projetodetalhe->tipo == "Técnica"){
                    $valoestimado = $valoestimado + ($projeto->tecn *$projetodetalhe->horas_estimadas);
                    $valortotal = $valortotal + ($projeto->tecn * $projetodetalhe->horasreais);
                }else{
                    $valoestimado = $valoestimado + ($projeto->gestao *$projetodetalhe->horas_estimadas);
                    $valortotal = $valortotal + ($projeto->gestao * $projetodetalhe->horasreais);
                }
            }

            $horasfim = $horasestimadas - $horastotais;

            $projeto->custo_total = $custototal;
            $projeto->valor_total = $valortotal;

            $projeto->valor_planejado = $valoestimado;

            $projeto->horas_estimadas = $horasestimadas;
            $projeto->horas_totais = $horastotais;
            $projeto->horas_fim = $horasfim;

            $projeto->save();

            $mensagem="Atividade Atualizada com Sucesso ao Projeto";
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
    public function finalProjeto(Request $request){
        $pro = Projeto::find($request->id);
        $pro->status = 'finalizado';
        $pro->save();
        $mensagem="projeto finalizado";
        $tipo="success";

        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );

        return response()->json($response);

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

    public function visualizarAtividades($idprojeto){

        $projetodetalhes = DB::select('select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$idprojeto);

        $nodes = array();
        $edges = array();

        foreach($projetodetalhes as $projetodetalhe){
            if(empty($projetodetalhe->predecessora) || $projetodetalhe->predecessora ==0){
                array_push($edges,'{from: 1, to: '.$projetodetalhe->id.'},');
            }else{

            }
            $pred = explode(",",$projetodetalhe->predecessora);

            for ($i = 1; $i <= 10; $i++) {
                //echo $i;
            }

            array_push($edges,'{from: 1, to: '.$projetodetalhe->id.'},');

        }

        return view('visualizar',[
            'idprojeto' => $idprojeto
        ]);
    }

    public function adddatainiciofiltro(Request $request){
        $prodetf = ProjetoDetalhe::find($request->id);

        $prodetf->data_inicio = $request->data;
        $prodetf->save();

        $tipo='success';
        $mensagem='Data de inicio adicionada';
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );

         return response()->json($response);


    }

    public function adddatainicio(Request $request){
        $prodetf = ProjetoDetalhe::find($request->id);

        $prodetf->data_inicio = $request->data;
        $prodetf->save();

        $tipo='success';
        $mensagem='Data de inicio adicionada';
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );

         return response()->json($response);


    }



    public function explosao($id){
        $projetosdetalhes = DB::select('  SELECT * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto ='.$id.'  order by predecessora,id');
        $mensagem = "Por favor, todas as atividades do projeto devem possuir um responsável";
        $tipo = "error";


        foreach ($projetosdetalhes as $pdetalhe){
            if(empty($pdetalhe->id_responsavel)){
                $response = array(
                    'tipo' => $tipo,
                    'msg' => $mensagem,

                );
                return response()->json($response);
            }

            elseif($pdetalhe->predecessora == null && $pdetalhe->data_inicio == null){


                $response = "Atividades com predecessoras null deverão conter data inicial obrigatorio";

                $response = array(
                    'tipo' => $tipo,
                    'msg' => $response,

                );
                return response()->json($response);
            }

        }


        $horasconsultorint=0;
        $tabpredec = array(); // array da logica das datas


        foreach ($projetosdetalhes as $pdetalhe) {




            $horasconsultor = DB::select('
              select horas_por_dia from sisconsultores inner join sisusers on sisconsultores.cons_id = sisusers.id
              inner join sisprojeto_detalhe on sisprojeto_detalhe.id_responsavel = sisconsultores.cons_id
              where sisprojeto_detalhe.id_responsavel ='.$pdetalhe->id_responsavel);//podeser gestor mudar o select left join



            foreach ($horasconsultor as $horas) {
                $horasconsultorint = $horas->horas_por_dia;
            }


            $Todaldias = $pdetalhe->horas_estimadas / $horasconsultorint;

            if( $pdetalhe->horas_estimadas % $horasconsultorint == 0){

            }else{

                $Todaldias = (int) $Todaldias;
                $Todaldias ++;

            }





            $auxtotoaldia = $Todaldias;
            $pred = $pdetalhe->predecessora;
            $diatemp = 0;




            if ($pdetalhe->predecessora ==  NULL) {

                // atrubuir data inicio no array
                date('d/m/Y', strtotime($pdetalhe->data_inicio));
                $interno = array($pdetalhe->id, date('y/m/d', strtotime($pdetalhe->data_inicio)));


                while ($Todaldias != 0) {



                    $pdetexplo = new ExplosaoAtv();


                    $pdetexplo->id_microatv = $pdetalhe->id;
                    $pdetexplo->id_tpatv = $pdetalhe->id_tpatv;

                    $pdetexplo->id_projeto = $pdetalhe->id_projeto;

                    $pdetexplo->id_responsavel = $pdetalhe->id_responsavel;

                    $pdetexplo->descricao = $pdetalhe->descricao;
                    $pdetexplo->horas_estimadas = $pdetalhe->horas_estimadas;
                    $pdetexplo->horas_reais = $pdetalhe->horas_reais;
                    $pdetexplo->horas_fim = $pdetalhe->horas_fim;
                    $pdetexplo->predecessora = $pdetalhe->predecessora;
                    $pdetexplo->explosao = $pdetalhe->explosao;



                    $pdetexplo->horas_estimadas = $horasconsultorint;
                    $pdetexplo->horas_fim = $horasconsultorint;



                    $dia = $interno[1];
                    if( $Todaldias != $auxtotoaldia) {
                        $pdetexplo->data_inicio = $dia;
                        $pdetexplo->data_fim = $dia;
                        $novadata = $dia;

                    }else {

                        $auxnovadata = explode("/", $dia);
                        $novadata = "20" . $auxnovadata[0] . "-" . $auxnovadata[1] . "-" . $auxnovadata[2];

                        $pdetexplo->data_inicio = $novadata;
                        $pdetexplo->data_fim = $novadata;
                    }


                    $pdetexplo->save();






                    $dia = DB::select("select DATEADD (day , 1 ,CAST('$novadata'AS DATE)) as ndata");

                    $diaf="";
                    foreach ($dia as $nd){
                        $diaf = $nd->ndata;
                    }


                     $interno[1] = $diaf;





                     $aux = 0;


                    $obj = new ProjetoController();
                    while ($aux == 0 ) {



                        $semana = DB::select("select DATEPART(weekday,'$diaf')as semana");
                        $resultsemana = "";

                               foreach ($semana as $res){
                                   $resultsemana = $res->semana;
                               }




                        if ($resultsemana == 1 or $resultsemana == 7) {


                            //$dia = $interno[1];
                            //$auxnovadata = explode("/",$dia);
                            $novadata = $interno[1];//"20".$auxnovadata[0]."-".$auxnovadata[1]."-".$auxnovadata[2];

                            if($resultsemana == 7) {
                                $dia = DB::select("select DATEADD (day , 2 ,CAST('$novadata'AS DATE)) as ndata");
                            }else {
                                $dia = DB::select("select DATEADD (day , 1 ,CAST('$novadata'AS DATE)) as ndata");
                            }
                            $diaf="";
                            foreach ($dia as $nd){
                                $diaf = $nd->ndata;
                            }


                            $interno[1] = $diaf;






                        }elseif($obj->testeferiado($interno[1])) {


                                    $novadata = $interno[1];//"20".$auxnovadata[0]."-".$auxnovadata[1]."-".$auxnovadata[2];



                                    $dia = DB::select("select DATEADD (day , 1 ,CAST('$novadata'AS DATE)) as ndata");

                                    $diaf="";
                                    foreach ($dia as $nd){
                                        $diaf = $nd->ndata;
                                    }


                                    $interno[1] = $diaf;

                                }else{
                                     $aux =2;
                                }








                    }

                    $Todaldias = $Todaldias-1;






                }


                array_push($tabpredec,$interno);


            }
            else {


                $dataini ="";
                foreach ($tabpredec as $arr) {

                    if ($pdetalhe->predecessora == $arr[0]) {

                        $dataini = $arr[1];
                    }
                }
                    $interno = array($pdetalhe->id, $dataini);
               // return $dataini;


                while ($Todaldias != 0) {



                    $pdetexplo = new ExplosaoAtv();

                    $pdetexplo->id_microatv = $pdetalhe->id;
                    $pdetexplo->id_tpatv = $pdetalhe->id_tpatv;
                    $pdetexplo->id_projeto = $pdetalhe->id_projeto;

                    $pdetexplo->id_responsavel = $pdetalhe->id_responsavel;


                    $pdetexplo->descricao = $pdetalhe->descricao;
                    $pdetexplo->horas_estimadas = $pdetalhe->horas_estimadas;
                    $pdetexplo->horas_reais = $pdetalhe->horas_reais;
                    $pdetexplo->horas_fim = $pdetalhe->horas_fim;
                    $pdetexplo->predecessora = $pdetalhe->predecessora;
                    $pdetexplo->explosao = $pdetalhe->explosao;


                    $pdetexplo->horas_estimadas = $horasconsultorint;
                    $pdetexplo->horas_fim = $horasconsultorint;

                    $pdetexplo->data_inicio = $interno[1];
                    $pdetexplo->data_fim = $interno[1];





                    $pdetexplo->save();


                    $novadata = $interno[1];//"20".$auxnovadata[0]."-".$auxnovadata[1]."-".$auxnovadata[2];


                    $diaf = DB::select("select DATEADD (day , 1 ,CAST('$novadata'AS DATE)) as ndata");
                    $diasoma ="";
                    foreach ($diaf as $dia) {
                        $diasoma = $dia->ndata;
                    }

                    $interno[1] = $diasoma;

                    $aux = 0;


                    $obj = new ProjetoController();



                    while ($aux == 0) {


                        $semana = DB::select("select DATEPART(weekday,'$interno[1]')as semana");
                        $resultsemana = "";


                        foreach ($semana as $res) {
                            $resultsemana = $res->semana;
                        }


                        if ($resultsemana == 1 or $resultsemana == 7) {


                            //$dia = $interno[1];
                            //$auxnovadata = explode("/",$dia);
                            $novadata = $interno[1];//"20".$auxnovadata[0]."-".$auxnovadata[1]."-".$auxnovadata[2];

                            if ($resultsemana == 7) {
                                $dia = DB::select("select DATEADD (day , 2 ,CAST('$novadata'AS DATE)) as ndata");
                            } else {
                                $dia = DB::select("select DATEADD (day , 1 ,CAST('$novadata'AS DATE)) as ndata");
                            }
                            $diaf = "";
                            foreach ($dia as $nd) {
                                $diaf = $nd->ndata;
                            }


                            $interno[1] = $diaf;


                        } elseif ($obj->testeferiado($interno[1])) {


                            $novadata = $interno[1];//"20".$auxnovadata[0]."-".$auxnovadata[1]."-".$auxnovadata[2];


                            $dia = DB::select("select DATEADD (day , 1 ,CAST('$novadata'AS DATE)) as ndata");

                            $diaf = "";
                            foreach ($dia as $nd) {
                                $diaf = $nd->ndata;
                            }


                            $interno[1] = $diaf;

                        } else {

                            $aux = 2;
                        }


                    }

                    $Todaldias = $Todaldias -1;


                }
                array_push($tabpredec,$interno);
            }

        }




        foreach ($projetosdetalhes as $trocadata){

            $prodet = ProjetoDetalhe::find($trocadata->id);


            $datas = DB::select('    select MAX(data_fim)as maxima ,min(data_inicio) as minima from sis_explosao_atv  where sis_explosao_atv.id_microatv = '.$trocadata->id);

            $datafim="";
            $dataini="";

            foreach ($datas as $d){
                $datafim=$d->maxima;
                $dataini=$d->minima;

            }



                $prodet->data_inicio = $dataini;
                $prodet->data_fim = $datafim;
            $prodet->explosao = 'programada';
            $prodet->save();

        }


        $mensagem="Projeto Programado";

        $tipo = "succes";
        $response = array(
            'tipo' => $tipo,
            'msg' => $mensagem,

        );

        return response()->json($response);

    }

    public  function  testeferiado($dia){


        $testedia =  DB::select("select COUNT(*) as diaferiado from sisferiados where sisferiados.data_feriado = "."'".$dia."'");
        $teste = "";
        foreach ($testedia as $t){
            $teste = $t->diaferiado;
        }
       if($teste == 1){
           return true;

       }else{
           return false;
       }

    }


}

<?php

namespace App\Http\Controllers;

use App\Orcamento;
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

                  $orc = DB::select('  select sisorcamento.id,sisorcamento.plano_id , sisclientes.nomefantasia, sisprojetos.nome, sisorcamento.valor_total
                                        from sisorcamento 
                                        inner join sisplanos on sisorcamento.plano_id = sisplanos.id
                                        inner join sisprojetos on sisprojetos.id = sisplanos.pro_id 
                                        inner join sisclientes on sisclientes.id = sisprojetos.cli_id ');

        return view('orcamento-pesquisa',['orca'=>$orc]);

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

    public function criaorc(Request $request){


        $orcamento = new Orcamento();

        $aux = DB::select( 'select sum(sisplano_detalhe.horas_estimadas) as horas from sisplano_detalhe where sisplano_detalhe.plan_id ='.$request->idplanos);

        $horas=0;
        foreach ($aux as $a){
            $horas= $a->horas;
        }

        $orcamento->total_horas = $horas;
        $orcamento->valor_total = $request->val;
        $orcamento->plano_id = $request->idplanos;




        if(\Auth::user()->nivelacesso <3){
           $orcamento->save();
           $pega=0;
           $pegaid = DB ::select('select sisorcamento.id from sisorcamento where sisorcamento.plano_id='.$orcamento->plano_id);

           foreach ($pegaid as $p){
               $pega= $p->id;
           }

            $this->show($orcamento->plano_id);



        }else{
            $mensagem="Erro ao Atualizar Atividade";
            $tipo="error";
            $response = array(
                'tipo' => $tipo,
                'msg' => $mensagem,

            );
            return response()->json($response);
        }

    }


    public function update(Request $request, $id)
    {
        //
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

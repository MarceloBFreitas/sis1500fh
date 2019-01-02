<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Foto;
use App\FotoDetalhe;

class Tirarfoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foto:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'criação de fotos a cada semana';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projetos =  DB::select('select * from sisprojetos');

        foreach ($projetos as $projeto){
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
            $foto->data_foto= date('d/m/y');

            $foto->save();
            $det = DB::select('  select * from sisprojeto_detalhe where sisprojeto_detalhe.id_projeto = '.$projeto->id);

            foreach ($det as $projetosdetalhe){
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



        }






    }
}

<?php

use Illuminate\Database\Seeder;

class EscopoOrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OrcamentoEscopo::create([
            'cliente'=>'BIC',
            'projeto' =>'Assistente Virtual',
            'tecn' => 150.00,
            'gestao' => 250.00,
            'mensuracao_descricao' =>'4 Semanas',
            'mensuracao_data' => '2018-12-23',
            'objetivo' => 'Desenvolver um BOT',
            'status'=>0,
            'valor_total'=>4000,
            'horas_totais'=>20
        ]);
    }
}

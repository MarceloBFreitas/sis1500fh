<?php

use Illuminate\Database\Seeder;

class DetalheEscopoOrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OrcamentoDetalhe::create([
            'id_atv' => 1,
            'id_eo'=>1,
            'descricao' => 'Desenho da Infraestrutura do Bot',
            'horas_estimadas' =>10
        ]);

        \App\OrcamentoDetalhe::create([
            'id_atv' => 2,
            'id_eo'=>1,
            'descricao' => 'Migrar BigQuery para Redshift',
            'horas_estimadas' =>10
        ]);
    }
}

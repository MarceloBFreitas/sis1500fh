<?php

use Illuminate\Database\Seeder;

class ConsultorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Consultor::create([
            'user_id' => 2,
            'custohora' => 50,
            'horas_por_dia' => 8,
            'data_inicio' => '2010-01-01'
        ]);
        \App\Consultor::create([
            'user_id' => 3,
            'custohora' => 20,
            'horas_por_dia' => 8,
            'data_inicio' => '2010-01-01'
        ]);
    }
}

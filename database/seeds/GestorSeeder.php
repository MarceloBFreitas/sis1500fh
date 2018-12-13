<?php

use Illuminate\Database\Seeder;

class GestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Gestor::create([
            'user_id' => 4,
            'custohora' => 100,
            'horas_por_dia' => 8,
            'data_inicio' => '2017-01-01'

        ]);
        \App\Gestor::create([
            'user_id' => 1,
            'custohora' => 200,
            'horas_por_dia' => 8,
            'data_inicio' => '2010-01-01'

        ]);
    }
}
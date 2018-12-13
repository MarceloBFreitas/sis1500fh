<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(TipoAtividadeSeeder::class);
         $this->call(EscopoOrcamentoSeeder::class);
         $this->call(DetalheEscopoOrcamentoSeeder::class);
         $this->call(ConsultorSeeder::class);
         $this->call(GestorSeeder::class);

    }
}

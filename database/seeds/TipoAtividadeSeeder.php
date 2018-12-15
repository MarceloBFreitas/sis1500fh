<?php

use Illuminate\Database\Seeder;

class TipoAtividadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\TipoAtividade::create([
            'sigla' => 'BSP',
            'nome' => 'Bussiness Print',
            'descricao' => 'Desenho e Arquitetura da Solução',
            'tipo' => 'Gestão',
        ]);

        \App\TipoAtividade::create([
            'sigla' => 'ETL',
            'nome' => 'Extract, Transform and Load',
            'descricao' => 'Extração, carga e normalização de dados, migração de ambientes e transformações',
            'tipo' => 'Técnica',
        ]);

        \App\TipoAtividade::create([
            'sigla' => 'MDB',
            'nome' => 'Modelagem de base Relacional ou Analítica',
            'descricao' => 'Construção de estrutura de base de dados relacional ou Analítica',
            'tipo' => 'Técnica',
        ]);
    }
}


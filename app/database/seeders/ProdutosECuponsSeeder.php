<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProdutosECuponsSeeder extends Seeder
{
    public function run(): void
    {
        // Insere produtos
        DB::table('produtos')->insert([
            ['nome' => 'Teclado Mecânico',  'preco' => 299.90, 'estoque' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Mouse Óptico',      'preco' => 79.90,  'estoque' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Monitor 24"',       'preco' => 899.00, 'estoque' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Headset USB',       'preco' => 199.00, 'estoque' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Cabo HDMI 2m',      'preco' => 29.90,  'estoque' => 50, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insere cupons
        DB::table('cupons')->insert([
            ['codigo' => 'PROMO10', 'tipo' => 'percentual', 'valor' => 10.00, 'validade' => Carbon::now()->addDays(30), 'limite_usos' => null, 'usos' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'VALE50',  'tipo' => 'valor',      'valor' => 50.00, 'validade' => Carbon::now()->addDays(30), 'limite_usos' => null, 'usos' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'FLASH20', 'tipo' => 'valor',      'valor' => 20.00, 'validade' => Carbon::now()->addDays(10), 'limite_usos' => 50,   'usos' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

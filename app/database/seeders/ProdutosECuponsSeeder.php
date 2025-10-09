<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProdutosECuponsSeeder extends Seeder
{
    public function run(): void
    {
        // ------- PRODUTOS (com imagem_url) -------
        $produtos = [
            [
                'nome'       => 'Teclado Mecânico',
                'preco'      => 299.90,
                'estoque'    => 10,
                'imagem_url' => 'https://m.media-amazon.com/images/I/61uUJnD-ZjL._AC_SY300_SX300_QL70_ML2_.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'Mouse Óptico',
                'preco'      => 79.90,
                'estoque'    => 25,
                'imagem_url' => 'https://m.media-amazon.com/images/I/51cuZuDr4YL._AC_SX679_.jpg?q=80&w=800',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'Monitor 24"',
                'preco'      => 899.00,
                'estoque'    => 5,
                'imagem_url' => 'https://m.media-amazon.com/images/I/71fExkr1vWL._AC_SX300_SY300_QL70_ML2_.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'Headset USB',
                'preco'      => 199.00,
                'estoque'    => 12,
                'imagem_url' => 'https://m.media-amazon.com/images/I/619T-Fp+EkL._AC_SX679_.jpg?q=80&w=800',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'Cabo HDMI 2m',
                'preco'      => 29.90,
                'estoque'    => 50,
                'imagem_url' => 'https://m.media-amazon.com/images/I/61NtxARI44L._AC_SX679_.jpg?q=80&w=800',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'Poco X3',
                'preco'      => 2345.00,
                'estoque'    => 2,
                'imagem_url' => 'https://images.kabum.com.br/produtos/fotos/sync_mirakl/221269/Smartphone-Xiaomi-Poco-X3-128Gb-6Gb-Ram-Global-Cinza_1674068905_gg.jpg?q=80&w=800',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'Iphone 16',
                'preco'      => 6999.00,
                'estoque'    => 1,
                'imagem_url' => 'https://www.goimports.com.br/image/catalog/0%20novos%20produtos%202024/iphone16/iphone-16-pro-finish-select-202409-6-9inch-blacktitanium.png?q=80&w=800',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome'       => 'ROG Phone',
                'preco'      => 4449.00,
                'estoque'    => 4,
                'imagem_url' => 'https://www.asus.com/media/Odin/Websites/br/ProductLine/20240830032428.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Usa upsert para não duplicar (chave única: nome)
        DB::table('produtos')->upsert(
            $produtos,
            ['nome'], // coluna única
            ['preco', 'estoque', 'imagem_url', 'updated_at'] // colunas atualizáveis
        );

        // ------- CUPONS -------
        $cupons = [
            [
                'codigo'      => 'PROMO10',
                'tipo'        => 'percentual',
                'valor'       => 10.00,
                'validade'    => Carbon::now()->addDays(30),
                'limite_usos' => null,
                'usos'        => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'codigo'      => 'VALE50',
                'tipo'        => 'valor',
                'valor'       => 50.00,
                'validade'    => Carbon::now()->addDays(30),
                'limite_usos' => null,
                'usos'        => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'codigo'      => 'DESCONTO15',
                'tipo'        => 'percentual',
                'valor'       => 15.00,
                'validade'    => Carbon::now()->addDays(45),
                'limite_usos' => 100,
                'usos'        => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'codigo'      => 'FLASH20',
                'tipo'        => 'valor',
                'valor'       => 20.00,
                'validade'    => Carbon::now()->addDays(20),
                'limite_usos' => 50,
                'usos'        => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'codigo'      => 'ESPECIAL25',
                'tipo'        => 'percentual',
                'valor'       => 25.00,
                'validade'    => Carbon::now()->addDays(7),
                'limite_usos' => 10,
                'usos'        => 0,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        // Usa upsert para não duplicar (chave única: codigo)
        DB::table('cupons')->upsert(
            $cupons,
            ['codigo'], // coluna única
            ['tipo', 'valor', 'validade', 'limite_usos', 'usos', 'updated_at'] // atualizáveis
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // Tabela esperada: 'produtos' (Laravel já deduz a partir do nome 'Produto')
    protected $table = 'produtos';

    // Campos liberados para atribuição em massa (create/update)
    protected $fillable = ['nome', 'preco', 'estoque'];

    // Casts de tipos
    protected $casts = [
        'preco'   => 'decimal:2',
        'estoque' => 'integer',
    ];
}

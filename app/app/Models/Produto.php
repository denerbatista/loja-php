<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome', 'preco', 'estoque', 'imagem_url',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
    ];
}

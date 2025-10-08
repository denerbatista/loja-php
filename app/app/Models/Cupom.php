<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $table = 'cupons';

    protected $fillable = ['codigo', 'tipo', 'valor', 'validade', 'limite_usos', 'usos'];

    protected $casts = [
        'valor'        => 'decimal:2',
        'validade'     => 'datetime',
        'limite_usos'  => 'integer',
        'usos'         => 'integer',
    ];

    // Helpers de domínio
    public function estaValidoAgora(): bool
    {
        if ($this->validade && $this->validade->lt(now())) {
            return false;
        }
        if (!is_null($this->limite_usos) && $this->usos >= $this->limite_usos) {
            return false;
        }
        return true;
    }

    public function aplicarDesconto(float $subtotal): float
    {
        if ($this->tipo === 'percentual') {
            return $subtotal * ((float)$this->valor / 100.0);
        }
        return (float)$this->valor;
    }
}

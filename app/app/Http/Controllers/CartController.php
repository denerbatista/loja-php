<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Cupom;

class CartController extends Controller
{
    private function cart(): array
    {
        return session('cart', ['items' => [], 'cupom' => null]); // cupom guardado (codigo,tipo,valor)
    }

    private function save(array $cart): void
    {
        session(['cart' => $cart]);
    }

    private function totals(array $cart): array
    {
        $subtotal = 0.0;
        foreach ($cart['items'] as $it) {
            $subtotal += $it['preco'] * $it['qty'];
        }

        $desconto = 0.0;
        if (!empty($cart['cupom'])) {
            $c = $cart['cupom'];
            if ($c['tipo'] === 'percentual') {
                $desconto = $subtotal * ((float)$c['valor'] / 100.0);
            } else {
                $desconto = (float)$c['valor'];
            }
        }

        $total = max(0, $subtotal - $desconto);
        return [$subtotal, $desconto, $total];
    }

    // GET /cart
    public function show()
    {
        $cart = $this->cart();
        [$subtotal, $discount, $total] = $this->totals($cart);
        return view('cart.show', [
            'cart'     => $cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total'    => $total,
        ]);
    }

    // POST /cart/add
    public function add(Request $r)
    {
        $id  = (int)$r->input('id');
        $qty = max(1, (int)$r->input('qty', 1));

        $p = Produto::find($id);
        if (!$p) return back()->with('warn', 'Produto não encontrado.');

        if ($qty > $p->estoque) return back()->with('warn', 'Estoque insuficiente.');

        $cart = $this->cart();
        $curr = $cart['items'][$id]['qty'] ?? 0;

        if ($curr + $qty > $p->estoque) {
            return back()->with('warn', 'Quantidade excede estoque.');
        }

        $cart['items'][$id] = [
            'id'     => $p->id,
            'nome'   => $p->nome,
            'preco'  => (float)$p->preco,
            'qty'    => $curr + $qty,
            'estoque'=> (int)$p->estoque,
        ];

        $this->save($cart);
        return back()->with('ok', 'Adicionado ao carrinho!');
    }

    // POST /cart/update
    public function update(Request $r)
    {
        $id  = (int)$r->input('id');
        $qty = max(1, (int)$r->input('qty'));

        $p = Produto::find($id);
        if (!$p) return back()->with('warn', 'Produto não encontrado.');
        if ($qty > $p->estoque) return back()->with('warn', 'Estoque insuficiente.');

        $cart = $this->cart();
        if (!isset($cart['items'][$id])) return back()->with('warn', 'Item não está no carrinho.');

        $cart['items'][$id]['qty'] = $qty;
        $this->save($cart);
        return back()->with('ok', 'Quantidade atualizada.');
    }

    // POST /cart/remove
    public function remove(Request $r)
    {
        $id = (int)$r->input('id');
        $cart = $this->cart();
        unset($cart['items'][$id]);
        $this->save($cart);
        return back()->with('ok', 'Item removido.');
    }

    // POST /cart/apply-coupon
    public function applyCoupon(Request $r)
    {
        $code = trim((string)$r->input('code', ''));

        $cupom = Cupom::whereRaw('UPPER(codigo)=UPPER(?)', [$code])->first();

        if (!$cupom || !$cupom->estaValidoAgora()) {
            return back()->with('warn', 'Cupom inválido, expirado ou sem usos restantes.');
        }

        $cart = $this->cart();
        $cart['cupom'] = [
            'codigo' => $cupom->codigo,
            'tipo'   => $cupom->tipo,   // 'percentual' | 'valor'
            'valor'  => (float)$cupom->valor,
            'id'     => $cupom->id,     // para contar uso no checkout
        ];

        $this->save($cart);
        return back()->with('ok', 'Cupom aplicado.');
    }

    // POST /cart/checkout
    public function checkout()
    {
        $cart = $this->cart();
        if (empty($cart['items'])) return back()->with('warn', 'Carrinho vazio.');

        DB::beginTransaction();
        try {
            // 1) Reservar e debitar estoque com lock pessimista
            foreach ($cart['items'] as $it) {
                $p = Produto::lockForUpdate()->find($it['id']);
                if (!$p || $p->estoque < $it['qty']) {
                    throw new \RuntimeException('Estoque mudou e ficou insuficiente: ' . $it['nome']);
                }
                // debita
                $p->decrement('estoque', $it['qty']);
            }

            // 2) Se houver cupom, contar uso (respeitando limite)
            if (!empty($cart['cupom']) && !empty($cart['cupom']['id'])) {
                $c = Cupom::lockForUpdate()->find($cart['cupom']['id']);
                if ($c) {
                    if (!$c->estaValidoAgora()) {
                        // se por acaso perdeu a validade agora, prossegue sem cupom
                    } else {
                        // valida limite de usos
                        if (!is_null($c->limite_usos) && $c->usos >= $c->limite_usos) {
                            // sem usos restantes — prossegue sem cupom
                        } else {
                            $c->increment('usos');
                        }
                    }
                }
            }

            DB::commit();

            // 3) Limpa carrinho
            $this->save(['items' => [], 'cupom' => null]);

            return back()->with('ok', 'Compra finalizada!');
        } catch (\Throwable $e) {
            if (DB::transactionLevel()) DB::rollBack();
            return back()->with('warn', 'Erro no checkout: ' . $e->getMessage());
        }
    }
}

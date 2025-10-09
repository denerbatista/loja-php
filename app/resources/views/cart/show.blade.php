@extends('layouts.app')

@section('content')
  <h1 class="h5 mb-3">Carrinho</h1>

  @if (empty($cart['items']))
    <div class="text-center py-5">
      <p class="lead mb-3">Seu carrinho está vazio.</p>
      <a class="btn btn-primary" href="{{ route('products.index') }}">Voltar aos produtos</a>
    </div>
  @else
    <div class="row g-3">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            @foreach ($cart['items'] as $it)
              <div class="d-flex gap-3 align-items-center py-3 border-bottom">
                @php
                  $img = $it['imagem_url'] ?? null;
                  if (!$img) {
                    $p = \App\Models\Produto::find($it['id']);
                    $img = $p?->imagem_url ?: 'https://placehold.co/120x120?text=Produto';
                  }
                @endphp
                <img src="{{ $img }}" alt="{{ $it['nome'] }}" width="90" height="90" style="object-fit:cover;border-radius:8px;">
                <div class="flex-grow-1">
                  <div class="fw-semibold">{{ $it['nome'] }}</div>
                  <div class="text-muted small">Estoque: {{ $it['estoque'] }}</div>
                  <div class="d-flex align-items-center gap-2 mt-2">
                    <form method="post" action="{{ route('cart.update') }}" class="d-flex align-items-center gap-2">
                      @csrf
                      <input type="hidden" name="id" value="{{ $it['id'] }}">
                      <input class="form-control form-control-sm text-center" name="qty" type="number" min="1" max="{{ $it['estoque'] }}" value="{{ $it['qty'] }}" style="width:90px">
                      <button class="btn btn-sm btn-outline-secondary">Atualizar</button>
                    </form>
                    <form method="post" action="{{ route('cart.remove') }}">
                      @csrf
                      <input type="hidden" name="id" value="{{ $it['id'] }}">
                      <button class="btn btn-sm btn-outline-danger">Remover</button>
                    </form>
                  </div>
                </div>
                <div class="text-end">
                  <div class="fw-bold">R$ {{ number_format($it['preco']*$it['qty'],2,',','.') }}</div>
                  <div class="text-muted small">R$ {{ number_format($it['preco'],2,',','.') }} un.</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between"><span>Subtotal</span><strong>R$ {{ number_format($subtotal,2,',','.') }}</strong></div>
            <div class="d-flex justify-content-between"><span>Desconto</span><strong class="text-success">- R$ {{ number_format($discount,2,',','.') }}</strong></div>
            <hr>
            <div class="d-flex justify-content-between fs-5"><span>Total</span><strong>R$ {{ number_format($total,2,',','.') }}</strong></div>

            <form method="post" action="{{ route('cart.apply') }}" class="row g-2 mt-3">
              @csrf
              <div class="col-8">
                <input class="form-control" name="code" placeholder="Cupom" value="{{ $cart['cupom']['codigo'] ?? '' }}">
              </div>
              <div class="col-4 d-grid">
                <button class="btn btn-outline-primary">Aplicar</button>
              </div>
            </form>

            <form method="post" action="{{ route('cart.checkout') }}" class="mt-3 d-grid">
              @csrf
              <button class="btn btn-success btn-lg">Finalizar compra</button>
            </form>
            <a class="btn btn-link mt-2" href="{{ route('products.index') }}">Continuar comprando</a>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

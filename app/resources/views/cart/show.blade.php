@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Carrinho</h1>
@if (empty($cart['items']))
  <p>Seu carrinho está vazio.</p>
  <a class="btn btn-primary" href="{{ route('products.index') }}">Voltar aos produtos</a>
@else
  <table class="table">
    <thead><tr><th>Produto</th><th class="text-end">Preço</th><th class="text-center" style="width:160px">Qtd</th><th class="text-end">Subtotal</th><th></th></tr></thead>
    <tbody>
    @foreach ($cart['items'] as $it)
      <tr>
        <td>{{ $it['nome'] }}</td>
        <td class="text-end">R$ {{ number_format($it['preco'],2,',','.') }}</td>
        <td class="text-center">
          <form method="post" action="{{ route('cart.update') }}" class="d-inline-flex gap-2 justify-content-center">
            @csrf
            <input type="hidden" name="id" value="{{ $it['id'] }}">
            <input class="form-control form-control-sm text-center" name="qty" type="number" min="1" max="{{ $it['estoque'] }}" value="{{ $it['qty'] }}" style="width:80px">
            <button class="btn btn-sm btn-outline-secondary">Atualizar</button>
          </form>
        </td>
        <td class="text-end">R$ {{ number_format($it['preco']*$it['qty'],2,',','.') }}</td>
        <td class="text-end">
          <form method="post" action="{{ route('cart.remove') }}" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{ $it['id'] }}">
            <button class="btn btn-sm btn-outline-danger">Remover</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

  <form method="post" action="{{ route('cart.apply') }}" class="row g-2 mb-3">
    @csrf
    <div class="col-auto"><input class="form-control" name="code" placeholder="Cupom" value="{{ $cart['cupom']['codigo'] ?? '' }}"></div>
    <div class="col-auto"><button class="btn btn-outline-primary">Aplicar</button></div>
  </form>

  <div class="card p-3">
    <div class="d-flex justify-content-between"><span>Subtotal</span><strong>R$ {{ number_format($subtotal,2,',','.') }}</strong></div>
    <div class="d-flex justify-content-between"><span>Desconto</span><strong>- R$ {{ number_format($discount,2,',','.') }}</strong></div>
    <hr>
    <div class="d-flex justify-content-between fs-5"><span>Total</span><strong>R$ {{ number_format($total,2,',','.') }}</strong></div>
  </div>

  <form method="post" action="{{ route('cart.checkout') }}" class="mt-3">
    @csrf
    <button class="btn btn-success">Finalizar compra</button>
    <a class="btn btn-link" href="{{ route('products.index') }}">Continuar comprando</a>
  </form>
@endif
@endsection

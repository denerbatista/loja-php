@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">Produtos</h1>
<form class="row g-2 mb-3" method="get">
  <div class="col-auto"><input class="form-control" name="q" placeholder="Buscar por nome" value="{{ $q }}"></div>
  <div class="col-auto"><button class="btn btn-primary">Buscar</button></div>
</form>
<table class="table table-striped">
  <thead><tr><th>Nome</th><th class="text-end">Preço</th><th class="text-center">Estoque</th><th></th></tr></thead>
  <tbody>
  @foreach ($products as $p)
    <tr>
      <td>{{ $p->nome }}</td>
      <td class="text-end">R$ {{ number_format($p->preco,2,',','.') }}</td>
      <td class="text-center">{{ $p->estoque }}</td>
      <td class="text-end">
        <form method="post" action="{{ route('cart.add') }}" class="d-inline">@csrf
          <input type="hidden" name="id" value="{{ $p->id }}">
          <button class="btn btn-sm btn-success" {{ $p->estoque==0 ? 'disabled' : '' }}>Adicionar</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $products->links('pagination::bootstrap-5') }}
@endsection

@extends('layouts.app')

@section('content')
  <h1 class="h5 mb-3 text-muted">Resultados @if($q) para “{{ $q }}” @endif</h1>

  @if ($products->count() === 0)
    <div class="text-center py-5">
      <p class="lead mb-3">Não encontramos produtos @if($q) para “{{ $q }}” @endif.</p>
      <a class="btn btn-primary" href="{{ route('products.index') }}">Limpar busca</a>
    </div>
  @else
    <div class="row g-3">
      @foreach ($products as $p)
        <div class="col-12 col-sm-6 col-md-4 col-lg-">
          <div class="ml-card h-100 d-flex flex-column">
            <a href="#" class="text-decoration-none text-dark">
              <div class="ratio ratio-1x1 bg-white">
                @php
                  $img = $p->imagem_url ?: 'https://placehold.co/600x600?text=Produto';
                @endphp
                <img src="{{ $img }}" alt="{{ $p->nome }}" class="w-100 h-100" style="object-fit:cover;">
              </div>
            </a>
            <div class="p-3 d-flex flex-column gap-1">
              <div class="price">R$ {{ number_format($p->preco,2,',','.') }}</div>
              @if ($p->estoque > 0)
                <span class="free">Frete grátis</span>
              @else
                <span class="badge text-bg-secondary">Esgotado</span>
              @endif
              <div class="text-truncate mt-1" title="{{ $p->nome }}">{{ $p->nome }}</div>

              <div class="mt-2 d-flex align-items-center justify-content-between">
                <span class="badge badge-estoque">Estoque: {{ $p->estoque }}</span>
                <form method="post" action="{{ route('cart.add') }}" class="d-inline">
                  @csrf
                  <input type="hidden" name="id" value="{{ $p->id }}">
                  <button class="btn btn-sm btn-primary" {{ $p->estoque==0 ? 'disabled' : '' }}>
                    Adicionar
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-4">
      {{ $products->links('pagination::bootstrap-5') }}
    </div>
  @endif
@endsection

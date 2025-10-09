<!doctype html>
<html lang="pt-br" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Loja PHP' }}</title>

  <!-- Bootstrap e Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <!-- HEADER -->
  <header class="bg-warning py-3">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">

      <a href="{{ route('products.index') }}" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="{{ asset('logo.png') }}" alt="Loja PHP" class="img-fluid" style="max-height: 80px;">
      </a>

      <form class="d-flex flex-grow-1 mx-3" action="{{ route('products.index') }}" method="get" style="max-width:560px;">
        <div class="input-group input-group-lg">
          <input 
            type="text" 
            name="q" 
            class="form-control" 
            placeholder="Buscar produtos, marcas e muito mais…" 
            value="{{ $q ?? '' }}">
          <button class="btn btn-primary text-white" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>

      <a href="{{ route('cart.show') }}" class="btn btn-outline-primary position-relative border-0">
        <i class="bi bi-cart3 fs-2" style="heigh-max: 3rem"></i>
      </a>
    </div>
  </header>

  <!-- MAIN -->
  <main class="container py-4">
    @foreach (['ok'=>'success','warn'=>'warning'] as $k=>$cls)
      @if (session($k)) 
        <div class="alert alert-{{ $cls }} mb-3">{{ session($k) }}</div> 
      @endif
    @endforeach

    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer class="bg-white border-top py-4 mt-5">
    <div class="container small text-muted d-flex justify-content-between flex-wrap">
      <span>© {{ date('Y') }} Loja PHP</span>
      <span>Feito com Laravel + Bootstrap</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

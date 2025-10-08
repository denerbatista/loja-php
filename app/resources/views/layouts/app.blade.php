<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Loja PHP' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar bg-body-tertiary">
  <div class="container d-flex justify-content-between">
    <a class="navbar-brand" href="{{ route('products.index') }}">Loja PHP</a>
    <a class="btn btn-outline-primary" href="{{ route('cart.show') }}">Carrinho</a>
  </div>
</nav>
<main class="container py-4">
  @foreach (['ok'=>'success','warn'=>'warning'] as $k=>$cls)
    @if (session($k)) <div class="alert alert-{{ $cls }} mb-3">{{ session($k) }}</div> @endif
  @endforeach
  @yield('content')
</main>
</body>
</html>

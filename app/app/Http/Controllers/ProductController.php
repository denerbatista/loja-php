<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProductController extends Controller
{
    public function index(Request $req)
    {
        $q = trim((string)$req->query('q', ''));
        $products = Produto::query()
            ->when($q !== '', fn($b) => $b->where('nome', 'like', "%{$q}%"))
            ->orderBy('nome')
            ->paginate(6)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'q'        => $q,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProductController extends Controller
{
    // GET /
    public function index(Request $req)
    {
        $q = trim((string)$req->query('q', ''));
        $produtos = Produto::query()
            ->when($q !== '', fn($b) => $b->where('nome', 'like', "%{$q}%"))
            ->orderBy('nome')
            ->paginate(6)
            ->withQueryString();

        // View vai usar $produtos e $q
        return view('products.index', [
            'products' => $produtos, // mantendo nome 'products' na view
            'q'        => $q,
        ]);
    }
}

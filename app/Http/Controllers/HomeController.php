<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('home', [
            'title' => 'Home',
            'products' => Product::orderBy('name', 'asc')
                ->paginate(config('utilities.pagination.count', 10))->toJson()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        $products = Product::query()->where('title', 'LIKE', '%'.$search.'%')->get();
        return view('website.shop', compact('products'));
    }


}

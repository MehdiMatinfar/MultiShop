<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class Detailcontroller extends Controller
{
    public function index($id)
    {
        $product=Product::find($id);
        return view('website.detail',compact('product'));
    }


    public function addToCart(Request  $request)
    {

//        add([
//            'id' => $request->id,
//            'name' => $request->name,
//            'price' => $request->price,
//            'quantity' => $request->count,
//            'attributes' => array(
//                'image' => $request->image,
//            )
//        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');

        return redirect('/detail/1');



    }
}

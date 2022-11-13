<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repository\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cart;

    /**
     * @param $cart
     */
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {

        $user_id = auth()->user()->id;
        $cart = Cart::query()->where('user_id', '=', $user_id)->where('buy', '=', '0')->first();
        $total = 0;
        $outputList = array();

        if(!is_null($cart)){
            $items = CartItem::query()->where('shop_cart_id', $cart->id)->get();

            foreach ($items as $item) {

                $row = array();
                $pid = $item->product_id;
                $product = Product::find($pid);
                $row['id'] = $item->id;
                $row['name'] = $product->title;
                $row['image'] = $product->image_link;
                $row['price'] = $product->price;
                $row['quantity'] = $item->quantity;
                $row['total'] = $item->quantity * $product->price;
                $product->price = $item->quantity * $product->price;
                $outputList[] = $row;
                $total += $product->price;

            }

        }


        return view('website.cart', ['total_price' => $total, 'data' => $outputList]);
    }

    public function clearItem($item)
    {

    }

    public function addToCart(Request $request)
    {

        Cart::add($request->id, $request->quantity);


        return redirect('/cart');


    }
    public function removeFromCart(Request $request)
    {


//        Cart::remove($request->id);

        $this->cart->remove($request->id);
        return redirect('/cart');


    }

    public function getMeAll()
    {
        return response()->json($this->cart->all()) ;

    }
    public function buyOrNot($id)
    {
        return response()->json($this->cart->getBuyOrNot($id)) ;

    }
}

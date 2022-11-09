<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';


    public static function add($product_id, $quantity)
    {
        $user_id = auth()->user()->id;

        $cart = Cart::query()->where('user_id', '=', $user_id)->where('buy', '=', '0')->first();
        $totalQuantity = 0;

        if (!is_null($cart)) {
            $items = CartItem::query()->where('shop_cart_id', $cart->id)->get();
            $productidListInCart = array();
            for ($i = 0; $i < count($items); $i++) {
                $productidListInCart[$i] = $items[$i]['product_id'];
            }
            if (in_array($product_id, $productidListInCart)) {
                // Customer Has That Product !

                $idx = array_search($product_id, $productidListInCart);
                $currentProductQuantity = $items[$idx]['quantity'];
                $totalQuantity = $currentProductQuantity + $quantity;
                $itemThatMustBeUpdate = CartItem::find($product_id);

                $itemThatMustBeUpdate->quantity = $totalQuantity;

                $itemThatMustBeUpdate->save();


            } else {
                $newItem = new CartItem;

                $newItem->product_id = $product_id;
                $newItem->quantity = $quantity;
                $newItem->shop_cart_id = $cart->id;
                $newItem->created_at = time();

                $newItem->save();


            }


        }
        else {
            $newCart = new Cart;
            $newCart->user_id = $user_id;
            $newCart->created_at = time();
            $newCart->save();


            $cartWhenThatTimeCreated = Cart::query()->where('user_id', '=', $user_id)->where('buy', '=', '0')->first();

            $newItem = new CartItem;

            $newItem->product_id = $product_id;
            $newItem->quantity = $quantity;
            $newItem->shop_cart_id =$cartWhenThatTimeCreated->id;
            $newItem->created_at = time();

            $newItem->save();

        }

    }

    public  static function remove($itemId){

        CartItem::query()->where('id',$itemId)->delete();

    }
    public static function getTotal()
    {
        $user_id = auth()->user()->id;
        $cart = Cart::query()->where('user_id', '=', $user_id)->where('buy', '=', '0')->first();

        $items = CartItem::query()->where('shop_cart_id', $cart->id)->get();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->quantity;
        }

        if (!is_null($total)) {
            return $total;
        }
        return 0;
    }

}

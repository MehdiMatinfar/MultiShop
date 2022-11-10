<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository extends Repository
{
    /**
     * @return mixed
     */

    public function model()
    {
        return Cart::class;
    }

    public function getBuyOrNot($id)
    {
        return app($this->model())->where('user_id',$id)->select('id','buy')->get();
    }

    public function shipping($coupon_code){



    }

    public  function remove($itemId){

        CartItem::query()->where('id',$itemId)->delete();
        $count = CartItem::query()->where('id',$itemId)->count();
        if($count==0){
            app($this->model())->query()->where('user_id',auth()->id())->delete();
        }
    }

    public static function getTotal()
    {
        $user_id = auth()->user()->id;
        $cart = Cart::query()->where('user_id', '=', $user_id)->where('buy', '=', '0')->first();

        if(!is_null($cart)){

            $items = CartItem::query()->where('shop_cart_id', $cart->id)->get();


            $total = 0;
            foreach ($items as $item) {
                $total += $item->quantity;
            }

            if (!is_null($total)) {
                return $total;
            }
            return  0 ;

        }

        return 0;
    }

}

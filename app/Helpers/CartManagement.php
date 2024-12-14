<?php

namespace App\Helpers;

use App\Models\Produk;
use Illuminate\Support\Facades\Cookie;

class CartManagement{

    //add item to cart
    static public function addItemToCart($id_produk){
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach($cart_items as $key => $item){
            if($item['id_produk'] == $id_produk){
                $existing_item = $key;
                break;
            }
        }

        if($existing_item !== null){
            $cart_items[$existing_item]['quantity']++;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        }else{
            $product = Produk::where('id', $id_produk)->first(['id', 'name', 'price', 'image']);
            if($product){
                $cart_items[] = [
                    'id_produk' => $id_produk,
                    'name' => $product->name,
                    'image' => $product->image[0],
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }
    static public function addItemToCartWithQty($id_produk, $qty = 1){
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach($cart_items as $key => $item){
            if($item['id_produk'] == $id_produk){
                $existing_item = $key;
                break;
            }
        }

        if($existing_item !== null){
            $cart_items[$existing_item]['quantity'] = $qty;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        }else{
            $product = Produk::where('id', $id_produk)->first(['id', 'name', 'price', 'image']);
            if($product){
                $cart_items[] = [
                    'id_produk' => $id_produk,
                    'name' => $product->name,
                    'image' => $product->image[0],
                    'quantity' => $qty,
                    'unit_amount' => $product->price,
                    'total_amount' => $qty * $product->price
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    //remove item to cart
    static public function removeCartItems($id_produk){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['id_produk'] == $id_produk){
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }
    //add cart item to Cookie
    static public function addCartItemsToCookie($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    //Clear carts items form cookie
    static public function clearCartItemsFromCookie(){
        Cookie::queue(Cookie::forget('cart_items'));
    }

    //get all cart items form cookie
    static public function getCartItemsFromCookie(){
        $cart_items = json_decode(Cookie::get('cart_items'), true);

        if(! $cart_items ){
            $cart_items = [];
        }

        return $cart_items;
    }

    //increment item quantity
    static public function incrementQuantityToCartItem($id_produk){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['id_produk'] == $id_produk){
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    //decrement item quantity
    static public function decrementQuantityToCartItem($id_produk){
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item){
            if($item['id_produk'] == $id_produk){
                if($cart_items[$key]['quantity'] > 1){
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    //grand Total

    static public function calculateGrandTotal($items){
        return array_sum(array_column($items, 'total_amount'));
    }
}
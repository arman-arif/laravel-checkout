<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function buyNow(Product $product)
    {
        $cart = new Cart();

        $cart->user_id       = Auth::user()->id;
        $cart->product_id    = $product->id;
        $cart->product_name  = $product->name;
        $cart->product_image = $product->image;
        $cart->quantity      = 1;
        $cart->price         = $product->price;     // $product->price * $cart->quantity;
        $cart->discount      = 0;
        $cart->session_id    = session()->getId();
        $cart->save();

        return redirect()->route('purchase', $product->id);
    }
}

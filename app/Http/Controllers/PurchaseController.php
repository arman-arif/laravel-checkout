<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function purchase(int $product)
    {
        $intent = Auth::user()->createSetupIntent();

        $cart = Cart::where('product_id', $product)
            ->where('user_id', Auth::user()->id)
            ->where('session_id', session()->getId())
            ->get();

        // return $cart;
        return view('purchase', compact('cart', 'intent'));
    }

    public function checkout()
    {
        return view('checkout');
    }
}

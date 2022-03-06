<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment()
    {
    }

    public function singlePayment(Request $request, $product)
    {
        // return $request;

        $cart = Cart::where('product_id', $product)
            ->where('user_id', Auth::user()->id)
            ->where('session_id', session()->getId())
            ->get();

        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');

        $order['user_id']       = $user->id;
        $order['product_id']    = $product;
        $order['product_name']  = $cart->first()->product_name;
        $order['product_image'] = $cart->first()->product_image;
        $order['quantity']      = $cart->sum('quantity');
        $order['price']         = $cart->first()->price * $order['quantity'];
        $order['discount']      = $cart->first()->discount;

        $order = Order::create($order);

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($order->price * 100, $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('payment_confirm')->with('message', 'Product purchase order and payment is successfull!');
    }
}

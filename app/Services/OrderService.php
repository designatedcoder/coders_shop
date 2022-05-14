<?php

namespace App\Services;

use Gloudemans\Shoppingcart\Facades\Cart;

class OrderService {
    public function all($request, $confirmation_number) {
        $tax = config('cart.tax') /100;
        $cartSubtotal = Cart::instance('default')->subtotal();
        $code =  session()->get('coupon')['name']??null;
        $discount =  session()->get('coupon')['discount']??0;
        $newSubtotal = ($cartSubtotal - $discount);
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1+$tax);

        return [
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_name_on_card' => $request->name_on_card,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_state' => $request->state,
            'billing_zip_code' => $request->zip_code,
            'billing_discount' => $discount,
            'billing_discount_code' => $code,
            'billing_subtotal' => $cartSubtotal,
            'billing_tax' => $newTax,
            'billing_total' => $newTotal,
            'shipped' => false,
            'confirmation_number' => $confirmation_number,
        ];
    }
}

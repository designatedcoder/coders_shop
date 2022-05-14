<?php

namespace App\Services;

use App\Contracts\PaymentGatewayContract;
use Gloudemans\Shoppingcart\Facades\Cart;

class StripePaymentGateway implements PaymentGatewayContract {

    private $cartItems;

    public function __construct($cartItems) {
        $this->cartItems = $cartItems;
    }

    public function charge($user, $request, $confirmation_number) {
        if (session()->has('coupon')) {
            $discountValue = session()->get('coupon')['discount']/100;
            $discountCode = session()->get('coupon')['name'];
        } else {
            $discountCode = 'NULL';
            $discountValue = 0;
        }
        $payment = $user->charge(ceil($request->amount), $request->payment_method_id, [
            'receipt_email' => $request->email,
            'statement_descriptor' => 'Coders Shop',
            'description' => 'You bought my swag!',
            'metadata' => [
                'Confirmation # ' => $confirmation_number,
                'Item(s)' => $this->cartItems,
                'Total Item(s) Count' => Cart::instance('default')->count(),
                'Discount' => $discountCode. ': -$'.$discountValue.' off',
            ],
        ]);
        $payment = $payment->asStripePaymentIntent();
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PaymentGatewayContract;
use App\Services\StripePaymentGateway;
use Gloudemans\Shoppingcart\Facades\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->app->scoped(PaymentGatewayContract::class, function($app) {
            $cartItems = Cart::instance('default')->content()->map(function ($item) {
                return
                    'Product Code: '.$item->options->product_code.', '.
                    'Product Name: '. $item->model->name.', '.
                    'Product Qty: '.$item->qty;
            })->values()->toJson();
            return new StripePaymentGateway($cartItems);
        });
    }
}

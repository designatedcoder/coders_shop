<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\OrderService;
use Stripe\Exception\CardException;
use App\Contracts\PaymentGatewayContract;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\CheckoutFormRequest;
use App\Mail\OrderReceived;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartService $cartService) {
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('shop.index');
        }
        $contents = [
            'cartItems' => $cartService->setCartValues()->get('cartItems'),
            'cartTaxRate' => $cartService->setCartValues()->get('cartTaxRate'),
            'cartSubtotal' => $cartService->setCartValues()->get('cartSubtotal'),
            'newTax' => $cartService->setCartValues()->get('newTax'),
            'code' =>$cartService->setCartValues()->get('code'),
            'discount' => $cartService->setCartValues()->get('discount'),
            'newSubtotal' => $cartService->setCartValues()->get('newSubtotal'),
            'newTotal' => $cartService->setCartValues()->get('newTotal'),
        ];
        if (!auth()->check()) {
            return Inertia::render('Checkout/Guest', $contents);
        }
        return Inertia::render('Checkout/Index', $contents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CheckoutFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentGatewayContract $paymentService, OrderService $orderService, CheckoutFormRequest $request, InvoiceService $invoiceService) {
        try {
            $confirmation_number = Str::uuid();
            $user = auth()->user() ?? new User;

            $paymentService->charge($user, $request, $confirmation_number);

            $order = $user->orders()->create($orderService->all($request, $confirmation_number));

            foreach(Cart::instance('default')->content() as $item) {
                $product = Product::find($item->model->id);
                $order->products()->attach($product, ['quantity' => $item->qty]);
            }

            $userInvoice = auth()->user() ?? $order->billing_email;

            Mail::to($userInvoice)->send(new OrderReceived($order->load('products'), $invoiceService->createInvoice($order)));

            return response([
                'success' => true,
                'order' => [
                    'confirmation_number' => $order->confirmation_number,
                    'billing_subtotal' => $order->billing_subtotal,
                    'billing_tax' => $order->billing_tax,
                    'billing_discount_code' => $order->billing_discount_code,
                    'billing_discount' => $order->billing_discount,
                    'billing_total' => $order->billing_total,
                    'items' => $order->products,
                ],
            ], 200);
        }catch (CardException $e) {
            return response([
                'errors' => $e->getMessage()
            ], 500);
        }catch (\Error $e) {
            return response([
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CartService;
use Stripe\Exception\CardException;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartService $cartService) {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $cartItems = Cart::instance('default')->content()->map(function ($item) {
            return
                'Product Code: '.$item->options->product_code.', '.
                'Product Name: '. $item->model->name.', '.
                'Product Qty: '.$item->qty;
        })->values()->toJson();
        try {
            $this->validate($request, [
                'email' => ['required', 'min:8', 'max:100', 'email', 'unique:users'],
                'name' => ['required', 'string', 'min:3', 'max:100'],
                'name_on_card' => ['required', 'string', 'min:3', 'max:100'],
                'password' => ['sometimes', 'required', 'min:8', 'max:20'],
                'address' => ['required', 'string', 'min:3', 'max:50'],
                'city' => ['required', 'string', 'min:2', 'max:20'],
                'state' => ['required', 'string', 'min:2', 'max:20'],
                'zip_code' => ['required', 'string', 'min:5', 'max:15'],
            ]);

            $confirmation_number = Str::uuid();
            $user = new User;
            $payment = $user->charge(ceil($request->amount), $request->payment_method_id, [
                'receipt_email' => $request->email,
                'statement_descriptor' => 'Coders Shop',
                'description' => 'You bought my swag!',
                'metadata' => [
                    'Confirmation # ' => $confirmation_number,
                    'Item(s)' => $cartItems,
                    'Total Item(s) Count' => Cart::instance('default')->count(),
                ],
            ]);
            $payment = $payment->asStripePaymentIntent();
            return response([
                'success' => true,
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

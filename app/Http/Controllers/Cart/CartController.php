<?php

namespace App\Http\Controllers\Cart;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cartItems = Cart::instance('default')->content();
        $cartTaxRate = config('cart.tax');
        $tax = config('cart.tax') /100;
        $cartSubtotal = Cart::instance('default')->subtotal();
        $cartTax = $cartSubtotal * $tax;
        $newTotal =Cart::instance('default')->total();
        $laterItems = Cart::instance('laterCart')->content();
        $laterCount = Cart::instance('laterCart')->count();
        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'cartTaxRate' => $cartTaxRate,
            'cartSubtotal' => $cartSubtotal,
            'cartTax' => $cartTax,
            'newTotal' => $newTotal,
            'laterItems' => $laterItems,
            'laterCount' => $laterCount,
        ]);
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
        Cart::instance('default')->add($request->id, $request->name, $request->quantity, $request->price, 0, ['totalQty' => $request->totalQty, 'product_code' => $request->product_code, 'image' => $request->image, 'slug' => $request->slug, 'details' => $request->details])->associate('App\Models\Product');
        return redirect()->route('cart.index');
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
    public function update(Request $request, $id) {
        Cart::instance('default')->update($id, $request->quantity);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Cart::instance('default')->remove($id);
        return back();
    }
}

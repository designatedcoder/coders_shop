<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $categories = Category::all();
        if (request()->category) {
            if (!request()->sort) {
                $products = Product::whereHas('categories', function($query) {
                    $query->where('slug', request()->category);
                })->inRandomOrder()->get(['name', 'slug', 'price', 'main_image']);
                $categoryName = optional($categories->where('slug', request()->category)->first())->name;
                $categorySlug = $categories->where('slug', request()->category)->first()->slug;
            } else {
                $products = Product::whereHas('categories', function($query) {
                    $query->where('slug', request()->category);
                });
                $categoryName = optional($categories->where('slug', request()->category)->first())->name;
                $categorySlug = $categories->where('slug', request()->category)->first()->slug;
                if (request()->sort == 'low_high') {
                    $products = $products->orderBy('price')->get(['name', 'slug', 'price', 'main_image']);
                } else {
                    $products = $products->orderBy('price', 'desc')->get(['name', 'slug', 'price', 'main_image']);
                }
            }
        } else {
            $products = Product::inRandomOrder()->get(['name', 'slug', 'price', 'main_image']);
            $categoryName = 'All';
            $categorySlug = NULL;
        }
        return Inertia::render('Shop/Index', [
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
            'categorySlug' => $categorySlug,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        $categories = $product->categories;
        foreach ($categories as $category) {
            $similarProducts = $category->products->shuffle()->take(4);
        }
        return Inertia::render('Shop/Show', [
            'product' => $product,
            'similarProducts' => $similarProducts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

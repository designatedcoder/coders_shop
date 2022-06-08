<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    /**
     * Display a Welcome Vue.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke() {
        $categories = Category::take(4)->inRandomOrder()->get(['name', 'slug']);
        $featured = Product::where('image', '!=', 'defaults/no_image.jpg')->take(4)->inRandomOrder()->get(['name', 'slug', 'image']);
        return Inertia::render('Welcome', [
            'categories' => $categories,
            'featured' => $featured,
        ]);
    }
}

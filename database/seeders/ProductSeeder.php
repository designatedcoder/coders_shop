<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // WOMENS
        for ($i=1; $i <= 12; $i++) {
            Product::create([
                'name' => 'Womens '.$i,
                'slug' => 'women-'.$i,
                'details' => 'women\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00',
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        // MENS
        for ($i=1; $i <= 12; $i++) {
            Product::create([
                'name' => 'Mens '.$i,
                'slug' => 'mens-'.$i,
                'details' => 'men\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00',
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        // Kids
        for ($i=1; $i <= 12; $i++) {
            Product::create([
                'name' => 'Kids '.$i,
                'slug' => 'kids-'.$i,
                'details' => 'kid\'s hoodie',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00',
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }

        // HOME GOODS
        for ($i=1; $i <= 12; $i++) {
            Product::create([
                'name' => 'Home Goods '.$i,
                'slug' => 'homegoods-'.$i,
                'details' => 'homegoods',
                'description' =>'Lorem '. $i . ' ipsum dolor sit amet, consectetur adipisicing elit. Ipsum temporibus iusto ipsa, asperiores voluptas unde aspernatur praesentium in? Aliquam, dolore!',
                'product_code' => '-00',
                'price' => rand(999, 9999),
                'quantity' => rand(1,10),
            ]);
        }
    }
}

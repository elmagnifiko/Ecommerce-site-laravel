<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Création des catégories (si elles n'existent pas déjà)
        $categories = [
            'Electronics' => 'electronics',
            'Fashion' => 'fashion',
            'Books' => 'books',
            'Toys' => 'toys',
            'Furniture' => 'furniture'
        ];

        $categoryIds = [];
        foreach ($categories as $name => $slug) {
            $cat = Category::firstOrCreate(['slug' => $slug], ['name' => $name]);
            $categoryIds[$slug] = $cat->id;
        }

        // Création des 10 produits manuels
        $products = [
            [
                'name' => 'Laptop HP',
                'slug' => 'laptop-hp',
                'description' => 'Powerful laptop for work',
                'price' => 350000,
                'stock' => 10,
                'category_slug' => 'electronics',
                'image' => 'https://picsum.photos/200/200?random=1'
            ],
            [
                'name' => 'iPhone 13',
                'slug' => 'iphone-13',
                'description' => 'Latest iPhone model',
                'price' => 450000,
                'stock' => 5,
                'category_slug' => 'electronics',
                'image' => 'https://picsum.photos/200/200?random=2'
            ],
            [
                'name' => 'Sneakers Nike',
                'slug' => 'sneakers-nike',
                'description' => 'Comfortable running shoes',
                'price' => 70000,
                'stock' => 20,
                'category_slug' => 'fashion',
                'image' => 'https://picsum.photos/200/200?random=3'
            ],
            [
                'name' => 'T-shirt Basic',
                'slug' => 'tshirt-basic',
                'description' => 'Cotton t-shirt',
                'price' => 15000,
                'stock' => 50,
                'category_slug' => 'fashion',
                'image' => 'https://picsum.photos/200/200?random=4'
            ],
            [
                'name' => 'Laravel Book',
                'slug' => 'laravel-book',
                'description' => 'Learn Laravel from scratch',
                'price' => 20000,
                'stock' => 30,
                'category_slug' => 'books',
                'image' => 'https://picsum.photos/200/200?random=5'
            ],
            [
                'name' => 'Toy Car',
                'slug' => 'toy-car',
                'description' => 'Fun toy for kids',
                'price' => 12000,
                'stock' => 40,
                'category_slug' => 'toys',
                'image' => 'https://picsum.photos/200/200?random=6'
            ],
            [
                'name' => 'Office Chair',
                'slug' => 'office-chair',
                'description' => 'Comfortable ergonomic chair',
                'price' => 80000,
                'stock' => 10,
                'category_slug' => 'furniture',
                'image' => 'https://picsum.photos/200/200?random=7'
            ],
            [
                'name' => 'Dining Table',
                'slug' => 'dining-table',
                'description' => 'Wooden dining table',
                'price' => 120000,
                'stock' => 5,
                'category_slug' => 'furniture',
                'image' => 'https://picsum.photos/200/200?random=8'
            ],
            [
                'name' => 'Puzzle 1000 pcs',
                'slug' => 'puzzle-1000',
                'description' => 'Challenging puzzle',
                'price' => 20000,
                'stock' => 10,
                'category_slug' => 'toys',
                'image' => 'https://picsum.photos/200/200?random=9'
            ],
            [
                'name' => 'PHP Book',
                'slug' => 'php-book',
                'description' => 'Learn PHP effectively',
                'price' => 15000,
                'stock' => 25,
                'category_slug' => 'books',
                'image' => 'https://picsum.photos/200/200?random=10'
            ],
        ];

        // Insertion des produits
        foreach ($products as $prod) {
            Product::firstOrCreate(
                ['slug' => $prod['slug']],
                [
                    'category_id' => $categoryIds[$prod['category_slug']],
                    'name' => $prod['name'],
                    'slug' => $prod['slug'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'stock' => $prod['stock'],
                    'is_active' => true,
                    'image' => $prod['image']
                ]
            );
        }
    }
}

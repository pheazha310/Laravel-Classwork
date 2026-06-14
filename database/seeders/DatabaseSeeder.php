<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create test categories
        $categories = Category::create([
            'name' => 'Laptop',
            'description' => 'High-performance laptops',
            'is_active' => true,
        ]);

        Category::create([
            'name' => 'Desktop',
            'description' => 'Desktop computers',
            'is_active' => true,
        ]);

        // Create test products
        Product::create([
            'category_id' => $categories->id,
            'name' => 'MacBook Pro M3',
            'image' => null,
            'price' => 1999.99,
            'stock' => 14,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categories->id,
            'name' => 'Dell XPS 13',
            'image' => null,
            'price' => 1299.99,
            'stock' => 8,
            'is_active' => true,
        ]);
    }
}

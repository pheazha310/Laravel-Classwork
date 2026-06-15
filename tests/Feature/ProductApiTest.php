<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_products_with_category_data(): void
    {
        $category = Category::create([
            'name' => 'Laptops',
            'description' => 'Portable computers',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'ThinkPad',
            'image' => null,
            'price' => 1299.99,
            'stock' => 12,
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/products');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.0.id', $product->id)
            ->assertJsonPath('data.0.category.id', $category->id)
            ->assertJsonPath('data.0.price', 1299.99)
            ->assertJsonPath('data.0.stock', 12)
            ->assertJsonPath('data.0.is_active', true);
    }

    public function test_it_creates_a_product_with_an_image_upload(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Phones',
            'description' => 'Mobile devices',
            'is_active' => true,
        ]);

        $response = $this->post('/api/products', [
            'category_id' => $category->id,
            'name' => 'Galaxy S24',
            'price' => 899.99,
            'stock' => 25,
            'is_active' => 1,
            'image' => UploadedFile::fake()->image('phone.jpg'),
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Galaxy S24')
            ->assertJsonPath('data.category.id', $category->id)
            ->assertJsonPath('data.is_active', true);

        $imagePath = $response->json('data.image');
        $this->assertNotNull($imagePath);
        Storage::disk('public')->assertExists($imagePath);
    }

    public function test_it_shows_a_product_with_its_category(): void
    {
        $category = Category::create([
            'name' => 'Tablets',
            'description' => 'Touchscreen devices',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'iPad Air',
            'image' => null,
            'price' => 699.00,
            'stock' => 8,
            'is_active' => true,
        ]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $product->id)
            ->assertJsonPath('data.category.name', 'Tablets');
    }

    public function test_it_updates_a_product_and_replaces_the_image(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Accessories',
            'description' => 'Add-ons',
            'is_active' => true,
        ]);

        Storage::disk('public')->put('products/old-image.jpg', 'old image');

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Wireless Mouse',
            'image' => 'products/old-image.jpg',
            'price' => 49.99,
            'stock' => 40,
            'is_active' => true,
        ]);

        $response = $this->post("/api/products/{$product->id}", [
            '_method' => 'PUT',
            'name' => 'Wireless Mouse Pro',
            'stock' => 32,
            'image' => UploadedFile::fake()->image('mouse.jpg'),
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Wireless Mouse Pro')
            ->assertJsonPath('data.stock', 32)
            ->assertJsonPath('data.category.id', $category->id);

        Storage::disk('public')->assertMissing('products/old-image.jpg');
        Storage::disk('public')->assertExists($response->json('data.image'));
    }

    public function test_it_deletes_a_product_and_its_image(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Audio',
            'description' => 'Sound gear',
            'is_active' => true,
        ]);

        Storage::disk('public')->put('products/headphones.jpg', 'headphones image');

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Headphones',
            'image' => 'products/headphones.jpg',
            'price' => 199.99,
            'stock' => 15,
            'is_active' => true,
        ]);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Product deleted successfully');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing('products/headphones.jpg');
    }

    public function test_it_returns_validation_errors_for_missing_required_fields(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Broken payload',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['category_id', 'price', 'stock']);
    }
}

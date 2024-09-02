<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        // Create a user
        $user = User::factory()->create([
            'username' => 'testuser'
        ]);
        // Authenticate the user
        $response = $this->actingAs($user, 'api')->postJson('/api/product/create', [
            'name' => 'Test Product',
            'stock' => 10,
            'price' => 100,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Product created successfully']);
    }

    public function test_update_product()
    {
        $user = User::factory()->create([
            'username' => 'testuser'
        ]);

        $product = Product::factory()->create();

        $response = $this->actingAs($user, 'api')->putJson("/api/product/update/{$product->id}", [
            'name' => 'Updated Product',
            'stock' => 20,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product updated successfully']);
    }

    public function test_delete_product()
    {
        $user = User::factory()->create([
            'username' => 'testuser'
        ]);

        $product = Product::factory()->create();

        $response = $this->actingAs($user, 'api')->postJson("/api/product/delete/" . $product->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Product deleted successfully']);
    }

    public function test_show_all_products()
    {
        $user = User::factory()->create([
            'username' => 'testuser'
        ]);
        Product::factory(3)->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/product');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}

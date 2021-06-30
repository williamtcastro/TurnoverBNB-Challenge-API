<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * Test to get array of products.
     * 
     * @return void
     */
    public function test_get_products()
    {
        \App\Models\Product::factory(5)->create()->toArray();
        $response = $this->getJson('/api/product');
        $response->assertStatus(200)->assertJsonStructure([
            [
                'id',
                'name',
                'price',
                'quantity',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * Test to create single product
     * 
     * @return void
     */
    public function test_creat_single_product()
    {
        $product = \App\Models\Product::factory()->create()->toArray();
        $response = $this->postJson('/api/product', $product);
        $response->assertStatus(201)->assertJsonFragment([
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $product['quantity']
        ]);
    }

    /**
     * Test to get specific product.
     * 
     * @return void
     */
    public function test_get_single_product()
    {
        $product = \App\Models\Product::factory()->create()->toArray();
        $productId = $product['id'];
        $response = $this->getJson("/api/product/$productId");
        $response->assertStatus(200)->assertJsonFragment([
            "id" => $productId,
            "name" => $product['name'],
            "price" => $product['price'],
            "quantity" => $product['quantity'],
            "updated_at" => $product['updated_at'],
            "created_at" => $product['created_at']
        ]);
    }

    /**
     * Test to update specific product.
     * 
     * @return void
     */
    public function test_update_single_product()
    {
        $faker = \Faker\Factory::create();
        $product = \App\Models\Product::factory()->create()->toArray();
        $productId = $product['id'];
        $product['quantity'] = $faker->randomDigit();
        $response = $this->putJson("/api/product/$productId", $product);
        $response->assertStatus(200)->assertExactJson([
            "id" => $productId,
            "name" => $product['name'],
            "price" => $product['price'],
            "quantity" => $product['quantity'],
            "updated_at" => $product['updated_at'],
            "created_at" => $product['created_at']
        ]);
    }

    /**
     * Test to delete specific product.
     * 
     * @return void
     */
    public function test_delete_single_product()
    {
        $product = \App\Models\Product::factory()->create()->toArray();
        $productId = $product['id'];
        $response = $this->deleteJson("/api/product/$productId");
        $response->assertStatus(200)->assertExactJson([
            "message" => true
        ]);
    }

    /**
     * Test to create bulk product.
     * 
     * @return void
     */
    public function test_create_bulk_product()
    {
        $products = \App\Models\Product::factory(5)->create()->toArray();
        $response = $this->postJson("/api/product/bulk", $products);
        $response->assertStatus(200)->assertExactJson([
            "message" => true,
        ]);
    }

    /**
     * Test to update bulk products.
     * 
     * @return void
     */
    public function test_update_bulk_product()
    {
        $faker = \Faker\Factory::create();
        $products = \App\Models\Product::factory(5)->create()->toArray();
        $updatedProducts = array();

        foreach ($products as $prod => $values) {
            $changedProd = [
                'id' => $values['id'],
                'quantity' => $faker->randomDigit()
            ];
            array_push($updatedProducts, $changedProd);
        }

        $response = $this->putJson("/api/product/bulk", $products);
        $response->assertStatus(200)->assertExactJson([
            "message" => true,
        ]);
    }
}

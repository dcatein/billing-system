<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;


    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::find(99);
    }
    
    public function test_Product_create()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'),
         [
            "name" => "Produto Teste",
            "sku" => "SKU123",
            "barcode" => "7890000000000",
            "price" => 100,
        ]);
        $response->dump();

    $response->assertStatus(201);
    }

    public function test_product_name_is_required()
    {
         $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "",
            "sku" => "SKU123",
            "barcode" => "7890000000000",
            "price" => 100,
        ]);

    $response->assertStatus(422);
    }

    public function test_product_name_must_be_string()
    {   
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
        'name' => 123,
        'price' => 10
        ]);

    $response->assertStatus(422);
    }

    public function test_product_name_exceeds_maximum_characters()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
        'name' => str_repeat('a', 256),
        'price' => 10
        ]);

    $response->assertStatus(422);
    }

    public function test_product_price_is_required()
    {
         $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "sku" => "SKU123",
            "barcode" => "7890000000000"
        ]);

    $response->assertStatus(422);
    }   

    public function test_product_price_must_be_numeric()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "price" => "abc",
        ]);

    $response->assertStatus(422);
    }

    public function test_product_price_min_zero()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "price" => -10,
        ]);

    $response->assertStatus(422);
    }

    public function test_product_sku_must_be_string()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "sku" => 12345,
            "price" => 100,
        ]);

    $response->assertStatus(422);
    }

    public function test_product_sku_max_255()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "sku" => str_repeat("a", 256),
            "price" => 100,
        ]);

    $response->assertStatus(422);
    }

    public function test_product_barcode_must_be_string()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "barcode" => 123456,
            "price" => 100,
        ]);

    $response->assertStatus(422);
    }

    public function test_product_barcode_max_255()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "barcode" => str_repeat("a", 256),
            "price" => 100,
        ]);

    $response->assertStatus(422);
    }

    public function test_product_category_must_exist()
    {
        $response = $this->actingAs($this->user)->postJson(route('products.store'), [
            "name" => "Produto Teste",
            "price" => 100,
            "category_id" => 999999,
        ]);

    $response->assertStatus(422);
    }


}

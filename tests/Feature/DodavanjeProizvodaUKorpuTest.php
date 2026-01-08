<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DodavanjeProizvodaUKorpuTest extends TestCase
{
    use RefreshDatabase;

    public function test_proizvod_se_uspesno_dodaje_u_korpu()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('cart.add', $product->id));

        $response->assertStatus(302);

        $this->assertDatabaseHas('cart_items', [
            'proizvod_id' => $product->id,
        ]);
    }
}

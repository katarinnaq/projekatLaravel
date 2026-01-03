<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Cart;
use App\Models\Kupac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CartController
 */
final class CartControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $carts = Cart::factory()->count(3)->create();

        $response = $this->get(route('carts.index'));

        $response->assertOk();
        $response->assertViewIs('cart.index');
        $response->assertViewHas('carts', $carts);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('carts.create'));

        $response->assertOk();
        $response->assertViewIs('cart.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartController::class,
            'store',
            \App\Http\Requests\CartStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $kupac = Kupac::factory()->create();

        $response = $this->post(route('carts.store'), [
            'kupac_id' => $kupac->id,
        ]);

        $carts = Cart::query()
            ->where('kupac_id', $kupac->id)
            ->get();
        $this->assertCount(1, $carts);
        $cart = $carts->first();

        $response->assertRedirect(route('carts.index'));
        $response->assertSessionHas('cart.id', $cart->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->get(route('carts.show', $cart));

        $response->assertOk();
        $response->assertViewIs('cart.show');
        $response->assertViewHas('cart', $cart);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->get(route('carts.edit', $cart));

        $response->assertOk();
        $response->assertViewIs('cart.edit');
        $response->assertViewHas('cart', $cart);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartController::class,
            'update',
            \App\Http\Requests\CartUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cart = Cart::factory()->create();
        $kupac = Kupac::factory()->create();

        $response = $this->put(route('carts.update', $cart), [
            'kupac_id' => $kupac->id,
        ]);

        $cart->refresh();

        $response->assertRedirect(route('carts.index'));
        $response->assertSessionHas('cart.id', $cart->id);

        $this->assertEquals($kupac->id, $cart->kupac_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cart = Cart::factory()->create();

        $response = $this->delete(route('carts.destroy', $cart));

        $response->assertRedirect(route('carts.index'));

        $this->assertModelMissing($cart);
    }
}

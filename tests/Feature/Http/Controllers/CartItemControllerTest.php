<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CartItem;
use App\Models\Korpa;
use App\Models\Proizvod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CartItemController
 */
final class CartItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $cartItems = CartItem::factory()->count(3)->create();

        $response = $this->get(route('cart-items.index'));

        $response->assertOk();
        $response->assertViewIs('cartItem.index');
        $response->assertViewHas('cartItems', $cartItems);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('cart-items.create'));

        $response->assertOk();
        $response->assertViewIs('cartItem.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartItemController::class,
            'store',
            \App\Http\Requests\CartItemStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $korpa = Korpa::factory()->create();
        $proizvod = Proizvod::factory()->create();
        $kolicina = fake()->numberBetween(-10000, 10000);
        $cena = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('cart-items.store'), [
            'korpa_id' => $korpa->id,
            'proizvod_id' => $proizvod->id,
            'kolicina' => $kolicina,
            'cena' => $cena,
        ]);

        $cartItems = CartItem::query()
            ->where('korpa_id', $korpa->id)
            ->where('proizvod_id', $proizvod->id)
            ->where('kolicina', $kolicina)
            ->where('cena', $cena)
            ->get();
        $this->assertCount(1, $cartItems);
        $cartItem = $cartItems->first();

        $response->assertRedirect(route('cartItems.index'));
        $response->assertSessionHas('cartItem.id', $cartItem->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cartItem = CartItem::factory()->create();

        $response = $this->get(route('cart-items.show', $cartItem));

        $response->assertOk();
        $response->assertViewIs('cartItem.show');
        $response->assertViewHas('cartItem', $cartItem);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cartItem = CartItem::factory()->create();

        $response = $this->get(route('cart-items.edit', $cartItem));

        $response->assertOk();
        $response->assertViewIs('cartItem.edit');
        $response->assertViewHas('cartItem', $cartItem);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CartItemController::class,
            'update',
            \App\Http\Requests\CartItemUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cartItem = CartItem::factory()->create();
        $korpa = Korpa::factory()->create();
        $proizvod = Proizvod::factory()->create();
        $kolicina = fake()->numberBetween(-10000, 10000);
        $cena = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('cart-items.update', $cartItem), [
            'korpa_id' => $korpa->id,
            'proizvod_id' => $proizvod->id,
            'kolicina' => $kolicina,
            'cena' => $cena,
        ]);

        $cartItem->refresh();

        $response->assertRedirect(route('cartItems.index'));
        $response->assertSessionHas('cartItem.id', $cartItem->id);

        $this->assertEquals($korpa->id, $cartItem->korpa_id);
        $this->assertEquals($proizvod->id, $cartItem->proizvod_id);
        $this->assertEquals($kolicina, $cartItem->kolicina);
        $this->assertEquals($cena, $cartItem->cena);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cartItem = CartItem::factory()->create();

        $response = $this->delete(route('cart-items.destroy', $cartItem));

        $response->assertRedirect(route('cartItems.index'));

        $this->assertModelMissing($cartItem);
    }
}

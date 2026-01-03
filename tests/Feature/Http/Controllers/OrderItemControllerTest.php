<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Porudzbina;
use App\Models\Proizvod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderItemController
 */
final class OrderItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $orderItems = OrderItem::factory()->count(3)->create();

        $response = $this->get(route('order-items.index'));

        $response->assertOk();
        $response->assertViewIs('orderItem.index');
        $response->assertViewHas('orderItems', $orderItems);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('order-items.create'));

        $response->assertOk();
        $response->assertViewIs('orderItem.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderItemController::class,
            'store',
            \App\Http\Requests\OrderItemStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $porudzbina = Porudzbina::factory()->create();
        $proizvod = Proizvod::factory()->create();
        $kolicina = fake()->numberBetween(-10000, 10000);
        $cena = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('order-items.store'), [
            'porudzbina_id' => $porudzbina->id,
            'proizvod_id' => $proizvod->id,
            'kolicina' => $kolicina,
            'cena' => $cena,
        ]);

        $orderItems = OrderItem::query()
            ->where('porudzbina_id', $porudzbina->id)
            ->where('proizvod_id', $proizvod->id)
            ->where('kolicina', $kolicina)
            ->where('cena', $cena)
            ->get();
        $this->assertCount(1, $orderItems);
        $orderItem = $orderItems->first();

        $response->assertRedirect(route('orderItems.index'));
        $response->assertSessionHas('orderItem.id', $orderItem->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->get(route('order-items.show', $orderItem));

        $response->assertOk();
        $response->assertViewIs('orderItem.show');
        $response->assertViewHas('orderItem', $orderItem);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->get(route('order-items.edit', $orderItem));

        $response->assertOk();
        $response->assertViewIs('orderItem.edit');
        $response->assertViewHas('orderItem', $orderItem);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderItemController::class,
            'update',
            \App\Http\Requests\OrderItemUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $orderItem = OrderItem::factory()->create();
        $porudzbina = Porudzbina::factory()->create();
        $proizvod = Proizvod::factory()->create();
        $kolicina = fake()->numberBetween(-10000, 10000);
        $cena = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('order-items.update', $orderItem), [
            'porudzbina_id' => $porudzbina->id,
            'proizvod_id' => $proizvod->id,
            'kolicina' => $kolicina,
            'cena' => $cena,
        ]);

        $orderItem->refresh();

        $response->assertRedirect(route('orderItems.index'));
        $response->assertSessionHas('orderItem.id', $orderItem->id);

        $this->assertEquals($porudzbina->id, $orderItem->porudzbina_id);
        $this->assertEquals($proizvod->id, $orderItem->proizvod_id);
        $this->assertEquals($kolicina, $orderItem->kolicina);
        $this->assertEquals($cena, $orderItem->cena);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->delete(route('order-items.destroy', $orderItem));

        $response->assertRedirect(route('orderItems.index'));

        $this->assertModelMissing($orderItem);
    }
}

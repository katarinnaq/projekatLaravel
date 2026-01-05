<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($users as $user) {

            $order = Order::create([
                'kupac_id' => $user->id,
                'status' => 'na cekanju',
            ]);

           $items = [
    [
        'proizvod_id' => 1,
        'kolicina' => 2,
    ],
    [
        'proizvod_id' => 2,
        'kolicina' => 1,
    ],
    [
        'proizvod_id' => 3,
        'kolicina' => 1,
    ],
];

            foreach ($items as $item) {
                $product = Product::find($item['proizvod_id']);

                if (!$product) {
                    continue;
                }

                OrderItem::create([
                    'porudzbina_id' => $order->id,
                    'proizvod_id' => $product->id,
                    'kolicina' => $item['kolicina'],
                    'cena' => $product->cena,
                ]);
            }

        }
    }
}

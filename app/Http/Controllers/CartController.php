<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
public function index()
{
    $cart = Cart::firstOrCreate(['kupac_id' => auth()->id()]);

    $cartItems = CartItem::with('product')
        ->where('korpa_id', $cart->id)
        ->get();

    return view('cart.index', compact('cartItems'));
}

    public function create(Request $request)
    {
        return view('cart.create');
    }

    public function store(CartStoreRequest $request)
    {
        $cart = Cart::create($request->validated());

        $request->session()->flash('cart.id', $cart->id);

        return redirect()->route('carts.index');
    }

    public function show(Request $request, Cart $cart)
    {
        return view('cart.show', [
            'cart' => $cart,
        ]);
    }

    public function edit(Request $request, Cart $cart)
    {
        return view('cart.edit', [
            'cart' => $cart,
        ]);
    }

    public function update(CartUpdateRequest $request, Cart $cart)
    {
        $cart->update($request->validated());

        $request->session()->flash('cart.id', $cart->id);

        return redirect()->route('carts.index');
    }

    public function destroy(Request $request, Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index');
    }

public function add(Product $product)
{
    $cart = Cart::firstOrCreate(
        ['kupac_id' => auth()->id()]
    );

    CartItem::create([
        'korpa_id' => $cart->id,
        'proizvod_id' => $product->id,
        'kolicina' => 1,
        'cena' => $product->cena,
    ]);

    return redirect()->back()->with('success', 'Proizvod je dodat u korpu!');
}

// za ORDER
public function checkout()
{
    $user = auth()->user();

    $cart = Cart::where('kupac_id', $user->id)->first();

    $cartItems = CartItem::where('korpa_id', $cart->id)->get();

  
    $total = $cartItems->sum(fn ($item) =>
        $item->cena * $item->kolicina
    );

    $order = Order::create([
        'kupac_id' => $user->id,
        'status' => 'Na cekanju',
    ]);

    foreach ($cartItems as $item) {
        OrderItem::create([
            'porudzbina_id' => $order->id,
            'proizvod_id' => $item->proizvod_id,
            'kolicina' => $item->kolicina,
            'cena' => $item->cena,
        ]);
    }

    CartItem::where('korpa_id', $cart->id)->delete();

    return redirect()->route('orders.show', $order)
        ->with('success', 'Porudžbina je uspešno kreirana!');
}



}

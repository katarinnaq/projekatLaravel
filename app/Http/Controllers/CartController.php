<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
public function index()
{
    // Pronađi korpu trenutnog korisnika
    $cart = Cart::firstOrCreate(['kupac_id' => auth()->id()]);

    // Uzmi sve stavke iz te korpe sa povezanim proizvodom
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
    // Pronađi ili kreiraj korpu za trenutnog korisnika
    $cart = Cart::firstOrCreate(
        ['kupac_id' => auth()->id()]
    );

    // Dodaj stavku u korpu
    CartItem::create([
        'korpa_id' => $cart->id,
        'proizvod_id' => $product->id,
        'kolicina' => 1,
        'cena' => $product->cena,
    ]);

    return redirect()->back()->with('success', 'Proizvod je dodat u korpu!');
}



}

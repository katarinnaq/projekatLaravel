<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::all();

        return view('cart.index', [
            'carts' => $carts,
        ]);
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
}

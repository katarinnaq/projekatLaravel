<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemStoreRequest;
use App\Http\Requests\CartItemUpdateRequest;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = CartItem::all();

        return view('cartItem.index', [
            'cartItems' => $cartItems,
        ]);
    }

    public function create(Request $request)
    {
        return view('cartItem.create');
    }

    public function store(CartItemStoreRequest $request)
    {
        $cartItem = CartItem::create($request->validated());

        $request->session()->flash('cartItem.id', $cartItem->id);

        return redirect()->route('carts.index');
    }

    public function show(Request $request, CartItem $cartItem)
    {
        return view('cartItem.show', [
            'cartItem' => $cartItem,
        ]);
    }

    public function edit(Request $request, CartItem $cartItem)
    {
        return view('cartItem.edit', [
            'cartItem' => $cartItem,
        ]);
    }

    public function update(CartItemUpdateRequest $request, CartItem $cartItem)
    {
        $cartItem->update($request->validated());

        $request->session()->flash('cartItem.id', $cartItem->id);

        return redirect()->route('carts.index');
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        $cartItem->delete();

        return redirect()->route('carts.index');
    }
}

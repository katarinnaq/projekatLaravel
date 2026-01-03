<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemStoreRequest;
use App\Http\Requests\CartItemUpdateRequest;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartItemController extends Controller
{
    public function index(Request $request): Response
    {
        $cartItems = CartItem::all();

        return view('cartItem.index', [
            'cartItems' => $cartItems,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('cartItem.create');
    }

    public function store(CartItemStoreRequest $request): Response
    {
        $cartItem = CartItem::create($request->validated());

        $request->session()->flash('cartItem.id', $cartItem->id);

        return redirect()->route('cartItems.index');
    }

    public function show(Request $request, CartItem $cartItem): Response
    {
        return view('cartItem.show', [
            'cartItem' => $cartItem,
        ]);
    }

    public function edit(Request $request, CartItem $cartItem): Response
    {
        return view('cartItem.edit', [
            'cartItem' => $cartItem,
        ]);
    }

    public function update(CartItemUpdateRequest $request, CartItem $cartItem): Response
    {
        $cartItem->update($request->validated());

        $request->session()->flash('cartItem.id', $cartItem->id);

        return redirect()->route('cartItems.index');
    }

    public function destroy(Request $request, CartItem $cartItem): Response
    {
        $cartItem->delete();

        return redirect()->route('cartItems.index');
    }
}

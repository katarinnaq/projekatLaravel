<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::all();

        return view('order.index', [
            'orders' => $orders,
        ]);
    }

    public function create(Request $request)
    {
        return view('order.create');
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create($request->validated());

        $request->session()->flash('order.id', $order->id);

        return redirect()->route('orders.index');
    }

    public function show(Request $request, Order $order)
    {
        return view('order.show', [
            'order' => $order,
        ]);
    }

    public function edit(Request $request, Order $order)
    {
        return view('order.edit', [
            'order' => $order,
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());

        $request->session()->flash('order.id', $order->id);

        return redirect()->route('orders.index');
    }
public function destroy(Order $order)
{
    // Obrisi sve stavke porudzbine pre brisanja same porudzbine
    $order->orderItems()->delete();

    $order->delete();

    return redirect()->route('orders.index')
                     ->with('success', 'Porudžbina je uspešno obrisana!');
}


 public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:na cekanju,u obradi,poslata,zavrsena',
    ]);

    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Status porudžbine je uspešno promenjen!');
}




}

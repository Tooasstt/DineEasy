<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;

class DeliveryController extends Controller
{
    public function index() {
        $deliveries = Delivery::with('order')->get();
        return view('deliveries.index', compact('deliveries'));
    }

    public function create() {
        $orders = Order::all();
        return view('deliveries.create', compact('orders'));
    }

    public function store(Request $request) {
        Delivery::create($request->all());
        return redirect()->route('deliveries.index')->with('success', 'Delivery added');
    }

    public function edit($id) {
        $delivery = Delivery::findOrFail($id);
        $orders = Order::all();
        return view('deliveries.edit', compact('delivery', 'orders'));
    }

    public function update(Request $request, $id) {
        $delivery = Delivery::findOrFail($id);
        $delivery->update($request->all());
        return redirect()->route('deliveries.index')->with('success', 'Delivery updated');
    }

    public function destroy($id) {
        Delivery::findOrFail($id)->delete();
        return redirect()->route('deliveries.index')->with('success', 'Delivery deleted');
    }
}

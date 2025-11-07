<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

class MainController extends Controller
{
   
    public function index(){
    $menus = Menu::all();

    $orders = Order::with(['orderItems.menu'])
    ->orderBy('orders_id', 'DESC')
    ->get();

    return view('dashboard', compact('menus', 'orders'));

    }

    //MENU CRUD 
    public function addMenu(Request $req) {
        Menu::create($req->all());
        return back()->with('success', 'Menu Item Added');
    }

    public function deleteMenu($id)  {
        Menu::destroy($id);
        return back()->with('success', 'Menu Item Deleted');
    }

    //ORDER CRUD 
   public function addOrder(Request $req){
    $customerId = $req->customer_id ?? null; 

    $order = Order::create([
        'status' => 'pending',
        'total_price' => 0,
    ]);

    $total = 0;

    if ($req->menu_id) {
        foreach ($req->quantity as $menuId => $qty) {
         if ($qty > 0) {
        $menu = Menu::find($menuId);
        $notes = $req->notes[$menuId] ?? null;

        $subtotal = $menu->price * $qty;

        OrderItem::create([
            'order_id' => $order->orders_id,
            'menu_id' => $menuId,
            'quantity' => $qty,
            'subtotal' => $subtotal,
            'notes' => $notes
        ]);

            $total += $subtotal;
         }
        }

    }

    $order->update(['total_price' => $total]);

    return back()->with('success', 'Order Created');
    }

    public function deleteOrder($id){
    \App\Models\OrderItem::where('order_id', $id)->delete();

    Order::destroy($id);

    return back()->with('success', 'Order Deleted');
    }

    //ORDER ITEM CRUD
    public function addOrderItem(Request $req){
        OrderItem::create($req->all());
        return back()->with('success', 'Order Item Added');
    }

    public function deleteOrderItem($id)
    {
        OrderItem::destroy($id);
        return back()->with('success', 'Order Item Deleted');
    }
    public function updateOrder(Request $req, $id)
{
    $order = Order::find($id);
    $total = 0;

    foreach ($req->quantity as $itemId => $qty) {
        $orderItem = OrderItem::find($itemId);

        if ($orderItem) {
            $orderItem->quantity = $qty;
            $orderItem->notes = $req->notes[$itemId] ?? null;
            $orderItem->subtotal = $orderItem->menu->price * $qty;
            $orderItem->save();
            $total += $orderItem->subtotal;
        }
    }

    $order->update(['total_price' => $total]);

    return back()->with('success', 'Order Updated Successfully!');
}


}

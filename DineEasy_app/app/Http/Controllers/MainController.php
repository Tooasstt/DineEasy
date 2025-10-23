<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

class MainController extends Controller
{
    // Show dashboard
    public function index(){
        $customers = Customer::all();
        $menus = Menu::all();
        $orders = Order::with('customer')->get();
        $orderItems = OrderItem::with(['order', 'menu'])->get();
        return view('dashboard', compact('customers', 'menus', 'orders', 'orderItems'));
    }

    // ===== CUSTOMER CRUD =====
    public function addCustomer(Request $req){
        Customer::create($req->all());
        return back()->with('success', 'Customer Added');
    }

    public function deleteCustomer($id) {
        Customer::destroy($id);
        return back()->with('success', 'Customer Deleted');
    }

    // ===== MENU CRUD =====
    public function addMenu(Request $req) {
        Menu::create($req->all());
        return back()->with('success', 'Menu Item Added');
    }

    public function deleteMenu($id)  {
        Menu::destroy($id);
        return back()->with('success', 'Menu Item Deleted');
    }

    // ===== ORDER CRUD =====
   public function addOrder(Request $req)
{
  
    $order = Order::create([
        'customer_id' => $req->customer_id,
        'status' => 'pending',
        'total_price' => 0,
    ]);

    $orderId = $order->orders_id; 
    $total = 0;

    
    if ($req->menu_id && is_array($req->menu_id)) {
        foreach ($req->menu_id as $index => $menuId) {
            $menu = Menu::find($menuId);
            $qty = $req->quantity[$index];
            $subtotal = $menu->price * $qty;

            OrderItem::create([
                'order_id' => $orderId,
                'menu_id' => $menuId,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }
    }

    $order->update(['total_price' => $total]);

    return back()->with('success', 'Order Created');
}

    public function deleteOrder($id)  {
        Order::destroy($id);
        return back()->with('success', 'Order Deleted');
    }

    // ===== ORDER ITEM CRUD =====
    public function addOrderItem(Request $req){
        OrderItem::create($req->all());
        return back()->with('success', 'Order Item Added');
    }

    public function deleteOrderItem($id)
    {
        OrderItem::destroy($id);
        return back()->with('success', 'Order Item Deleted');
    }
}

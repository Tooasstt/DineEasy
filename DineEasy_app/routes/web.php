<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Models\Order;

// Kiosk dashboard
Route::get('/', [MainController::class, 'index'])->name('dashboard');

// Menus
Route::post('/menus/add', [MainController::class, 'addMenu'])->name('menus.add');
Route::post('/menus/delete/{id}', [MainController::class, 'deleteMenu'])->name('menus.delete');

// Orders
Route::post('/orders/add', [MainController::class, 'addOrder'])->name('orders.add');
Route::post('/orders/delete/{id}', [MainController::class, 'deleteOrder'])->name('orders.delete');
Route::post('/orders/update/{id}', [MainController::class, 'updateOrder'])->name('orders.update');

// API
Route::get('/api/order/{id}', function ($id) {
    $order = Order::with('orderItems.menu')->find($id);
    if (!$order) return response()->json(['items' => []]);

    $items = $order->orderItems->map(function ($i) {
        return [
            'order_item_id' => $i->order_item_id,
            'menu_id' => $i->menu_id,
            'name' => $i->menu->item_name ?? 'Unknown Item',
            'price' => (float)($i->menu->price ?? 0),
            'quantity' => (int)$i->quantity,
            'notes' => $i->notes ?? '',
        ];
    });

    return response()->json(['items' => $items]);
});

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::post('/menus/toggle/{id}', [MainController::class, 'toggleAvailability'])->name('menus.toggle');
Route::post('/menus/update/{id}', [MainController::class, 'updateMenu'])->name('menus.update');
Route::post('/admin/menu/update/{id}', [AdminController::class, 'updateMenu'])->name('admin.menu.update');


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('dashboard');

//CUSTOMERS
// Route::post('/customers/add', [MainController::class, 'addCustomer'])->name('customers.add');
// Route::post('/customers/delete/{id}', [MainController::class, 'deleteCustomer'])->name('customers.delete');

//MENUS 
Route::post('/menus/add', [MainController::class, 'addMenu'])->name('menus.add');
Route::post('/menus/delete/{id}', [MainController::class, 'deleteMenu'])->name('menus.delete');

//ORDERS
Route::post('/orders/add', [MainController::class, 'addOrder'])->name('orders.add');
Route::post('/orders/delete/{id}', [MainController::class, 'deleteOrder'])->name('orders.delete');

//ORDER ITEMS
Route::post('/orderitems/add', [MainController::class, 'addOrderItem'])->name('orderitems.add');
Route::post('/orderitems/delete/{id}', [MainController::class, 'deleteOrderItem'])->name('orderitems.delete');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;

// Admin / Login page
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login.page');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

// Kiosk / POS page
Route::get('/', [MainController::class, 'index'])->name('dashboard');

//Menus
Route::post('/menus/add', [MainController::class, 'addMenu'])->name('menus.add');
Route::post('/menus/delete/{id}', [MainController::class, 'deleteMenu'])->name('menus.delete');

//Orders (walk-in only)
Route::post('/orders/add', [MainController::class, 'addOrder'])->name('orders.add');
Route::post('/orders/delete/{id}', [MainController::class, 'deleteOrder'])->name('orders.delete');

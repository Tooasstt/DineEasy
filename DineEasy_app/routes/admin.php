Route::get('/kiosk', function () {
    return view('kiosk.index', [
        'menus' => \App\Models\Menu::all(),
        'orders' => \App\Models\Order::with('orderItems.menu')->latest()->get()
    ]);
})->middleware('auth')->name('kiosk.dashboard');

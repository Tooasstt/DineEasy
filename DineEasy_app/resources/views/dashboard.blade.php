<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineEasy Self-Order Kiosk</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>
<header>
    DineEasy Self-Order Kiosk
</header>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

   
    <div class="order-summary">
        <h2>Select Items</h2>

        <form action="{{ route('orders.add') }}" method="POST">
            @csrf

           @foreach ($menus as $m)
            <div class="d-flex align-items-center mb-2">
            <input type="checkbox" name="menu_id[]" value="{{ $m->menu_id }}" class="form-check-input me-2" style="transform: scale(1.3);">

            <label class="me-2" style="min-width:200px;">
            {{ $m->item_name }} — ₱{{ number_format($m->price,2) }}
            </label>

            <input type="number"
             name="quantity[]"
            class="qty-input form-control ms-3"
            data-price="{{ $m->price }}"
             placeholder="0"
             min="0"
             style="width:80px;">
           </div>
            @endforeach

            <hr>

            <h3>Total: ₱<span id="orderTotal">0.00</span></h3>

            <button type="submit" class="add-btn">Place Order </button>
        </form>
    </div>

    
    <div class="order-summary">
        <h2>Recent Orders</h2>

        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
@foreach($orders as $order)
<tr>
    <td>{{ $order->orders_id }}</td>
    <td>
        @forelse($order->orderItems as $item)
            {{ $item->menu->item_name ?? 'Unknown Item' }} × {{ $item->quantity }}<br>
        @empty
            —
        @endforelse
    </td>
    <td>₱{{ number_format($order->total_price, 2) }}</td>
    <td>{{ ucfirst($order->status) }}</td>
    <td>
        <form action="{{ route('orders.delete', $order->orders_id) }}" method="POST">
            @csrf
            <button class="payment-btn">Delete</button>
        </form>
    </td>
</tr>
@endforeach

        </table>
    </div>

</div>

<footer>
    © 2025 DineEasy - Walk-In Ordering System
</footer>

<script>
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', calculateTotal);
});

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.qty-input').forEach(input => {
        const price = parseFloat(input.dataset.price);
        const qty = parseInt(input.value) || 0;
        total += price * qty;
    });

    document.getElementById('orderTotal').textContent = total.toFixed(2);
}
</script>

</body>
</html>

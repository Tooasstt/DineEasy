<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineEasy Self-Order Kiosk</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>


<div style="
    background: linear-gradient(135deg, #5c4fd7, #7361f2);
    text-align:center;
    padding: 20px 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.25);  
">
    
    <img src="{{ asset('images/DineEasyLogo.png') }}" 
         alt="DineEasy Logo" 
         style="height:180px; margin:0 auto; display:block;">

    <h1 style="
        margin: 0;
        margin-top: 5px;
        font-size: 36px;
        font-weight: 700;
        color: #fff;">
        Self-Order Kiosk
    </h1>

</div>




<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('orders.add') }}" method="POST">
        @csrf

        <div class="flex justify-between items-center text-center">

            <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:25px;">
    @foreach($menus as $m)
    <div style="
        flex: 0 0 280px;
        background:#fff;
        border-radius:16px;
        padding:20px;
        text-align:center;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    " 
    onmouseover="this.style.transform='scale(1.02)'" 
    onmouseout="this.style.transform='scale(1)'">

        <img 
            src="{{ $m->image ? asset('images/menu/'.$m->image) : asset('images/default.png') }}" class="menu-img"
            alt="{{ $m->item_name }}"
            style="width:180px; height:150px; object-fit:cover; border-radius:12px; margin-bottom:10px;"
        >

        <h3 style="margin:5px 0;">{{ $m->item_name }}</h3>
        <p style="font-weight:bold; color:#333;">₱{{ number_format($m->price,2) }}</p>

        <input type="hidden" name="menu_id[]" value="{{ $m->menu_id }}">
        
        <div style="display:flex; justify-content:center; gap:5px;"> 
    <input
    type="number"
    name="quantity[{{ $m->menu_id }}]"
    class="qty-input"
    data-price="{{ $m->price }}"
    value="0"
    min="0"
    style="width:60px; font-size:18px; padding:5px;"
>




        </div>
    </div>
    @endforeach
</div>


        </div>

        <hr style="margin:25px 0;">

        <h2 style="text-align:center;">Total: ₱<span id="orderTotal">0.00</span></h2>

        <div style="text-align:center;">
            <button type="submit" class="add-btn">Place Order</button>
        </div>

    </form>


    {{-- RECENT ORDERS --}}
    <div class="order-summary">
    <h2>Recent Orders</h2>

    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->orders_id }}</td>

                <td>
                    @forelse($order->orderItems as $item)
                        {{ $item->menu->item_name ?? 'Unknown' }} × {{ $item->quantity }}<br>
                    @empty
                        —
                    @endforelse
                </td>

                <td>₱{{ number_format($order->total_price, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>

                <td style="white-space:nowrap;">
    <button class="payment-btn edit-btn" data-id="{{ $order->orders_id }}">
        Edit
    </button>

    <form action="{{ route('orders.delete', $order->orders_id) }}" method="POST" style="display:inline;">
        @csrf
        <button class="payment-btn">Delete</button>
    </form>
</td>


                   
            @endforeach
        </tbody>
    </table>
</div>
<div style="text-align:center; margin-top:20px;">
    <button class="payment-btn" id="checkoutBtn">Checkout</button>
</div>

@if(session('success'))
<script>alert("✅ {{ session('success') }}");</script>
@endif


<footer>
    © 2025 DineEasy - Walk-In Ordering System <br>
    <a href="{{ route('admin.login') }}" class="payment-btn" style="margin-top:10px;">Go to Admin</a>
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
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Order</h3>

        <form method="POST" id="editForm">
            @csrf
            <div id="editItemsContainer"></div>

            <br>
            <button class="add-btn">Save Changes</button>
            <button type="button" id="closeModal" class="payment-btn">Cancel</button>
        </form>

    </div>
</div>

<script>
function closeModal(){ document.getElementById('editModal').style.display='none'; }
</script>
<script>
document.querySelectorAll('.editBtn').forEach(btn=>{
    btn.addEventListener('click', function(){
        const orderId = this.dataset.id;

        fetch(`/api/order/${orderId}`)
        .then(res=>res.json())
        .then(data=>{
            let table = "";
            data.items.forEach(item=>{
                table += `
                <tr>
                    <td>${item.name}</td>
                    <td><input type="number" name="quantity[${item.menu_id}]" value="${item.quantity}" min="0" style="width:50px"></td>
                </tr>`;
            });

            document.getElementById('editItems').innerHTML = table;
            document.getElementById('editForm').action = "/orders/update/" + orderId;
            document.getElementById('editModal').style.display = 'block';
        });
    });
});
</script>
<div id="checkoutModal" class="modal">
    <div class="modal-content">
        <h3>Order Summary</h3>
        <div id="checkoutItems"></div>

        <h3 style="margin-top:10px;">Total: ₱<span id="checkoutTotal">0.00</span></h3>

        <br>
        <form action="{{ route('orders.add') }}" method="POST" id="checkoutForm">
            @csrf
        </form>

        <button class="add-btn" id="confirmCheckout">Confirm Order</button>
        <button type="button" class="payment-btn" onclick="closeCheckout()">Cancel</button>
    </div>
</div>

<script>
function closeCheckout(){
    document.getElementById('checkoutModal').style.display = 'none';
}
</script>

<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        let orderId = this.dataset.id;
        let modal = document.getElementById('editModal');
        modal.style.display = 'flex';

        fetch(`/api/order/${orderId}`)
            .then(response => response.json())
            .then(data => {
                let container = document.getElementById('editItemsContainer');
                container.innerHTML = ''; 
                if (data.items.length === 0) {
                    container.innerHTML = "<p>No items found for this order.</p>";
                    return;
                }

                data.items.forEach(item => {
                    container.innerHTML += `
                        <div style="margin-bottom:10px;">
                            <strong>${item.name}</strong><br>
                            <label style="display:block; margin-top:6px;">Quantity:</label>
                            <input type="number"
                                class="qty-box"
                                name="quantity[${item.order_item_id}]"
                                value="${item.quantity}" min="1">

                                <label style="display:block; margin-top:6px;">Notes:</label>
                                <input type="text"
                                        class="note-box"
                                        name="notes[${item.order_item_id}]"
                                        value="${item.notes ?? ''}"
                                        placeholder="Add notes...">

                        </div>
                    `;
                });

                
                document.getElementById('editForm').action = `/orders/update/${orderId}`;
            });
    });
});

document.getElementById('closeModal').onclick = () => {
    document.getElementById('editModal').style.display = 'none';
};
document.getElementById("checkoutBtn").onclick = function () {
    let lastOrderRow = document.querySelector("tbody tr:first-child");

    if (!lastOrderRow) {
        alert("No orders yet.");
        return;
    }

    let orderId = lastOrderRow.children[0].innerText;

    fetch(`/api/order/${orderId}`)
        .then(res => res.json())
        .then(data => {
            let summary = "";
            let total = 0;

            data.items.forEach(item => {
                summary += `
                    <p><strong>${item.name}</strong> × ${item.quantity}<br>
                    ${item.notes ? "Notes: " + item.notes : ""}</p>
                `;
                total += (parseFloat(item.price) || 0) * (parseInt(item.quantity) || 0);


            });

            document.getElementById("checkoutItems").innerHTML = summary;
            document.getElementById("checkoutTotal").innerText = total.toFixed(2);
            document.getElementById("checkoutModal").style.display = "flex";
        });
};
document.getElementById("confirmCheckout").onclick = function () {
    alert("✅ Order Confirmed!");
    closeCheckout();
};

</script>



</body>
</html>

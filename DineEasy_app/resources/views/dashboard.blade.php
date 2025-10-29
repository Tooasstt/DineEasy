<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineEasy Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js']) 
</head>
<body class="bg-light">

<div class="container py-4">
    <h1 class="mb-4 text-center">DineEasy Management Dashboard</h1>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ========== CUSTOMERS TABLE ========== --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Customers</div>
        <div class="card-body">
            <form action="{{ route('customers.add') }}" method="POST" class="row g-2 mb-3">
                @csrf
                <div class="col"><input type="text" name="name" placeholder="Name" class="form-control" required></div>
                <div class="col"><input type="text" name="address" placeholder="Address" class="form-control" required></div>
                <div class="col"><input type="text" name="contact_number" placeholder="Contact Number" class="form-control" required></div>
                <div class="col-auto"><button class="btn btn-success">Add</button></div>
            </form>

            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $c)
                    <tr>
                        <td>{{ $c->cust_id }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->address }}</td>
                        <td>{{ $c->contact_number }}</td>
                        <td>
                            <form action="{{ route('customers.delete', $c->cust_id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========== MENUS TABLE ========== --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">Menu Items</div>
        <div class="card-body">
            <form action="{{ route('menus.add') }}" method="POST" class="row g-2 mb-3">
                @csrf
                <div class="col"><input type="text" name="item_name" placeholder="Item Name" class="form-control" required></div>
                <div class="col"><input type="text" name="description" placeholder="Description" class="form-control"></div>
                <div class="col"><input type="number" step="0.01" name="price" placeholder="Price" class="form-control" required></div>
                <div class="col-auto"><button class="btn btn-success">Add</button></div>
            </form>

            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $m)
                    <tr>
                        <td>{{ $m->menu_id }}</td>
                        <td>{{ $m->item_name }}</td>
                        <td>{{ $m->description }}</td>
                        <td>₱{{ $m->price }}</td>
                        <td>{{ $m->availability ? 'Available' : 'Unavailable' }}</td>
                        <td>
                            <form action="{{ route('menus.delete', $m->menu_id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========== ORDERS TABLE ========== --}}
    <div class="card mb-4">
  <div class="card-header bg-warning text-dark">Create New Order</div>
  <div class="card-body">
    <form action="{{ route('orders.add') }}" method="POST">
      @csrf

      <div class="mb-2">
        <label>Customer:</label>
        <select name="customer_id" class="form-control" required>
          <option value="">-- Select Customer --</option>
          @foreach ($customers as $c)
            <option value="{{ $c->cust_id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>

     <form action="{{ route('orders.add') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Menu Items:</label><br>
        @foreach ($menus as $m)
            <div class="d-flex align-items-center mb-1">
                <input type="checkbox" name="menu_id[]" value="{{ $m->menu_id }}">
                <span class="ms-2">{{ $m->item_name }} (₱{{ $m->price }})</span>
                <input type="number" name="quantity[]" class="form-control ms-3" placeholder="Qty" min="1" style="width: 80px;">
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Add Order</button>
</form>
  </div>
</div>

    {{-- ========== ORDER ITEMS TABLE ========== --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-dark">Order Items</div>
        <div class="card-body">
            <form action="{{ route('orderitems.add') }}" method="POST" class="row g-2 mb-3">
                @csrf
                <div class="col"><input type="number" name="order_id" placeholder="Order ID" class="form-control" required></div>
                <div class="col"><input type="number" name="menu_id" placeholder="Menu ID" class="form-control" required></div>
                <div class="col"><input type="number" name="quantity" placeholder="Quantity" class="form-control" required></div>
                <div class="col"><input type="number" step="0.01" name="subtotal" placeholder="Subtotal" class="form-control"></div>
                <div class="col-auto"><button class="btn btn-success">Add</button></div>
            </form>

            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Menu</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $oi)
                    <tr>
                        <td>{{ $oi->order_item_id }}</td>
                        <td>{{ $oi->order_id }}</td>
                        <td>{{ $oi->menu ? $oi->menu->item_name : 'N/A' }}</td>
                        <td>{{ $oi->quantity }}</td>
                        <td>₱{{ $oi->subtotal }}</td>
                        <td>
                            <form action="{{ route('orderitems.delete', $oi->order_item_id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>

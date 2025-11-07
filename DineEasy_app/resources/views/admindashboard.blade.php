<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - DineEasy</title>
  @vite(['resources/css/app.css'])
</head>
<body>
<header>
  DineEasy Admin Dashboard
  <a href="{{route('logout')}}" style="float:right;color:white;">Logout</a>
</header>

<div class="container py-4 order-summary">
@if(session('success'))<div class="alert alert-success">{{session('success')}}</div>@endif

<h2>Add Menu Item</h2>
<form action="{{route('admin.menu.add')}}" method="POST" enctype="multipart/form-data" class="mb-4">
@csrf
<input type="text" name="item_name" placeholder="Item name" required class="form-control mb-2">
<input type="text" name="description" placeholder="Description" class="form-control mb-2">
<input type="number" step="0.01" name="price" placeholder="Price" required class="form-control mb-2">
<input type="file" name="image" class="form-control mb-2">
<button class="add-btn">Add</button>
</form>

<table>
<thead><tr><th>Image</th><th>Name</th><th>Description</th><th>Price</th><th>Action</th></tr></thead>
<tbody>
@foreach($menus as $m)
<tr>
<td>@if($m->image)<img src="{{asset('images/'.$m->image)}}" width="60">@endif</td>
<td>{{$m->item_name}}</td>
<td>{{$m->description}}</td>
<td>₱{{$m->price}}</td>
<td>
<form action="{{route('admin.menu.delete',$m->menu_id)}}" method="POST">@csrf
<button class="payment-btn">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</body>
</html>

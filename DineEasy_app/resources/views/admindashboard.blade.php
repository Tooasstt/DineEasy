<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - DineEasy</title>
  @vite(['resources/css/app.css'])
</head>
<body>
<div style="
    background: linear-gradient(135deg, #5c4fd7, #7361f2);
    padding: 20px 0 40px 0;
    position: relative;
    box-shadow: 0 4px 15px rgba(0,0,0,0.25);
    text-align: center;
">

 
    <a href="/" class="top-btn" style="
        position: absolute;
        right: 25px;
        top: 25px;
    ">Back to Kiosk</a>

    
    <img src="{{ asset('images/DineEasyLogo.png') }}" 
         alt="DineEasy Logo" 
         style="height:180px; display:block; margin:0 auto;">
    
    
    <h1 style="
        margin-top: 5px; 
        font-size: 36px; 
        font-weight: 700; 
        color:#fff;">
        Admin Panel
    </h1>

</div>

   


<div class="container py-4 order-summary">
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<h2 style="margin-bottom:15px;">Add Menu Item</h2>

<form action="{{ route('menus.add') }}" method="POST" enctype="multipart/form-data" class="mb-4">
@csrf

<div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">

    <input type="text" name="item_name" placeholder="Item Name" required
           style="flex:1; min-width:180px; padding:10px; border-radius:6px; border:1px solid #ccc;">

    <input type="text" name="description" placeholder="Description"
           style="flex:2; min-width:250px; padding:10px; border-radius:6px; border:1px solid #ccc;">

    <input type="number" step="0.01" name="price" placeholder="Price" required
           style="width:140px; padding:10px; border-radius:6px; border:1px solid #ccc;">

    
    <label style="background:#6b5bfb; color:white; padding:10px 15px; border-radius:6px; cursor:pointer;">
        Upload Image
        <input type="file" name="image" accept="image/*" style="display:none;">
    </label>

    <button type="submit" class="add-btn" 
            style="margin-left:auto; background:#6b5bfb; color:white; border:none; border-radius:6px; padding:10px 18px; cursor:pointer;">
        Add
    </button>

</div>
</form>




<table>
<thead>
<tr>
    <th>Image</th>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($menus as $m)
<tr>

    
    <td>
        @if($m->image && file_exists(public_path('images/menu/' . $m->image)))
            <img src="{{ asset('images/menu/' . $m->image) }}" width="60" style="border-radius:6px;">
        @else
            <span style="color:gray;">No Image</span>
        @endif
    </td>

   
    <td>{{ $m->item_name }}</td>

    
    <td>{{ $m->description }}</td>

   
    <td>₱{{ number_format($m->price, 2) }}</td>

    
    <td style="white-space:nowrap;">

       
        <form action="{{ route('menus.toggle', $m->menu_id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button class="payment-btn" style="background:#4caf50;">
                {{ $m->availability == 1 ? 'Available' : 'Unavailable' }}
            </button>
        </form>

     
      <button 
    class="payment-btn" 
    style="background:#2196F3;"
    onclick="openModal('{{ $m->menu_id }}', '{{ $m->item_name }}', '{{ $m->description }}', '{{ $m->price }}')">
    Edit
</button>


     
        <form action="{{ route('menus.delete', $m->menu_id) }}" method="POST" style="display:inline-block;">
            @csrf
            <button class="payment-btn" style="background:#d9534f;">Delete</button>
        </form>

       
    </td>

</tr>
@endforeach
</tbody>
</table>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>

        <h3>Edit Menu Item</h3>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="text" name="item_name" id="edit_name" placeholder="Item Name" class="modal-input" required>
            <input type="text" name="description" id="edit_desc" placeholder="Description" class="modal-input">
            <input type="number" step="0.01" name="price" id="edit_price" placeholder="Price" class="modal-input">
            
            <label>Replace Image (optional)</label>
            <input type="file" name="image" class="modal-input">

            <button class="save-btn">Update</button>
        </form>
    </div>
</div>


</div>
<script>
document.getElementById('menuImageInput').addEventListener('change', function(){
    let fileName = this.files.length > 0 ? this.files[0].name : "📷 Upload Image";
    document.getElementById('uploadText').innerText = "📷 " + fileName;
});
function openEdit(id) {
    fetch('/api/menu/'+id) // you already have this API
    .then(res => res.json())
    .then(data => {
        document.getElementById('editName').value = data.items[0].name;
        document.getElementById('editDesc').value = data.items[0].description;
        document.getElementById('editPrice').value = data.items[0].price;

        document.getElementById('editForm').action = '/menus/update/' + id;
        document.getElementById('editModal').style.display = 'block';
    });
}
</script>
<script>
function openModal(id, name, desc, price) {
    document.getElementById("editModal").style.display = "block";

    // Fill form fields
    document.getElementById("edit_name").value = name;
    document.getElementById("edit_desc").value = desc;
    document.getElementById("edit_price").value = price;

    // Update form action
    document.getElementById("editForm").action = "/admin/menu/update/" + id;
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

// Close when clicking outside modal
window.onclick = function(e) {
    let modal = document.getElementById("editModal");
    if (e.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>

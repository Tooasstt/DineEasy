<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function showLogin() {
        return view('admin_login');
    }

public function login(Request $req)
{
    if ($req->email == 'admin@dineeasy.com' && $req->password == '12345') {
        session(['admin_logged_in' => true]);
        return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Invalid credentials');
}



   public function logout()
{
    session()->forget('admin_logged_in');
    return redirect()->route('admin.login');
}
public function dashboard()
{
    $menus = \App\Models\Menu::all(); // fetch all menu items
    return view('admindashboard', compact('menus'));
}



    public function addMenu(Request $r) {
        $img=null;
        if($r->hasFile('image')){
            $img=time().'.'.$r->image->extension();
            $r->image->move(public_path('images'),$img);
        }
        Menu::create([
            'item_name'=>$r->item_name,
            'description'=>$r->description,
            'price'=>$r->price,
            'image'=>$img
        ]);
        return back()->with('success','Item added');
    }

   
    public function updateMenu(Request $req, $id){
    $menu = Menu::find($id);

    if (!$menu) return back()->with('error', 'Menu not found');

    $menu->item_name = $req->item_name;
    $menu->description = $req->description;
    $menu->price = $req->price;

    if ($req->hasFile('image')) {
        $filename = time() . '_' . $req->image->getClientOriginalName();
        $req->image->move(public_path('images/menu'), $filename);
        $menu->image = $filename;
    }

    $menu->save();

    return back()->with('success', 'Menu Updated Successfully');
    }

    public function deleteMenu($id){
        Menu::destroy($id);
        return back()->with('success','Item deleted');
    }


}

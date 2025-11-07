<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function showLogin() {
        return view('admin_login');
    }

    public function login(Request $r) {
        $user = DB::table('users')
            ->where('email',$r->email)
            ->where('password',$r->password)
            ->first();
        if(!$user) return back()->with('error','Invalid credentials');
        session(['admin'=>$user]);
        return redirect()->route('admin.dashboard');
    }

    public function logout() {
        session()->forget('admin');
        return redirect('/');
    }

    public function dashboard() {
        $menus = Menu::all();
        return view('admin_dashboard',compact('menus'));
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

    public function updateMenu(Request $r,$id) {
        $m=Menu::find($id);
        if(!$m) return back();
        if($r->hasFile('image')){
            $img=time().'.'.$r->image->extension();
            $r->image->move(public_path('images'),$img);
            $m->image=$img;
        }
        $m->item_name=$r->item_name;
        $m->description=$r->description;
        $m->price=$r->price;
        $m->save();
        return back()->with('success','Item updated');
    }

    public function deleteMenu($id){
        Menu::destroy($id);
        return back()->with('success','Item deleted');
    }
}

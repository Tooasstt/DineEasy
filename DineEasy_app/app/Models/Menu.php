<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'menu_id';
    public $timestamps = true;

   protected $fillable = [
    'item_name',
    'description',
    'price',
    'image',
    'availability'
];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'menu_id');
    }
}

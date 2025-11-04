<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'orders_id';
    protected $fillable = ['status', 'total_price'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'orders_id');
    }
}

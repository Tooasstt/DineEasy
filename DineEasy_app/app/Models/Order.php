<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'orders_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'customer_id',
        'status',
        'total_price',
    ];

   
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'cust_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'orders_id');
    }
}

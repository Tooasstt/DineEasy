<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    protected $primaryKey = 'cust_id';
    public $timestamps = true;

    protected $fillable = [
        'name', 
        'contact_number', 
        'address'
    ];

    public function orders(){
    return $this->hasMany(Order::class, 'customer_id', 'cust_id');
    }
}

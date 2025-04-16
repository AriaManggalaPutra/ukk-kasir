<?php

namespace App\Models\Pembelian;

use App\Models\Customer\Customer;
use App\Models\OrderDetail\OrderDetail;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{

    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_price',
        'discount',
        'final_price',
        'amount_paid',
        'change',
        'payment_method',
        'user_id'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

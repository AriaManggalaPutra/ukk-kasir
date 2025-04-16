<?php

namespace App\Models\Product;

use App\Models\OrderDetail\OrderDetail;
use App\Models\Pembelian\Pembelian\Pembelian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;

    // 'name',
    // 'price',
    // 'stock',
    // 'image',

    protected $fillable = [
        'product_image',
        'product_name',
        'price',
        'stock'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Pembelian::class, 'order_details')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}

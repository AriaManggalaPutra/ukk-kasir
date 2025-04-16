<?php

namespace App\Models\OrderDetail;

use App\Models\Pembelian\Pembelian\Pembelian;



use App\Models\Product\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Pembelian::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

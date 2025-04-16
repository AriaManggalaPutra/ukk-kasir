<?php

namespace App\Models\Customer;

use App\Models\Pembelian\Pembelian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'points', 'customer_status'];


    public function orders()
    {
        return $this->hasMany(Pembelian::class);
    }


}

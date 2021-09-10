<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'unitPrice'
    ];
    public function product() {
        return $this->hasOne(Product::class, 'id', 'productId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_code',
        'order_date',
        'order_amount',
        'order_status',
        'order_change',
    ];

    public function category()
    {
        return $this->hasMany(Categories::class, 'id', 'category_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}

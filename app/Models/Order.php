<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['table_id', 'total_price', 'status'];

    // Define a relationship to the OrderItem model
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Add an accessor to get the total amount for an order
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}

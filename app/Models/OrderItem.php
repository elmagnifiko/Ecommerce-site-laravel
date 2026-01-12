<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Un article de commande appartient à une commande
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Un article de commande appartient à un produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
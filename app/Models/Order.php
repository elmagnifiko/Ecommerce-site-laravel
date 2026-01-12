<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'phone'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Une commande appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une commande a plusieurs articles
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
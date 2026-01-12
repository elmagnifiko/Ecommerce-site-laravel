<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Un item du panier appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un item du panier appartient à un produit
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
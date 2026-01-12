<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 
        'name', 
        'slug', 
        'description', 
        'price', 
        'stock', 
        'image', 
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Un produit appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Un produit peut être dans plusieurs paniers
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Un produit peut être dans plusieurs commandes
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
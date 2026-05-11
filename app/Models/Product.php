<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'buy_price',
        'price',
        'stock',
        'initial_stock',
        'category_id',
        'merk',
        'warna',
        'ukuran',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\StockTransaction::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'product_id',
        'supplier_id',
        'qty',
        'date',
        'note',
        'status'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StockOut;
use App\Models\Product;
use Illuminate\Http\Request;

class StockOut extends Model
{
    protected $fillable = [
        'product_id',
        'qty',
        'date',
        'note',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

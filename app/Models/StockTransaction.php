<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',           // Siapa yang membuat transaksi
        'type',              // 'in' atau 'out'
        'quantity',
        'description',
        'status',            // pending, approved, rejected
        'confirmed_by',      // Siapa yang mengkonfirmasi
        'confirmed_at',      // Waktu dikonfirmasi
        'notes',             // Catatan (misal alasan ditolak)
    ];

    protected $casts = [
        'created_at'    => 'datetime',
        'confirmed_at'  => 'datetime',
        'quantity'      => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Helper
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
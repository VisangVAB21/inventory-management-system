<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'app_logo',
        'app_favicon',
        'app_description',
        'email',
        'phone',
        'address',
        'facebook',
        'instagram',
        'whatsapp',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    // Helper untuk mengambil setting
    public static function get($key, $default = null)
    {
        $setting = self::first();
        return $setting?->{$key} ?? $default;
    }
}
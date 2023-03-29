<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat',
        'product',
        'price',
        'sale'
    ];

    // Allows us to forego created_at, updated_at timestamps in DB
    public $timestamps = false;
}

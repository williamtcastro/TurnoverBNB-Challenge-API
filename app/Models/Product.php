<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity'
    ];

    protected $casts = [
        'name' => 'string',
        'price' => 'float',
        'quantity' => 'integer'
    ];
}

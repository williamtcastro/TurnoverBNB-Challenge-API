<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'quantity' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}

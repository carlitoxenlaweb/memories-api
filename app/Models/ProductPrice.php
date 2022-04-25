<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'product_id',
        'min',
        'max',
        'priority'
    ];

    protected $casts = [
        'price' => 'float',
        'min' => 'integer',
        'max' => 'integer',
        'priority' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'product_id',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

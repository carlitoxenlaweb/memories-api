<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFinish extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'specs',
        'size',
        'paper',
        'category_id',
        'quantity',
        'promotion'
    ];
    
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function finishes()
    {
        return $this->hasMany(ProductFinish::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
    public function order()
    {
        return $this->hasMany(Orders::class);
    }
    
    public function promotion()
    {
        return $this->hasOne(Promotion::class);
    }
}

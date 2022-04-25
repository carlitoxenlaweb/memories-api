<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdersImages extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'image_name',
        'image_path'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

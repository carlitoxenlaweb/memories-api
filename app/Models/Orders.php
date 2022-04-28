<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'paper',
        'finish_id',
        'border',
        'format',
        'total_price',
        'total_photos',
        'status',
        'paid',
        'extras',
        'client_id',
        'stripe_reference',
        'client_card_id'
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function finish()
    {
        return $this->belongsTo(Finish::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function client_card()
    {
        return $this->belongsTo(ClientCards::class);
    }

    public function images()
    {
        return $this->hasMany(OrdersImages::class);
    }
}

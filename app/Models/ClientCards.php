<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCards extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'card_number',
        'card_expiry',
        'cvv'
    ];
    
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

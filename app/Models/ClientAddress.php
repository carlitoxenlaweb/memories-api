<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'address',
        'country',
        'city',
        'zip',
        'mobile'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

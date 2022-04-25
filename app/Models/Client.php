<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email'
    ];
    
    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
    
    public function addresses()
    {
        return $this->hasMany(ClientAddress::class);
    }
    
    public function cards()
    {
        return $this->hasMany(ClientCards::class);
    }
}
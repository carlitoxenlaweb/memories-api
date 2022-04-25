<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Finish extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name'];

    public function order()
    {
        return $this->hasMany(Orders::class);
    }
}

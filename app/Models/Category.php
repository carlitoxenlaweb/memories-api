<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'size_on_screen',
        'parent_id'
    ];
    
    public function parent_category()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }
}

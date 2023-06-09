<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
    ];
    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function productCategories()
    {
        return $this->hasMany(Product::class);
    }
}
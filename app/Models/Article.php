<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // protected $with = ['shop', 'category', 'image'];

    // public function shop() {
    //     return $this->belongsTo(Shop::class);
    // }
    // public function category() {
    //     return $this->hasMany(Category::class);
    // }
    // public function image() {
    //     return $this->hasMany(Image::class);
    // }
}

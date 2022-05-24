<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $with = ['shop'];

    public function Shop() {
        return $this->belongsTo(Shop::class);
    }

    public function Article() {
        return $this->hasMany(Article::class);
    }
}

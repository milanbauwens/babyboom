<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $with = ['shop'];

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function article() {
        return $this->hasMany(Article::class);
    }
}

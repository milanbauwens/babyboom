<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public function Articles()
    {
        return $this->hasMany(Article::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleWishlist extends Model
{
    use HasFactory;

    public function Wishlist() {
        return $this->hasOne(Wishlist::class);
    }

    public function Article() {
        return $this->hasOne(Article::class);
    }

    public function Guest() {
        return $this->hasOne(Guest::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function Wishlist()
    {
        return $this->belongsToMany(Wishlist::class);
    }

    public function Image() {
        return $this->hasOne(Image::class);
    }

    public function Shop() {
        return $this->belongsTo(Shop::class);
    }

    public function Category() {
        return $this->belongsTo(Category::class);
    }

    public function Favorites() {
        return $this->belongsTo(Favorite::class);
    }

    public function ArticleWishlists() {
        return $this->belongsToMany(ArticleWishlist::class);
    }
}

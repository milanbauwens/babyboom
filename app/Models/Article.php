<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function wishlists()
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
        return $this->hasOne(Category::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ArticleWishlist;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ArticleWishlistController extends Controller
{
    public function add($article_id,){
        $user = auth()->user();
        $wishlists = Wishlist::where('user_id', $user->id)->get();

        return view('pages.wishlists.wishlists-choose', compact('wishlists'), compact('article_id'));
    }

    public function store(Request $r){

        $r->validate([
            'wishlists' => 'array|required'
        ]);
        // $wishlistArticleEntity = new ArticleWishlist();
        // $wishlistArticleEntity->wishlist_id = $wishlist_id;
        // $wishlistArticleEntity->article_id = $article_id;
        // $wishlistArticleEntity->save();
    }
}

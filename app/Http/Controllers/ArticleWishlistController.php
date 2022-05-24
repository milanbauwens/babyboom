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
            'wishlists' => 'array|required',
            'article_id' => 'required'
        ]);

        foreach ($r->wishlists as $wishlist) {

            $checkifExists = ArticleWishlist::where('article_id', $r->article_id)
            ->where('wishlist_id', $wishlist)
            ->first();

            if($checkifExists) {
                return redirect()->route('wishlists.addProduct', ['article_id' => $r->article_id])->with('error', 'Product already in one of the wishlists!');
            } else {
                $wishlistArticleEntity = new ArticleWishlist();
                $wishlistArticleEntity->wishlist_id = $wishlist;
                $wishlistArticleEntity->article_id = $r->article_id;
                $wishlistArticleEntity->save();
            }
        }
        return redirect()->route('products.detail', ['id' => $r->article_id])->with('status', 'Product added to wishlist!');
    }

    public function showWishlistDetail($wishlist_id){
        //get wishlists by id from current user
        $wishlist = Wishlist::where('id', $wishlist_id)->first();

        $articles = ArticleWishlist::where('wishlist_id', $wishlist_id)
        ->join('articles', 'article_wishlists.article_id', '=', 'articles.id')
        ->join('images', 'images.article_id', '=', 'articles.id')
        ->join('shops', 'shops.id', '=', 'articles.shop_id')
        ->get();

        return view('pages.wishlists.detail', compact('wishlist'), compact('articles'));
    }

    public function delete($id){
        dd($id);
    }
}

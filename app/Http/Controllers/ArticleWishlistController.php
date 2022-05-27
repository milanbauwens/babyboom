<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleWishlist;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return redirect()->route('wishlists.add-product', ['article_id' => $r->article_id])->with('error', 'Product already in one of the wishlists!');
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

        $wishlistItems = ArticleWishlist::where('wishlist_id', $wishlist_id)->pluck('article_id')->toArray();
        $articles = Article::whereIn('id', $wishlistItems)->get();

        return view('pages.wishlists.detail', compact('wishlist'), compact('articles'));
    }

    public function deleteProductFromWishlist($id){
        $url = explode('/', url()->previous());
        $wishlist_id = end($url);
        $articlewishlist = ArticleWishlist::where('article_id', $id)->where('wishlist_id', $wishlist_id)->firstOrFail();

        $articlewishlist->delete();

        return redirect()->back()->with('status', 'Product removed from wishlist');
    }

    public function deleteWishlist($id){
        $articlewishlists = ArticleWishlist::where('wishlist_id', $id)->get();
        foreach ($articlewishlists as $item) {
            $item->delete();
        }

        $wishlist = Wishlist::find($id, 'id');
        $wishlist->delete();


        return redirect()->route('wishlists')->with('status', 'Wishlist was deleted');
    }
}

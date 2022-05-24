<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function show(){
        $user = auth()->user();

        $articles = Favorite::where('user_id', $user->id)
        ->join('articles', 'articles.id', '=', 'favorites.article_id')
        ->join('images', 'images.article_id', '=', 'favorites.article_id')
        ->join('shops', 'shops.id', '=', 'articles.shop_id')
        ->get();

        return view('pages.favorites', compact('articles'));
    }

    public function add($article_id){
        $user = auth()->user();

        $checkifExists = Favorite::where('article_id', $article_id)
                ->where('user_id', $user->id)
                ->first();

        if($checkifExists) {
            return redirect()->route('products.detail', ['id' => $article_id])->with('error', 'Product already in favorites!');
        } else {
            $favoriteEntity = new Favorite();
            $favoriteEntity->article_id = $article_id;
            $favoriteEntity->user_id = $user->id;
            $favoriteEntity->save();

            return redirect()->route('products.detail', ['id' => $article_id])->with('status', 'Product added to favorites!');
        }
    }

    public function delete($article_id, $favorite_id){
        $favorite = Favorite::find($favorite_id, 'id')->first();

        $favorite->delete();

        return redirect()->route('products.detail', ['id' => $article_id])->with('status', 'Product removed from favorites!');
    }
}

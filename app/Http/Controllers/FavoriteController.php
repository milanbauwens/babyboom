<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function show(){
        $userFavs = Favorite::where('user_id', Auth::user()->id)->pluck('article_id')->toArray();
        $articles = Article::whereIn('id', $userFavs)->get();

        return view('pages.favorites', compact('articles'));
    }

    public function add($article_id){
        $user = auth()->user();

        $checkifExists = Favorite::where('article_id', $article_id)
                ->where('user_id', $user->id)
                ->first();

        if($checkifExists) {
            return redirect()->route('products.detail', ['id' => $article_id])->with('error', ucfirst(__('product already in favorites!')));
        } else {
            $favoriteEntity = new Favorite();
            $favoriteEntity->article_id = $article_id;
            $favoriteEntity->user_id = $user->id;
            $favoriteEntity->save();

            return redirect()->route('products.detail', ['id' => $article_id])->with('status', ucfirst(__('product added to favorites!')));
        }
    }

    public function delete($article_id, $favorite_id){
        $favorite = Favorite::find($favorite_id, 'id')->first();

        $favorite->delete();

        return redirect()->route('products.detail', ['id' => $article_id])->with('status', ucfirst(__('product removed from favorites!')));
    }
}

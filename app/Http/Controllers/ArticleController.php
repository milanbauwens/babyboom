<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(){
        $articles = Article::inRandomOrder()
                            ->join('images', 'images.article_id', '=', 'articles.id')
                            ->join('shops', 'shops.id', '=', 'articles.shop_id')
                            ->paginate(30);

        return view('pages.products', [
            'articles' => $articles,
        ]);
    }
}

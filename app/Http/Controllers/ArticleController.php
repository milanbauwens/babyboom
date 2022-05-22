<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;

class ArticleController extends Controller{
    public function show(){
        $articles = Article::inRandomOrder()
                            ->join('images', 'images.article_id', '=', 'articles.id')
                            ->join('shops', 'shops.id', '=', 'articles.shop_id')
                            ->paginate(30)
                            ->withQueryString();

        return view('pages.products', [
            'articles' => $articles,
        ]);
    }

    public function ArticlesByFilters(Request $r) {
        if(count($r->all()) > 0) {
            $validated = $r->validate([
                'categories' => 'array',
                'minPrice' => '',
                'maxPrice' => '',
                'shops' => 'array',
            ]);

            if($validated['minPrice'] && $validated['maxPrice']) {
                $articles = $this->queryBuilder($validated['minPrice'], $validated['maxPrice'], $validated['shops'], $validated['categories']);
            }

            if($validated['minPrice'] && !$validated['maxPrice']) {
                $articles = $this->queryBuilder($validated['minPrice'], $validated['maxPrice'], $validated['shops'], $validated['categories']);
            }

            if(!$validated['minPrice'] && $validated['maxPrice']) {
                $articles = $this->queryBuilder($validated['minPrice'], $validated['maxPrice'], $validated['shops'], $validated['categories']);
            }

            if(!$validated['minPrice'] && $validated['maxPrice']) {
                $articles = $this->queryBuilder($validated['minPrice'], $validated['maxPrice'], $validated['shops'], $validated['categories']);
            }

            if(!$validated['minPrice'] && !$validated['maxPrice']) {
                return redirect()->route('products');
            }

            return view('pages.products', [
                'articles' => $articles
            ]);
        } else {
             // Initial data to show filters
            $categoryData = Category::distinct('name')->get();
            $unfilteredCategories = collect($categoryData);
            $categories = $unfilteredCategories->unique('name');
            $categories->all();
            $shops = Shop::all();
            $minPrice = Article::orderBy('price', 'ASC')->first();
            $maxPrice = Article::orderBy('price', 'DESC')->first();


            return view('pages.filter', [
                'categories' => $categories,
                'shops' => $shops,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
            ]);
        }
    }

    private function queryBuilder($minPrice = 0, $maxPrice = 1000, $shops = false, $categories = false){
        if($shops){
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->whereIn('shops.name', array_keys($shops))
            ->join('images', 'images.article_id', '=', 'articles.id')
            ->join('shops', 'shops.id', '=', 'articles.shop_id')
            ->paginate(30)
            ->withQueryString();
        } elseif($categories) {
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->whereIn('categories.name', array_keys($categories))
            ->join('images', 'images.article_id', '=', 'articles.id')
            ->join('shops', 'shops.id', '=', 'articles.shop_id')
            ->paginate(30)
            ->withQueryString();
        } elseif($shops && $categories) {
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->whereIn('shops.name', array_keys($shops))
            ->whereIn('categories.name', array_keys($categories))
            ->join('images', 'images.article_id', '=', 'articles.id')
            ->join('shops', 'shops.id', '=', 'articles.shop_id')
            ->paginate(30)
            ->withQueryString();
        } elseif (!$shops && !$categories) {
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->join('images', 'images.article_id', '=', 'articles.id')
            ->join('shops', 'shops.id', '=', 'articles.shop_id')
            ->paginate(30)
            ->withQueryString();
        }
        return $articles;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Shop;
use Illuminate\Http\Request;

class ArticleController extends Controller{
    public function show(){
        $articles = Article::orderBy('id', 'asc')
                            ->paginate(30)
                            ->withQueryString();

        return view('pages.products.products', [
            'articles' => $articles,
        ]);
    }

    public function showProductDetail($id){
        $user=auth()->user();

        $article = Article::where('id', $id)->firstOrFail();


        $favorite = Favorite::where([
            ['article_id', $article->id],
            ['user_id', $user->id],
            ])->first();

        return view('pages.products.detail', [
            'article' => $article,
            'favorite' => $favorite
        ]);
    }

    public function articlesByShop($shop){
        $chosenShop = Shop::where('name', $shop)->first();
        $articles = Article::where('shop_id', $chosenShop->id)
        ->orderBy('id', 'asc')
        ->paginate(30)
        ->withQueryString();

        return view('pages.products.products', [
            'articles' => $articles,
        ]);
    }

    public function articlesByFilters(Request $r) {
        if(count($r->all()) > 0) {
            $r->validate([
                'categories' => 'array',
                'minPrice' => '',
                'maxPrice' => '',
                'shops' => 'array',
            ]);

            if($r->minPrice && $r->maxPrice) {
                $articles = $this->queryBuilder($r->minPrice, $r->maxPrice, $r->shops, $r->categories);
            }

            if($r->minPrice && !$r->maxPrice) {
                $articles = $this->queryBuilder($r->minPrice, $r->maxPrice, $r->shops, $r->categories);
            }

            if(!$r->minPrice && $r->maxPrice) {
                $articles = $this->queryBuilder($r->minPrice, $r->maxPrice, $r->shops, $r->categories);
            }

            if(!$r->minPrice && $r->maxPrice) {
                $articles = $this->queryBuilder($r->minPrice, $r->maxPrice, $r->shops, $r->categories);
            }

            if(!$r->minPrice && !$r->maxPrice) {
                if($r->shops || $r->categories){
                    $articles = $this->queryBuilder($r->minPrice, $r->maxPrice, $r->shops, $r->categories);
                }
                else {
                    return redirect()->route('products');
                }
            }

            return view('pages.products.products', [
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


            return view('pages.products.filter', [
                'categories' => $categories,
                'shops' => $shops,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
            ]);
        }
    }

    // public function search(Request $request){
    //     // Get the search value from the request
    //     $search = $request->input('search');

    //     // Search in the title and body columns from the posts table
    //     $posts = Article::query()
    //         ->where('title', 'LIKE', "%{$search}%")
    //         ->orWhere('body', 'LIKE', "%{$search}%")
    //         ->get();

    //     // Return the search view with the resluts compacted
    //     return view('search', compact('posts'));
    // }

    private function queryBuilder($minPrice = 0, $maxPrice = 1000, $shops, $categories){
        if($shops){
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->whereIn('shops.name', array_keys($shops))
            ->paginate(30)
            ->withQueryString();
        } elseif($categories) {
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->whereIn('categories.name', array_keys($categories))
            ->paginate(30)
            ->withQueryString();
        } elseif($shops && $categories) {
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->whereIn('shops.name', array_keys($shops))
            ->whereIn('categories.name', array_keys($categories))

            ->paginate(30)
            ->withQueryString();
        } elseif (!$shops && !$categories) {
            $articles = Article::whereBetween('price', [$minPrice, $maxPrice])
            ->paginate(30)
            ->withQueryString();
        }
        return $articles;
    }
}

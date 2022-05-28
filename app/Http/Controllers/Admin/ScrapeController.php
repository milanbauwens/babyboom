<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleWishlist;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Shop;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;

set_time_limit(3600);

class ScrapeController extends Controller
{

    public function showDashboard(){
        return view('admin.dashboard');
    }

    public function deleteProduct(Request $r){
        $article = Article::findOrFail($r->article_id);
        $articleWishlist = ArticleWishlist::where('article_id', $r->article_id)->get();

        if($articleWishlist){
            foreach ($articleWishlist as $item) {
               $item->delete();
            }
        }

        $article->Image->delete();
        if($article->Favorites) $article->Favorites->delete();
        $article->delete();

        return redirect()->back()->with('status', 'Product was deleted from database');
    }

    public function showProducts(){
        $articles = Article::orderBy('id', 'asc')
        ->paginate(30)
        ->withQueryString();

        return view('admin.products', [
        'articles' => $articles,
        ]);
    }

    public function show() {
        $shops = [
            'maymays' => 'May Mays',
            'mimibaby' => 'Mimi baby',
            'bollebuik' => 'Bollebuik'
        ];
        $mimibabyCategories = [];
        $maymaysCategories = [];
        $bollebuikCategories = [];


        $maymaysShop = Shop::where('name', 'May Mays')->first();
        if($maymaysShop) $maymaysCategories = Category::where('shop_id', $maymaysShop->id)->get();


        $mimibabyShop= Shop::where('name', 'Mimi Baby')->first();
        if($mimibabyShop) $mimibabyCategories = Category::where('shop_id', $mimibabyShop->id)->get();

        $bollebuikShop= Shop::where('name', 'Bollebuik')->first();
        if($bollebuikShop) $bollebuikCategories = Category::where('shop_id', $bollebuikShop->id)->get();


        return view('admin.scrape-form',[
            "shops" => $shops,
            "maymaysCategories" => $maymaysCategories,
            "mimibabyCategories" => $mimibabyCategories,
            'bollebuikCategories' => $bollebuikCategories
        ]);
    }

     /**
     * Scrape categories
     */

    public function scrapeCategories(Request $r) {
        switch($r->shop) {
            case 'bollebuik' :
                $shop = Shop::where('name', 'Bollebuik')->first();
                if($shop) {
                    $this->scrapeBollebuikCategories($r->url, $shop->id);
                 } else {
                    $shopEntity = new Shop();
                    $shopEntity->name = 'Bollebuik';
                    $shopEntity->url = $r->url;
                    $shopEntity->save();
                    $this->scrapeBollebuikCategories($r->url, $shopEntity->id);
                }
                return redirect()->route('scrape');
                break;
            case 'mimibaby' :
                $shop = Shop::where('name', 'Mimi Baby')->first();

                if($shop) {
                        $this->scrapeMimibabyCategories($r->url, $shop->id);
                    } else {
                        $shopEntity = new Shop();
                        $shopEntity->name = 'Mimi Baby';
                        $shopEntity->url = $r->url;
                        $shopEntity->save();
                        $this->scrapeMimibabyCategories($r->url, $shopEntity->id);
                    }
                return redirect()->route('scrape');
                break;
            case 'maymays' :
                $shop = Shop::where('name', 'May Mays')->first();

                if($shop) {  $this->scrapeMaymaysCategories($r->url, $shop->id); }
                else {
                    $shopEntity = new Shop();
                    $shopEntity->name = 'May Mays';
                    $shopEntity->url = 'https://www.maymays.nl/';
                    $shopEntity->save();
                    $this->scrapeMaymaysCategories($r->url, $shopEntity->id);
                };
                return redirect()->route('scrape');
                break;
        }
    }

    private function scrapeMaymaysCategories($url, $shop_id) {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.product-category a')
            ->each(function($node) {
                $name = $node->filter('.header-title')->text();
                $url = $node->attr('href');

                $cat = new stdClass();
                $cat->name = $name;
                $cat->url = $url;
                return $cat;
            });

        foreach ($categories as $scrapeCategoy) {
            //  check if exists
            $exists = Category::where('url', $scrapeCategoy->url)->count();
            if ($exists > 0) continue;

            // create/add category to database
            $categoryEntity = new Category();
            $categoryEntity->name = $scrapeCategoy->name;
            $categoryEntity->url = $scrapeCategoy->url;
            $categoryEntity->shop_id = $shop_id;
            $categoryEntity->save();
        }
    }

    private function scrapeMimibabyCategories($url, $shop_id) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $categories = $crawler->filter('.main-navigation-menu a')
            ->each(function($node) {
                $cat = new stdClass();
                $node;
                if($node->attr('title') === 'Merken') {
                    return;
                } else {
                    $cat->name = $node->attr('title');
                }
                if($node->attr('href') === '/nl/merken') {
                    return;
                } else {
                    $cat->url = $node->attr('href');
                }
                return $cat;
            });

        foreach ($categories as $scrapeCategory) {
            if(!$scrapeCategory) {
                return;
            } else {
                // Checking if the category is already in the database
                $exists = Category::where('url', $scrapeCategory->url)->count();
                if($exists > 0) continue;

                // Adding the category to the database
                $categoryEntity = new Category();
                $categoryEntity->name = $scrapeCategory->name;
                $categoryEntity->url = $scrapeCategory->url;
                $categoryEntity->shop_id = $shop_id;
                $categoryEntity->save();
            }
        }
    }


    private function scrapeBollebuikCategories($url, $shop_id) {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.nav-primary li .has-children')
                                ->each(function(Crawler $node){
                                    // Get data from crawler
                                    $url = $node->attr('href');
                                    $title = $node->text();

                                    // Create new object which holds all the data
                                    $cat = new stdClass();
                                    $cat->name = $title;
                                    $cat->url = $url;

                                    return $cat;
                                });

        foreach ($categories as $scrapeCategory) {
            // Checking if the category is already in the database
            $exists = Category::where('url', $scrapeCategory->url)->count();
            if($exists > 0) continue;

            // Adding the category to the database
            if($scrapeCategory->name === 'Outlet') {
                continue;
            } else {
                $categoryEntity = new Category();
                $categoryEntity->name = $scrapeCategory->name;
                $categoryEntity->url = $scrapeCategory->url;
                $categoryEntity->shop_id = $shop_id;
                $categoryEntity->save();
            }
        }
    }

    /**
     * Scrape articles
     */

    public function scrapeArticles(Request $r) {
        switch($r->shop) {
            case 'bollebuik' :
                return $this->scrapeBollebuikArticles($r->url);
                break;
            case 'mimibaby' :
                return $this->scrapeMimibabyArticles($r->url);
                break;
            case 'maymays' :
                return $this->scrapeMaymaysArticles($r->url);
                break;
        }

        $maymaysArticles = [];
        $mimibabyArticles = [];

        $maymaysShop = Shop::where('name', 'May Mays')->first();
        if($maymaysShop) $maymaysArticles = Article::where('shop_id', $maymaysShop->id)->get();


        $mimibabyShop= Shop::where('name', 'Mimi Baby')->first();
        if($mimibabyShop) $mimibabyArticles = Article::where('shop_id', $mimibabyShop->id)->get();

        return view('admin.scrape-results', [
            'maymaysArticles' => $maymaysArticles,
            'mimibabyArticles' => $mimibabyArticles
        ]);
    }

    private function scrapeMaymaysArticles($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $articles = $this->scrapeMaymaysPageData($crawler);

        for ($i=0; $i <= 5; $i++) {
            $crawler = $this->getNextMaymaysPage($crawler);
            if(!$crawler) break;
            $articles = array_merge($articles, $this->scrapeMaymaysPageData($crawler));
        }

        $this->storeMaymaysArticles($articles, $url);
    }

    private function scrapeBollebuikArticles($url) {
        $client = new Client();
        $arrayArticles = [];

        for ($i=1; $i <= 250; $i++) {
            $crawler = $client->request('GET', $url . '?p=' . $i);
            if(!$crawler) break;
            $this->scrapeBollebuikPageData($crawler);
            $arrayArticles = array_merge($arrayArticles, $this->scrapeBollebuikPageData($crawler));
            $unfilteredArticles = collect($arrayArticles);
            $articles = $unfilteredArticles->unique('identifier');
            $articles->all();
        }

        $this->storeBollebuikArticles($articles, $url);
    }

    public function scrapeMimibabyArticles($url) {
        $client = new Client();
        $arrayArticles = [];

        for ($i=1; $i <= 50; $i++) {
            $crawler = $client->request('GET', $url . '?order=name-asc&p=' . $i);
            if(!$crawler) break;
            $arrayArticles = array_merge($arrayArticles, $this->scrapeMimibabyPagedata($crawler));
            $unfilteredArticles = collect($arrayArticles);
            $articles = $unfilteredArticles->unique('id');
            $articles->all();
        }

        $this->storeMimibabyArticles($articles, $url);
    }

    private function scrapeMaymaysPageData($crawler) {
        $articles = $crawler->filter('.product')
            ->each(function($node) {

                $image = $node->filter('noscript')->first()->filter('img')->attr('src');
                $id = $node->filter('.gtm4wp_productdata')->attr('data-gtm4wp_product_id');
                $name = $node->filter('.gtm4wp_productdata')->attr('data-gtm4wp_product_name');
                $price = $node->filter('.gtm4wp_productdata')->attr('data-gtm4wp_product_price');
                $url = $node->filter('.gtm4wp_productdata')->attr('data-gtm4wp_product_url');

                $client = new Client();
                $urlCrawler = $client->request('GET', $url);
                $description = $urlCrawler->filter('.product-short-description')->text();

                $article = new stdClass();
                $article->id = $id;
                $article->name = $name;
                $article->image = $image;
                $article->price = (float)$price;
                $article->url = $url;
                $article->description = $description;

                return $article;
            });

        return $articles;
    }

    private function scrapeMimibabyPagedata($crawler) {
        $articles = $crawler->filter('.product-box .card-body')
            ->each(function($node) {
                $art = new stdClass();
                $art->title = $node->filter('.product-info .product-name')->text();
                $priceStringed = ltrim($node->filter('.product-info .product-price-info .product-price')->text(), '€');
                $pricebugged = str_replace(',', '.', $priceStringed);
                $price = preg_replace('/\s+/u', '', $pricebugged);
                $euro = (float)$price;
                $art->price = $euro;
                $url = $node->filter('.product-info .product-name')->attr('href');
                $art->url = $url;
                $art->image = $node->filter('.product-image-wrapper .product-image-link img')->first()->attr('src');
                $art->description = $this->getDescriptionMimibaby($art->url);

                $segments = explode('/', parse_url($url, PHP_URL_PATH));
                $unique = explode('-', $segments[2]);
                $identifier = end($unique);
                $art->identifier = $identifier;
                return $art;
            });

        return $articles;
    }

    public function scrapeBollebuikPagedata($crawler) {
        $articles = $crawler->filter('.products-grid .item')
                            ->each(function($node) {
                                $art = new stdClass();
                                if($node->filter('.inner-wrap h3 a')->count() > 0) {
                                    $art->title = $node->filter('.inner-wrap h3 a')->attr('title');
                                    $art->url = $node->filter('.inner-wrap h3 a')->attr('href');
                                    $details = $this->getDetailsBollebuik($art->url);
                                    $art->description = $details->description;
                                    $art->image = $details->img;
                                    $art->identifier = $details->identifier;
                                }


                                $priceStringed = ltrim($node->filter('.price-box .price')->first()->text(), '€ ');
                                $pricebugged = str_replace(',', '.', $priceStringed);
                                $price = preg_replace('/\s+/u', '', $pricebugged);
                                $euro = (float)$price;
                                $art->price = $euro;

                                return $art;
                            });
        return $articles;
    }

    private function getNextMaymaysPage($crawler) {
        $linkTag = $crawler->filter('.page-number.next')->first();
        if($linkTag->count() <= 0) return;
        $link = $linkTag->link();
        if(!$link) return;

        $client = new Client();
        $nextCrawler = $client->click($link);

        return $nextCrawler;
    }

    public function getDetailsBollebuik($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        if($crawler->filter('.product-image-gallery img')->first()->count() > 0) {
            $detailImage = $crawler->filter('.product-image-gallery img')->first()->attr('src');
        }
        if($crawler->filter('.details-open-close .slide')->first()->count() > 0) {
            $detailDescription = $crawler->filter('.details-open-close .slide')->first()->text();
        }

        if($crawler->filter('.product-code')->count() > 0)
        {
            $detailIndentifier = ltrim($crawler->filter('.product-code')->text(), 'Art.nr. ');
        }

        $contains = Str::contains($detailDescription, ['Schrijf', 'review']);

        $details = new stdClass();
        if($contains)  {
            $details->description = '';
        } else {
            $details->description = $detailDescription;
        }
        $details->img = $detailImage;
        $details->identifier = $detailIndentifier;

        return $details;
    }

    public function getDescriptionMimibaby($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $description = $crawler->filter('.product-detail-tabs-content .product-detail-description-text');
        if ($description->count() <= 0) return null;
        $description = $crawler->filter('.product-detail-tabs-content .product-detail-description-text')->text();
        return $description;
    }


    /**
     * Store articles
     */

    private function storeMaymaysArticles($articles, $url) {
        $category = Category::where('url', $url)->firstOrFail();
        $fileSystem = Storage::disk('public');


        foreach ($articles as $article) {
            // Check if article already exists
            $exists = Article::where('identifier', $article->identifier)->first();

            if($exists === null) {
                $articleEntity = new Article();
                $articleEntity->name = $article->name;
                $articleEntity->url = $article->url;
                $articleEntity->price = $article->price;
                $articleEntity->description = $article->description;
                $articleEntity->identifier = $article->id;
                $articleEntity->category_id = $category->id;
                $articleEntity->shop_id = $category->shop_id;
                $articleEntity->save();

                $randomName = date('d') . '-' . Str::random(10) . '.jpg';
                $path = 'products/images/maymays/';
                $fullPath = $path . $randomName;

                $fileSystem->putFileAs($path, $article->image, $randomName);


                $image = new Image();
                $image->path = $fullPath;
                $image->alt = $article->name;
                $image->article_id = $articleEntity->id;
                $image->save();
            }
        }
    }

    private function storeMimibabyArticles($articles, $url) {
        $category = Category::where('url', $url)->firstOrFail();
        $fileSystem = Storage::disk('public');

        foreach ($articles as $article) {
            // Check if article already exists
            $exists = Article::where('identifier', $article->identifier)->first();

            if($exists === null) {
                $articleEntity = new Article();
                $articleEntity->name = $article->title;
                $articleEntity->url = $article->url;
                $articleEntity->price = $article->price;
                if(!$article->description) {
                    $articleEntity->description = '';
                } else {
                    $articleEntity->description = $article->description;
                }

                $articleEntity->identifier = $article->identifier;

                $articleEntity->category_id = $category->id;
                $articleEntity->shop_id = $category->shop_id;
                $articleEntity->save();

                $randomName = date('d') . '-' . Str::random(10) . '.jpg';
                $path = 'products/images/mimibaby/';
                $fullPath = $path . $randomName;

                $fileSystem->putFileAs($path, $article->image, $randomName);

                $image = new Image();
                $image->path = $fullPath;
                $image->alt = $article->title;
                $image->article_id = $articleEntity->id;
                $image->save();
            }
        }
    }

    private function storeBollebuikArticles($articles, $url) {
        $category = Category::where('url', $url)->firstOrFail();
        $fileSystem = Storage::disk('public');


        foreach ($articles as $article) {
            // Check if article already exists
            $exists = Article::where('identifier', $article->identifier)->first();

            if($exists === null) {
                $articleEntity = new Article();
                $articleEntity->name = $article->title;
                $articleEntity->url = $article->url;
                $articleEntity->price = $article->price;
                $articleEntity->description = $article->description;
                $articleEntity->identifier = $article->identifier;
                $articleEntity->category_id = $category->id;
                $articleEntity->shop_id = $category->shop_id;
                $articleEntity->save();

                $randomName = date('d') . '-' . Str::random(10) . '.jpg';
                $path = 'products/images/bollebuik/';
                $fullPath = $path . $randomName;

                $fileSystem->putFileAs($path, $article->image, $randomName);


                $image = new Image();
                $image->path = $fullPath;
                $image->alt = $article->title;
                $image->article_id = $articleEntity->id;
                $image->save();
            }
        }
    }

}

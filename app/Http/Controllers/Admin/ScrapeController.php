<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Shop;
use DOMNamedNodeMap;
use Goutte\Client;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeController extends Controller
{
    public function show() {
        $shops = [
            'ikea' => 'Ikea',
            'fun' => 'Fun',
            'dreambaby' => 'Dream Baby'
        ];

        $categories = Category::all();

        return view('admin.scrape-form', compact('shops'), compact('categories'));
    }

     /**
     * Scrape categories
     */

    public function scrapeCategories(Request $r) {
        switch($r->shop) {
            // case 'dreambaby' :
            //     $this->scrapeDreambabyCategories($r->url);
            //     break;
            // case 'fun' :
            //     $this->scrapeFunCategories($r->url);
            //     break;
            case 'ikea' :
                $shop = Shop::find('Ikea', 'name');

                if($shop) { $shop->truncate(); } else {
                    $shopEntity = new Shop();
                    $shopEntity->name = 'Ikea';
                    $shopEntity->url = 'https://www.ikea.com/be/nl/?ref=gwp-start';
                    $shopEntity->save();
                };
                $this->scrapeIkeaCategories($r->url, $shopEntity->id);
                return redirect()->route('scrape');
                break;
        }
    }

    // private function createIkeaShop(){
    //     $shop = Shop::where('name', 'Ikea')->firstOrFail();

    //     if($shop) $shop->delete();

    //     $shopEntity = new Shop();
    //     $shopEntity->name = 'Ikea';
    //     $shopEntity->url = 'https://www.ikea.com/be/nl/?ref=gwp-start';
    //     $shopEntity->save();
    // }

    // private function scrapeDreambabyCategories($url) {
    //     $client = new Client();
    //     $crawler = $client->request('GET', $url);

    //     $categories = $crawler  ->filter('#categoryFacetList_1_3074457345618260656_4099276460824427707 li a')
    //                             ->each(function(Crawler $parentcrawler ) {
    //                                 // Get data from crawler
    //                                 $url = $parentcrawler->attr('href');
    //                                 $title = $parentcrawler->filter('.facetName')->text();

    //                                 // Create new object which holds all the data
    //                                 $cat = new stdClass();
    //                                 $cat->title = $title;
    //                                 $cat->url = $url;

    //                                 return $cat;
    //                             });

    //     foreach ($categories as $scrapeCategory) {
    //         // Checking if the category is already in the database
    //         $exists = Category::where('url', $scrapeCategory->url)->count();
    //         if($exists > 0) continue;

    //         // Adding the category to the database
    //         $categoryEntity = new Category();
    //         $categoryEntity->title = $scrapeCategory->title;
    //         $categoryEntity->url = $scrapeCategory->url;
    //         $categoryEntity->save();
    //     }
    // }

    // private function scrapeFunCategories($url) {
    //     $client = new Client();
    //     $crawler = $client->request('GET', $url);

    //     $categories = $crawler->filter('.children-category-container .swiper-wrapper a')
    //                         ->each(function(Crawler $parentcrawler){
    //                             // Get data from crawler
    //                             $url = $parentcrawler->attr('href');
    //                             $title = $parentcrawler->filter('.category-item-label .category-item-title')->text();

    //                             // Create new object which holds all the data
    //                             $cat = new stdClass();
    //                             $cat->title = $title;
    //                             $cat->url = $url;

    //                             return $cat;
    //                         });
    //     foreach ($categories as $scrapeCategory) {
    //         // Checking if the category is already in the database
    //         $exists = Category::where('url', $scrapeCategory->url)->count();
    //         if($exists > 0) continue;

    //         // Adding the category to the database
    //         $categoryEntity = new Category();
    //         $categoryEntity->title = $scrapeCategory->title;
    //         $categoryEntity->url = $scrapeCategory->url;
    //         $categoryEntity->save();
    //     }
    // }

    private function scrapeIkeaCategories($url, $shop_id) {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('.vn__nav a')
                                ->each(function(Crawler $parentcrawler){
                                    // Get data from crawler
                                    $url = $parentcrawler->attr('href');
                                    $title = $parentcrawler->text();

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
        $categoryEntity = new Category();
        $categoryEntity->name = $scrapeCategory->name;
        $categoryEntity->url = $scrapeCategory->url;
        $categoryEntity->shop_id = $shop_id;
        $categoryEntity->save();
        }
    }

    /**
     * Scrape articles
     */

    public function scrapeArticles(Request $r) {
        switch($r->shop) {
            // case 'dreambaby' :
            //     return $this->scrapeDreambabyArticles($r->url);
            //     break;
            // case 'fun' :
            //     return $this->scrapeFunArticles($r->url);
            //     break;
            case 'ikea' :
                return $this->scrapeIkeaArticles($r->url);
                break;
        }
    }

    private function scrapeIkeaArticles($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $data = $this->scrapeIkeaPageDate($crawler);


        for($i = 0; $i <= 20; $i++) {
            $crawler = $this->getNextIkeaPage($crawler);
            if(!$crawler) break;
            $arrayArticles = array_merge($data, $this->scrapeIkeaPageDate($crawler));
            $unfilteredArticles = collect($arrayArticles);
            $articles = $unfilteredArticles->unique('identifier');
            $articles->all();
        }

            $unfilteredArticles = collect($data);
            $articles = $unfilteredArticles->unique('identifier');
            $articles->all();

       foreach ($articles as $article) {
           $articleEntity = new Article();
           $articleEntity->name = $article->title;
           $articleEntity->url = $article->url;
           $articleEntity->price = $article->price;
           $articleEntity->description = $article->description;
           $articleEntity->identifier = $article->identifier;

           $category = Category::where('url', $url)->firstOrFail();
           $articleEntity->category_id = $category->id;
           $articleEntity->shop_id = $category->shop_id;
           $articleEntity->save();
       }

        $ikeaArticles = Article::all();

        return view('admin.scrape-results', compact('ikeaArticles'));
    }

    private function scrapeIkeaPageDate($crawler) {
        $articles = $crawler->filter('.pip-product-compact .pip-product-compact__bottom-wrapper a')
                ->each(function(Crawler $parentcrawler) {
                        $article = new stdClass();

                        $euro = $parentcrawler->filter('.pip-price__integer')->text();
                        if($parentcrawler->filter('.pip-compact-price-package__price-wrapper .pip-price__decimals')->count()) {
                            $cent = $parentcrawler->filter('.pip-compact-price-package__price-wrapper .pip-price__decimals')->last()->text();
                        } else {
                            $cent = ",00";
                        }

                        $article->title = $parentcrawler->filter('.pip-header-section__title--small')->text();
                        $article->url = $parentcrawler->attr('href');
                        $article->price = floatval($euro . str_replace(',', '.', $cent));

                        $details = $this->getDetailIkeaData($article->url);

                        $article->img = $details->img;
                        $article->description = $details->desc;
                        $article->identifier = $details->identifier;

                        return $article;
                });

        return $articles;
    }

    private function getNextIkeaPage($crawler){

        if($crawler->filter('link[rel="next"]')->count()) {
            $linkTag = $crawler->filter('link[rel="next"]')->attr('href');
        } else return;

        $client = new Client();
        $nextCrawler = $client->request('GET',$linkTag);

        return $nextCrawler;
    }


    private function getDetailIkeaData($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $details = new stdClass();
            $img = $crawler->filter('.product-pip .pip-aspect-ratio-image__image')->attr('src');
            $description = $crawler->filter('.product-pip .pip-product-summary__description')->text();
            $identifier = $crawler->filter('.pip-product-identifier__value')->text();


        $details->img = $img;
        $details->desc = $description;
        $details->identifier = $identifier;

        return $details;
    }


    // private function scrapeDreambabyArticles($url) {
    //     $client = new Client();
    //     $crawler = $client->request('GET', $url);
    //     $articles = $this->scrapeDreambabyPageDate($crawler);

    //     // for($i = 0; $i <= 10; $i++) {
    //     //     $crawler = $this->getNextDreambabyPage($crawler);
    //     //     if(!$crawler) break;
    //     //     $articles = array_merge($articles, $this->scrapeDreambabyPageDate($crawler));
    //     // }

    //     // dd($articles);


    //     return view('scrape-results', compact('articles'));
    // }

    // private function scrapeDreambabyPageDate($crawler) {
    //     $crawler->filter('.productsCategoriesList .productListingWidget .product_listing_container ul li .product .product_info')
    //             ->each(function(Crawler $parentcrawler) {
    //                     $article = new stdClass();

    //                     $article->title = $parentcrawler->filter('.product_name')->text();
    //                     $article->price = floatval($parentcrawler->filter('.product_price input')->attr('value'));
    //                     $article->image = $parentcrawler->filter('.product_image .image img')->first()->attr('data-src');

    //                     return $article;
    //             });
    // }

    // private function getNextDreambabyPage($crawler){
    //     $linkTag = $crawler->filter('.footer_bar navigation_bar .paging_controls .right_arrow');
    //     // dd($linkTag);
    //     if($linkTag->count() <= 0) return;
    //     $link = $linkTag->link();
    //     $client = new Client();
    //     $nextCrawler = $client->click($link);

    //     return $nextCrawler;
    // }





    // private function getNextFunPage($crawler){
    //     $linkTag = $crawler->filter('.footer_bar navigation_bar .paging_controls .right_arrow');
    //     // dd($linkTag);
    //     if($linkTag->count() <= 0) return;
    //     $link = $linkTag->link();
    //     $client = new Client();
    //     $nextCrawler = $client->click($link);

    //     return $nextCrawler;
    // }

    // private function scrapeFunArticles($url) {
    //     $client = new Client();
    //     $crawler = $client->request('GET', $url);
    //     $articles = $this->scrapeFunPageData($crawler);

    //     // for($i = 0; $i <= 10; $i++) {
    //     //     $crawler = $this->getNextFunPage($crawler);
    //     //     if(!$crawler) break;
    //     //     $articles = array_merge($articles, $this->scrapeFunPageDate($crawler));
    //     // }

    //     return view('scrape-results', compact('articles'));
    // }

    // private function scrapeFunPageData($crawler) {
    //     $crawler->filter('.products .item .product-item-info .product-item-details')
    //     ->each(function(Crawler $parentcrawler) {
    //             $article = new stdClass();

    //             $article->title = $parentcrawler->filter('strong')->text();
    //             $euro = $parentcrawler->filter('.price')->first()->text();
    //             dd($euro);
    //             // $cent = $parentcrawler->filter('.price span sup')->first()->text();
    //             // $article->price = floatval($euro . ',' . $cent);

    //             dump($article);
    //             return $article;
    //     });
    // }






    // private function scrapeBabydumpArticles($url) {

    // }

    // private function scrapeBabydumpPageData($url) {

    // }






}

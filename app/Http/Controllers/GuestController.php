<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleWishlist;
use App\Models\Guest;
use App\Models\Wishlist;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function show( $slug){
        session_start();
        return view('pages.guest.landing', compact('slug'));
    }

    public function getWishlist($slug) {
              //get wishlists by id from current user
        $wishlist = Wishlist::where('slug', $slug)->first();

        $wishlistItems = ArticleWishlist::where('wishlist_id', $wishlist->id)->pluck('article_id')->toArray();
        $articles = Article::whereIn('id', $wishlistItems)->get();

        return view('pages.wishlists.detail', compact('wishlist'), compact('articles'));
    }

    public function addProductToBasket($slug, Request $r){
        $article = Article::findOrFail($r->article_id);
        $guest_id = session()->get('guest_id');

        if(Cart::session($guest_id)->get($r->article_id)) {
            return redirect()->back()->with('error', ucfirst(__('product already in basket!')));
        } else {
            // Fill in guest_id in session
            Cart::session($guest_id)->add(array(
                'id' => $article->id,
                'name' => $article->name,
                'price' => $article->price,
                'quantity' => 1,
                'attributes' => array(),
                'associatedModel' => $article
            ));
            return redirect()->back()->with('status', ucfirst(__('product added to basket!')));
        }
    }

    public function removeItemFromBasket(Request $r, $slug){
        $guest_id = session()->get('guest_id');
        Cart::session($guest_id)->remove($r->article_id);

        return redirect()->back()->with('status', ucfirst(__('item removed from basket!')));
    }

    public function showProductsInBasket($slug){
        $guest_id = session()->get('guest_id');
        $cart = Cart::session($guest_id);
        $items = $cart->getContent();
        $articles = [];

        foreach ($items as $key => $item) {
            $article = Article::findOrFail($item->id);
            array_push($articles, $article);
        }

        return view('pages.guest.basket', [
            'articles' => $articles,
            'cart' => $cart
        ]);
    }

    public function checkPassword(Request $r){
        $wishlist = Wishlist::where('slug', $r->slug)->firstOrFail();

        if($wishlist->password === $r->password) {
            return redirect()->route('guest.register', ['slug' => $r->slug]);
        } else {
            return redirect()->back()->with('error', ucfirst(__('password is incorrect!')));
        }
    }

    public function showRegister($slug) {
        return view('pages.guest.register');
    }

    public function registerGuest(Request $r, $slug){
        // Validate form
        $r->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
        ],[], ['firstname' => ucfirst(__('firstname')), 'lastname' => ucfirst(__('lastname')), 'email' => ucfirst(__('email'))]);

        // Find guest if already exists
        $guest = Guest::where('email', $r->email)->first();;

        if($guest){
            session()->put('guest_id', $guest->id);
            return redirect()->route('guest.wishlist', ['slug' => $slug]);
        } else {
            $guestEntity = new Guest();
            $guestEntity->firstname = $r->firstname;
            $guestEntity->lastname = $r->lastname;
            $guestEntity->email = $r->email;
            $guestEntity->save();
        }

        $guest = Guest::where('email', $r->email)->first();
        session()->put('guest_id', $guest->id);

        return redirect()->route('guest.wishlist', ['slug' => $slug]);
    }

}

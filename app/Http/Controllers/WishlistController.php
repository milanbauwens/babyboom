<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function show(){
        $user = auth()->user();
        $wishlists = Wishlist::where('user_id', $user->id)->get();


        return view('pages.wishlists.wishlists', compact('wishlists'));
    }

    public function newWishlist(){
        $today = Carbon::now()->format('Y-m-d');

        return view('pages.wishlists.wishlists-new',compact('today') );
    }

    public function createWishlist(Request $r){
        $r->validate([
            "name" => "required|max:255",
            "expiration" => "required|date|after_or_equal:today",
            "description" => "string|max:500",
            "password" => "required|min:6|alpha_num",
        ]);

        $user = auth()->user();

        $wishlistEntity = new Wishlist();

        $wishlistEntity->name = $r->name;
        $wishlistEntity->expiration_date = $r->expiration;
        $wishlistEntity->user_id = $user->id;
        $wishlistEntity->password = $r->password;
        $wishlistEntity->description = $r->description;
        $wishlistEntity->slug = '';
        $wishlistEntity->save();

        $wishlist = Wishlist::find($wishlistEntity->id, 'id');
        $wishlist->slug =$r->name . '-' . $wishlist->id;
        $wishlist->save();

        return redirect()->route('wishlists')->with('status', 'Wishlist was made succesfully!');
    }
}

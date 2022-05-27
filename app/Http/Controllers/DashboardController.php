<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show(){
        $shops = Shop::all();
        $user = auth()->user();
        $wishlists = Wishlist::where('user_id', $user->id)->get();

        return view('pages.dashboard', [
            'shops' => $shops,
            'wishlists' => $wishlists
        ]);
    }
}

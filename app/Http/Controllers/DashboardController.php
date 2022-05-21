<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show(){
        $shops = Shop::all();


        return view('pages.dashboard', [
            'shops' => $shops
        ]);
    }
}

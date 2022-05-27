<?php

namespace App\Http\Controllers;

use App\Mail\SendPurchaseMail;
use App\Models\Article;
use App\Models\ArticleWishlist;
use App\Models\Guest;
use App\Models\User;
use App\Models\Wishlist;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;


class PaymentController extends Controller
{
    public function checkout($slug){
        $guest_id = session()->get('guest_id');
        $webhookUrl = route('webhooks.mollie');

        if(App::environment('local')){
            $webhookUrl = 'https://5a43-2a02-a03f-eaf8-f000-ec15-7c70-68e9-4adf.ngrok.io/webhooks/mollie';
        }

        Log::alert('Before Mollie Chekout, total price is calculated');

        $cart = Cart::session($guest_id);
        $total = (string) $cart->getTotal();
        $total = number_format($total, 2);

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Ordered on" . date('d-m-Y h:i'),
            "redirectUrl" => route('guest.chekout.success', ['slug' => $slug]),
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "order_id" => "12345",
            ],
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function success($slug) {
        $guest_id = session()->get('guest_id');
        $guest = Guest::where('id', $guest_id)->first();
        $wishlist = Wishlist::where('slug', $slug)->first();
        $user = User::where('id', $wishlist->user_id)->first();

        // Get Cart details
        $cart = Cart::session($guest_id);
        $items = $cart->getContent();
        $articles = [];

        foreach ($items as $key => $item) {
            $articleWishlist = ArticleWishlist::where('wishlist_id', $wishlist->id)->where('article_id', $item->id)->first();
            $articleWishlist->guest_id = $guest_id;
            $articleWishlist->purchased = true;
            $articleWishlist->save();

            $article = Article::findOrFail($item->id);
            array_push($articles, $article);

            // Send mail to
            Mail::to($user->email)->send(new SendPurchaseMail($wishlist, $article, $guest));
        }

        Cart::session($guest_id)->clear();

        return view('pages.guest.succes', [
            'articles' => $articles,
            'cart' => $cart
        ]);
    }
}

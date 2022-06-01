<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\Guest;
use App\Models\Wishlist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Wishlist $wishlist, Article $article, Guest $guest)
    {
        $this->wishlist = $wishlist;
        $this->article = $article;
        $this->guest = $guest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Someone purchased a project')->markdown('emails.notification.purchase', [
            'wishlist' => $this->wishlist,
            'article' => $this->article,
            'guest' => $this->guest
        ]);
    }
}

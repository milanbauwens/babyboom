<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('article_wishlist');

        Schema::create('article_wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->contstrained();
            $table->foreignId('wishlist_id')->contstrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_wishlists');
    }
};

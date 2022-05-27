<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->contstrained();
            $table->foreignId('wishlist_id')->contstrained();
            $table->foreignId('guest_id')->nullable()->constrained();
            $table->boolean('purchased')->default(false);
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

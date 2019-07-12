<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->default("");
            $table->text('content')->nullable();
            $table->integer('forward_post_id')->default(0);
            $table->integer('original_post_id')->default(0);
            $table->string('assumed_name')->nullable();
            $table->integer('user_id')->default(0);
            $table->string('level_id')->nullable();
            $table->string('vote_id')->nullable();
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('posts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('featured_image')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('slug')->unique();
            $table->text('body');
            $table->unsignedBigInteger('author_id');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')
                ->on('cms_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_posts');
    }
}

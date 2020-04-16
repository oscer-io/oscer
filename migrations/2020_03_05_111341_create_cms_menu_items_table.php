<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->foreignId('menu_id');
            $table->string('url');
            $table->integer('order');
            $table->timestamps();

            $table->foreign('menu_id')
                ->references('id')
                ->on('cms_menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_menu_items');
    }
}

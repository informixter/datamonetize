<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes_products', function (Blueprint $table) {
            $table->dropColumn(['product_id']);
            $table->string("key")->index();
//            $table->integer("recipe_id")->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes_products', function (Blueprint $table) {
            $table->dropColumn(['key']);
            $table->integer("product_id")->index();
        });
    }
}

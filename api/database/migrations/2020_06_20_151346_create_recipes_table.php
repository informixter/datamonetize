<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description")->nullable();
            $table->string("image")->nullable();
            $table->timestamps();
        });

        Schema::create('recipes_data', function (Blueprint $table) {
            $table->id();
            $table->integer("recipes_id")->index();
            $table->text("description")->nullable();
            $table->string("image")->nullable();
            $table->timestamps();
        });

        Schema::create('recipes_products', function (Blueprint $table) {
            $table->id();
            $table->integer("recipe_id")->index();
            $table->integer("product_id")->index();
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
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('recipes_data');
        Schema::dropIfExists('recipes_products');
    }
}

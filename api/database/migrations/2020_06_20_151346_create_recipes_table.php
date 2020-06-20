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

        DB::statement("ALTER TABLE recipes ADD COLUMN searchtext TSVECTOR");
        DB::statement("UPDATE recipes SET searchtext = to_tsvector('russian', title)");
        DB::statement("CREATE INDEX searchtext_gin_recipes ON recipes USING GIN(searchtext)");
        DB::statement("CREATE TRIGGER ts_searchtext_recipes BEFORE INSERT OR UPDATE ON recipes FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.russian', 'title')");

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
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON recipes");
        DB::statement("DROP INDEX IF EXISTS searchtext_gin_recipes");
        DB::statement("ALTER TABLE recipes DROP COLUMN searchtext");

        Schema::dropIfExists('recipes');
        Schema::dropIfExists('recipes_data');
        Schema::dropIfExists('recipes_products');
    }
}

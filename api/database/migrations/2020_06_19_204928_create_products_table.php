<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
//            $table->id();
            $table->integer("id")->index();
            $table->string("level_1")->nullable();
            $table->string("level_2")->nullable();
            $table->string("level_3")->nullable();
            $table->integer("vendor_id")->nullable()->index();
            $table->string("vendor_name")->nullable()->index();
            $table->string("name")->nullable()->index();
            $table->double('price', 8, 4)->index();
            $table->double('price_old', 8, 4);
            $table->boolean('sale')->index();
            $table->double('sale_percent', 8, 4)->index();
            $table->string("image_url")->nullable()->index();
            $table->string("key")->nullable();
            $table->string("q")->nullable();
        });

        DB::statement("ALTER TABLE products ADD COLUMN searchtext TSVECTOR");
        DB::statement("UPDATE products SET searchtext = to_tsvector('russian', name || '' || key)");
        DB::statement("CREATE INDEX searchtext_gin ON products USING GIN(searchtext)");
        DB::statement("CREATE TRIGGER ts_searchtext BEFORE INSERT OR UPDATE ON products FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.russian', 'name', 'key')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON products");
        DB::statement("DROP INDEX IF EXISTS searchtext_gin");
        DB::statement("ALTER TABLE products DROP COLUMN searchtext");
        Schema::dropIfExists('products');
    }
}

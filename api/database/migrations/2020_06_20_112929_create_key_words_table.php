<?php

use App\KeyWords;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_words', function (Blueprint $table) {
            $table->string("cat_key")->index();
            $table->string("search")->index();
        });
        DB::statement("CREATE EXTENSION fuzzystrmatch;");

        $file_path = storage_path("app/cats.txt");
        if (!file_exists($file_path)) {
            echo "File Not Exists\n";
            exit();
        }

        $res = [];
        foreach (file($file_path) as $cat){
            $res[] = [
                "cat_key" => trim($cat),
                "search" => mb_strtolower(trim($cat)),
            ];
        }

        $data = collect($res)->chunk(20);
        foreach ($data as $i => $datum) {
            echo $i."\n";
            KeyWords::insert($datum->toArray());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP EXTENSION fuzzystrmatch;");
        Schema::dropIfExists('key_words');
    }
}

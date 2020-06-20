<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        "id",
        "level_1",
        "level_2",
        "level_3",
        "vendor_id",
        "vendor_name",
        "name",
        "price",
        "price_old",
        "sale",
        "sale_percent",
        "image_url",
        "key",
        "q"
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        $search = trim($search);
        $search = str_replace(" ", "&", $search);

        return $query->whereRaw('searchtext @@ to_tsquery(\'russian\', ?)', [$search])
            ->orderByRaw('ts_rank(searchtext, to_tsquery(\'russian\', ?)) DESC', [$search]);
    }

    public static function getProductsByKeys(array $keys = [])
    {
        $res = [];
        foreach ($keys as $key) {
            $res[] = self::select('*')->where('key', $key)->orderBy('sale_percent', 'desc')->first();
        }

        return $res;
    }

}

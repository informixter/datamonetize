<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    public function steps()
    {
        return $this->hasMany('App\RecipesData', 'recipes_id');
    }

    public function products()
    {
        return $this->hasMany('App\RecipesProducts', 'recipe_id');
    }

//    public function products_by_key()
//    {
//        return $this
////            ->belongsToMany('App\Products', 'recipes_products', 'recipe_id', 'key', 'id', 'key', 're');
//            ->hasOneThrough('App\Products', 'App\RecipesProducts', 'recipe_id', 'key', 'id', 'key');
//    }

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
}

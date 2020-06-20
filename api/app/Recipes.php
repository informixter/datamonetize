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
}

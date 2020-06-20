<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyWords extends Model
{
    protected $fillable = [
        'cat_key',
        'search'
    ];
    
    public $incrementing = false;
    public $timestamps = false;
}

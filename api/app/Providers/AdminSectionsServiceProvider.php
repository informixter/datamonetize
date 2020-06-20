<?php

namespace App\Providers;

use App\KeyWords;
use App\Products;
use App\Recipes;
use App\User;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
//        User::class => 'App\Http\Sections\Users',
        Products::class => 'App\Http\Sections\Products',
        KeyWords::class => 'App\Http\Sections\KeyWords',
        Recipes::class => 'App\Http\Sections\Recipes',

    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}

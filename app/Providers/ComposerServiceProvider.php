<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        View::composers([
            'App\Http\ViewComposers\Director\ListComposer' => 'admin.directors.lists',
            'App\Http\ViewComposers\Adviser\ListComposer' => 'admin.advisers.lists',
            'App\Http\ViewComposers\Advertiser\ListComposer' => 'admin.advertisers.lists',
            'App\Http\ViewComposers\Advertiser\FormComposer' => 'admin.advertisers.form',
            'App\Http\ViewComposers\Publisher\FormComposer' => 'admin.publishers.form',
            'App\Http\ViewComposers\Publisher\ListComposer' => 'admin.publishers.lists',
            'App\Http\ViewComposers\Space\ListComposer' => 'admin.spaces.lists',
        ]);
    }
    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
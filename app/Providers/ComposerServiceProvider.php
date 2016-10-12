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
            'App\Http\ViewComposers\Advertiser\RegisterComposer' => ['admin.advertisers.lists', 'admin.publishers.lists'],
            'App\Http\ViewComposers\Advertiser\FormComposer' => 'admin.advertisers.form',
            'App\Http\ViewComposers\Publisher\FormComposer' => ['admin.publishers.form', 'publisher.complete.form', 'publisher.account.form', 'publisher.agreement.form', 'admin.publishers.agreement'],
            'App\Http\ViewComposers\Publisher\ListComposer' => 'admin.publishers.lists',
            'App\Http\ViewComposers\Space\ListComposer' => 'admin.spaces.lists',
            'App\Http\ViewComposers\Space\FormComposer' => 'admin.spaces.form',
            'App\Http\ViewComposers\Space\OfferComposer' => 'publisher.spaces.form',
            'App\Http\ViewComposers\Publisher\ShowComposer' => 'admin.publishers.show',
            'App\Http\ViewComposers\Proposal\ShowComposer' => 'admin.proposals.show'
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
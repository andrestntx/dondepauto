{!! Menu::make('menu.sidebar', 'nav metismenu')
        ->setParams([
            'user_id' => auth()->user()->id,
            'user_platform_id' => $publisher->id,
            'publisher' => $publisher
        ])->render()
!!}

<div class="col-xs-12 text-center" style="font-size: 16px; margin-bottom: 16px;"> - </div>

{!! Menu::make('menu.publishers', 'nav metismenu')
        ->setParams([
            'user_id' => auth()->user()->id,
            'user_platform_id' => $publisher->id,
            'publisher' => $publisher
        ])->render()
!!}
{!! Menu::make('menu.sidebar', 'nav metismenu')
        ->setParams([
            'user_id' => auth()->user()->id,
            'user_platform_id' => $publisher->id,
            'publisher' => $publisher
        ])->render()
!!}
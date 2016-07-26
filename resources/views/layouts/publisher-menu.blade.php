{!! Menu::make('menu.sidebar', 'nav metismenu')
        ->setParams([
            'user_id' => auth()->user()->id,
            'user_platform_id' => auth()->user()->user_platform_id,
            'publisher' => $publisher
        ])->render()
!!}
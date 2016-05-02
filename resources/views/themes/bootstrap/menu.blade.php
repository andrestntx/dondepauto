<ul class="{{ $class }}">
    @foreach ($items as $item)
        <li @if ($item['class']) class="{{ $item['class'] }}" @endif id="menu_{{ $item['id'] }}">
            @if (empty($item['submenu']))
                <a href="{{ $item['url'] }}">
                    @if(array_key_exists('i', $item))  <i class="{{ $item['i'] }}" title="{{ $item['title'] }}"></i> @endif
                    <span class="nav-label">{{ $item['title'] }}</span>
                </a>
            @else
                <a href="{{ $item['url'] }}" class="dropdown-toggle" data-toggle="dropdown">
                    {{ $item['title'] }}
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    @foreach ($item['submenu'] as $subitem)
                        <li>
                            <a href="{{ $subitem['url'] }}">{{ $subitem['title'] }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
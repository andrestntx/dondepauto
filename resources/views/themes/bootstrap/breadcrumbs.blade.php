@if ($breadcrumbs)
    <h2>{!! end($breadcrumbs)->title !!}</h2>
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$breadcrumb->last)
                <li><a href="{{ $breadcrumb->url }}">{!! $breadcrumb->title !!}</a></li>
            @else
                <li class="active">
                    <strong>{!! $breadcrumb->title !!}</strong>
                </li>
            @endif
        @endforeach
    </ol>
@endif

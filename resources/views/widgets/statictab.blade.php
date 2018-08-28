<div {!! $attributes !!}>
    <ul class="nav nav-tabs">

        @foreach($tabs as $id => $tab)
            @if ($id == $active)
                <li class='active'>
                    <a href="{{ $tab['href'] }}">
                        <i class="fa fa-angle-down"></i>&nbsp;<strong>{{ $tab['title'] }}</strong>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $tab['href'] }}">
                        <i class="fa fa-angle-right"></i>&nbsp;{{ $tab['title'] }}
                    </a>
                </li>
            @endif
        @endforeach

        @if (!empty($dropDown))
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Dropdown <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                @foreach($dropDown as $link)
                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ $link['href'] }}">{{ $link['name'] }}</a></li>
                @endforeach
            </ul>
        </li>
        @endif
        <li class="pull-right header">{{ $title }}</li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active">
            {!! $content !!}
        </div>
    </div>
</div>
<div {!! $attributes !!}>
    <div class="{{ $group_class }}" role="group" style="width: 100%">
        @foreach($buttons as $id => $button)
            <a class="btn {{ $button['class'] }}" style="{{ $button['style'] }}" @if($button['disable']) disabled="disabled" @endif href="{{ $button['url'] }}" >{{ $button['title'] }}</a>
        @endforeach
    </div>
</div>
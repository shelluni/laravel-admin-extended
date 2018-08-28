<div class="{{ $group_class }}" role="group">
    @foreach($buttons as $id => $button)
        <a class="btn {{ $button['class'] }}" style="{{ $button['style'] }}" @if($button['disable']) disabled="disabled" @endif href="{{ $button['url'] }}" >{{ $button['title'] }}</a>
    @endforeach
</div>
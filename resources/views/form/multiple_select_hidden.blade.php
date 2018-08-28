@isset($value)
    @foreach($value as $v)
    <input type="hidden" name="{{$name}}[]" value="{{$v}}" class="{{$class}}" {!! $attributes !!} />
    @endforeach
@endisset
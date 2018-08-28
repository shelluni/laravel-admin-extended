<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
        <label class="btn btn-instagram btn-sm {{ \Request::get('status', 'all') == $option ? 'active' : '' }}">
            <input type="radio" class="status" value="{{ $option }}">{!! $label !!}
        </label>
    @endforeach
</div>
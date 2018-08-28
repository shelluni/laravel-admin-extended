<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div id="div_{{$class}}">
            <input type="hidden" name="{{$name}}[]" value="">
            @isset($value)
                @foreach ($value as $filename)
                    <input type="hidden" name="{{$name}}[]" value="{{$filename}}">
                @endforeach
            @endisset
        </div>

        <input type="file" class="{{$class}}" name="upload_{{$name}}[]" {!! $attributes !!} />

        @include('admin::form.help-block')

    </div>
</div>

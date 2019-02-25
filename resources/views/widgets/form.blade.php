<form {!! $attributes !!}>
    <div class="box-body fields-group">

        @foreach($fields as $field)
            {!! $field->render() !!}
        @endforeach

    </div>

    <!-- /.box-body -->
    <div class="box-footer">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-2"></div>

        <div class="col-md-8">
            @if($options['enable_reset'])
            <div class="btn-group pull-left">
                <button type="reset" class="btn btn-warning pull-right">{{ $options['button_text_reset']=='' ?: trans('admin.reset') }}</button>
            </div>
            @endif

            @if($options['enable_submit'])
            <div class="btn-group pull-{{$options['button_text_submit_position']}}">
                <button type="submit" class="btn btn-info pull-right">{{  $options['button_text_submit'] ?: trans('admin.submit') }}</button>
            </div>
            @endif

        </div>

    </div>
</form>
<div {!! $attributes !!}>
    <div class="box-header with-border">
        <h3 class="box-title">{{ $title }}</h3>
        <div class="box-tools pull-right">
            @foreach($tools as $tool)
                {!! $tool !!}
                @endforeach
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body table-responsive" style="display: block;overflow-x:auto;">
        {!! $content !!}
    </div><!-- /.box-body -->
</div>
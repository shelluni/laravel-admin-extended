<div class="box">

    <div class="box-header with-border">
        <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body table-responsive no-padding">
        <div class="margin">
            <div class="btn-group">
                <a class="btn btn-primary btn-sm {{ $id }}-expandAll">
                    <i class="fa fa-plus-square-o"></i>&nbsp;{{ trans('admin.expand') }}
                </a>
                <a class="btn btn-primary btn-sm {{ $id }}-collapseAll">
                    <i class="fa fa-minus-square-o"></i>&nbsp;{{ trans('admin.collapse') }}
                </a>
            </div>

            @if($useRefresh)
                <div class="btn-group">
                    <a class="btn btn-warning btn-sm {{ $id }}-refresh"><i class="fa fa-refresh"></i>&nbsp;{{ trans('admin.refresh') }}</a>
                </div>
            @endif

            <div class="btn-group">
                {!! $tools !!}
            </div>

            @if($useCreate)
                <div class="btn-group">
                    <a class="btn btn-success btn-sm" href="{{ $path }}/create"><i class="fa fa-save"></i>&nbsp;{{ trans('admin.new') }}</a>
                </div>
            @endif
        </div>
        <div id="{{ $id }}" style="padding: 10px;"></div>
    </div>

    <!-- /.box-body -->

    <script type="text/javascript">

        function getTree()
        {
            return [
                @each($branchView, $items, 'branch')

            ];
        }
    </script>
</div>

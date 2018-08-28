<div class="{{ $grid->containerClass() }}">
    <div class="box-header">

        <h3 class="box-title">{{ $grid->renderTitle() }}</h3>

        <div class="pull-right">
            {!! $grid->renderBackToListButton() !!}
            {!! $grid->renderPrintButton() !!}
            {!! $grid->renderFilter() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
            {!! $grid->renderToolbarRight() !!}
        </div>

        <div class="pull-left">
            {!! $grid->renderHeaderTools() !!}
            <div class="btn-group pull-right" style="margin: 0px 5px;">
            {!! $grid->renderToolbarLeft() !!}
            </div>
        </div>

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table class="{{ $grid->tableClass() }}">
            <tr>
                @foreach($grid->columns() as $column)
                <th>{{$column->getLabel()}}{!! $column->sorter() !!}</th>
                @endforeach
            </tr>

            @foreach($grid->rows() as $row)
            <tr {!! $row->getRowAttributes() !!}>
                @foreach($grid->columnNames as $name)
                <td {!! $row->getColumnAttributes($name) !!}>
                    {!! $row->column($name) !!}
                </td>
                @endforeach
            </tr>
            @endforeach

            {!! $grid->renderFooter() !!}

        </table>
    </div>
    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
        {!! $grid->renderBottom() !!}
    </div>
    <!-- /.box-body -->
</div>

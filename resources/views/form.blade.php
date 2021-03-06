<div class="{{ $form->containerClass() }}">
    <div class="box-header {{ $form->containerHeaderClass() }}">
        <h3 class="box-title">{{ $form->title() }}</h3>

        <div class="pull-right">
            {!! $form->renderHeaderTools() !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    @if($form->hasRows())
        {!! $form->open() !!}
    @else
        {!! $form->open(['class' => "form-horizontal"]) !!}
    @endif

    {!! $form->open(['class' => "form-horizontal"]) !!}
        <div class="box-body">

            @if(!$tabObj->isEmpty())
                @include('admin::form.tab', compact('tabObj'))
            @else
                <div class="fields-group">

                    @if($form->hasRows())
                        @foreach($form->getRows() as $row)
                            {!! $row->render() !!}
                        @endforeach
                    @else
                        @foreach($form->fields() as $field)
                            {!! $field->render() !!}
                        @endforeach
                    @endif


                </div>
            @endif

        </div>
        <!-- /.box-body -->
        <div class="box-footer">

            @if( ! $form->isMode(\Encore\Admin\Form\Builder::MODE_VIEW)  || ! $form->option('enableSubmit'))
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @endif
            <div class="{{$width['label']}}">

            </div>
            <div class="{{$width['field']}}">

                {!! $form->submitButton() !!}

                {!! $form->resetButton() !!}

                {!! $form->cancelButton() !!}

            </div>

        </div>

        @foreach($form->getHiddenFields() as $hiddenField)
            {!! $hiddenField->render() !!}
        @endforeach

        <!-- /.box-footer -->
    {!! $form->close() !!}
</div>


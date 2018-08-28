@if ($dialog->openerMode == 1)
<a id="dialog-opener-{{ $dialog->uniqueId }}" href="" class="btn {{ $dialog->openerButtonClass }}" data-toggle="modal" data-target="#dialog-{{ $dialog->uniqueId }}">
    <i class="fa {{ $dialog->openerButtonIcon }}"></i>&nbsp;&nbsp;{{ $dialog->openerButtonText }}
</a>
    @else
<a id="dialog-opener-{{ $dialog->uniqueId }}" href="" class='margin-r-5 {{ $dialog->openerButtonClass }}' data-toggle="modal" data-target="#dialog-{{ $dialog->uniqueId }}">
    <i class="fa {{ $dialog->openerButtonIcon }}"></i>&nbsp;&nbsp;{{ $dialog->openerButtonText }}
</a>
@endif

<div class="modal fade" id="dialog-{{ $dialog->uniqueId }}" role="dialog" aria-labelledby="modal-label-{{ $dialog->uniqueId }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-label-{{ $dialog->uniqueId }}">{{ $dialog->dialogTitle }}</h4>
            </div>
            <form action="{!! $dialog->action !!}" method="post" class="form-horizontal">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-body">

                    {{ $dialog->addPreviousField() }}

                    @foreach($dialog->fields() as $field)
                        {!! $field->render() !!}
                    @endforeach

                </div>
                <div class="modal-footer">

                    @if ($dialog->hasSubmitButton)
                        <button type="submit" class="submit btn {{ $dialog->submitButtonClass }}">{{ $dialog->submitButtonText }}</button>
                    @endif

                    @if ($dialog->hasCancelButton)
                        <button type="button" class="btn {{ $dialog->cancelButtonClass }}" data-dismiss="modal">{{ $dialog->cancelButtonText }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
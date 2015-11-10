<div class="row">
    <div class="col-sm-2 text-left">
        @if(isset($add_url))
            <a href="{{ $add_url }}" class="btn btn-primary">{{ trans('button.new') }}</a>
        @endif
    </div>
    <div class="col-sm-8 text-center">
        @include('shared._pager', ['pagination' => $pagination])
    </div>
    <div class="col-sm-2 text-right">
        @if ($pagination->lastPage() > 0)
            <button type="submit"
                    form="{{ $delete_form_id }}"
                    data-confirm="Are you sure to delete?"
                    data-disable-with="Processing..."
                    class="btn btn-danger deleteButton" disabled>
                {{ trans('button.delete') }}
            </button>
        @endif
    </div>
</div>

@extends('admin.layout.blog')

@section('bodyId', 'adminTagsIndex')

@section('content')
    <h1 class="title">{{ trans('models.tag') }}</h1>

    {!! BootForm::open()
        ->delete()
        ->action(route('admin.tags.destroy'))
        ->id('deleteForm') !!}
    {!! BootForm::close() !!}

    @if (count($tags) <= 0)
        {{ trans('message.entity_not_exist', ['entity' => trans('models.tag')]) }}
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ trans('attributes.tag.name') }}</th>
                    <th class="text-center deleteColumn">
                        <label><input type="checkbox" id="checkAllDelete"></label>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>
                            {{ $tag->name }}
                            <span class="badge pull-right">{{ $tag->articles->count() }}</span>
                        </td>
                        <td class="text-center">
                            <label><input form="deleteForm" class="checkDelete" type="checkbox" name="delete_items[]" value="{{ $tag->id }}"></label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- .table-responsive -->

        @include('admin.shared._index_nav', [
            'pagination' => $tags,
            'delete_form_id' => 'deleteForm',
        ])
    @endif

    <div class="spacer20">
        <h4>{{ trans('title.new_tag') }}</h4>

        {!! BootForm::open()->action(route('admin.tags.store')) !!}
            {!! BootForm::text('Name', 'name')->hideLabel() !!}
            {!! BootForm::submit(trans('button.add'), 'btn-primary') !!}
        {!! BootForm::close() !!}
    </div>
@endsection

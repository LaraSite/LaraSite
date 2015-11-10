@extends('admin.layout.blog')

@section('bodyId', 'adminCategoriesIndex')

@section('content')
    <h1 class="title">{{ trans('models.category') }}</h1>

    {!! BootForm::open()
        ->delete()
        ->action(route('admin.categories.destroy'))
        ->id('deleteForm') !!}
    {!! BootForm::close() !!}

    @if (count($categories) <= 0)
        {{ trans('message.entity_not_exist', ['entity' => trans('models.category')]) }}
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{ trans('attributes.category.name') }}</th>
                    <th class="text-center deleteColumn">
                        <label><input type="checkbox" id="checkAllDelete"></label>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            {{ $category->name }}
                            <span class="badge pull-right">{{ $category->articles->count() }}</span>
                        </td>
                        <td class="text-center">
                            <label><input form="deleteForm" class="checkDelete" type="checkbox" name="delete_items[]" value="{{ $category->id }}"></label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- .table-responsive -->

        @include('admin.shared._index_nav', [
            'pagination' => $categories,
            'delete_form_id' => 'deleteForm',
        ])
    @endif

    <div class="spacer20">
        <h4>{{ trans('title.new_category') }}</h4>

        {!! BootForm::open()->action(route('admin.categories.store')) !!}
            {!! BootForm::text('Name', 'name')->hideLabel() !!}
            {!! BootForm::submit(trans('button.add'), 'btn-primary') !!}
        {!! BootForm::close() !!}
    </div>
@endsection

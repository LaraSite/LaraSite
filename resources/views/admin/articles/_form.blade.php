{!! BootForm::bind($article) !!}
{!! BootForm::text(trans('attributes.article.title'), 'title') !!}
{!! BootForm::textarea(trans('attributes.article.body'), 'body')->addClass('tinymce') !!}
{!! BootForm::select(trans('attributes.article.category'), 'category_id')->options(category_list()) !!}
{!! BootForm::select(trans('attributes.article.tag'), 'tag_list')->options(tag_list())->multiple()->addClass('tags') !!}
{!! BootForm::select(trans('attributes.article.status'), 'status')->options($article->status_options()) !!}
{!! BootForm::text(trans('attributes.article.published'), 'published_at', $article->published_at->format('Y-m-d H:i'))
    ->addClass('datetimepicker')
!!}

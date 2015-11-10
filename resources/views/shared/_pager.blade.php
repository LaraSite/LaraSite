@if ($pagination->lastPage() > 0)
    <div class="btn-group" role="group" aria-label="...">
        <?php $prev_disable = ($pagination->currentPage() == 1) ? 'disabled' : '' ?>
        <?php $next_disable = $pagination->hasMorePages() ? '' : 'disabled' ?>

        <a href="{{ $pagination->url(1) }}" class="btn btn-default" {{ $prev_disable }}>«</a>
        <a href="{{ $pagination->previousPageUrl() }}" class="btn btn-default" {{ $prev_disable }}>‹</a>
        <button class="btn btn-default paginatorCounter" disabled>
            {{ $pagination->currentPage() }} / {{ $pagination->lastPage() }}
        </button>
        <a href="{{ $pagination->nextPageUrl() }}" class="btn btn-default" {{ $next_disable }}>›</a>
        <a href="{{ $pagination->url($pagination->lastPage()) }}" class="btn btn-default" {{ $next_disable }}>»</a>
    </div>
@endif

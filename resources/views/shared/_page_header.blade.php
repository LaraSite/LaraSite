<header>
    <div class="container">
        <h1>{{ $title }}</h1>
        @if (isset($lead))
            <p class="lead">{{ $lead }}</p>
        @endif
    </div>
</header>

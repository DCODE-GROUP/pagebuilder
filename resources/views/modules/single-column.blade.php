<section class="grid-container module-single-column{{ $fields->padding->value ? ' padding' : null }}">
    @if ($fields->heading->value)
    <h2>{{ $fields->heading->value }}</h2>
    @endif

    @if ($fields->sub_heading->value)
    <h3>{{ $fields->sub_heading->value }}</h3>
    @endif

    @if ($fields->body->value)
    {!! $fields->body->value !!}
    @endif
</section>
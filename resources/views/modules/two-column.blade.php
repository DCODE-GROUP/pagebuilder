<section class="grid-container module-two-column{{ $fields->padding->value ? ' padding' : null }}">
    <div class="grid-x grid-padding-x">
        <div class="cell">
            <h2>{{ $fields->heading->value }}</h2>
        </div>
        <div class="cell medium-6">
            {!! $fields->body_one->value !!}
        </div>
        <div class="cell medium-6">
            {!! $fields->body_two->value !!}
        </div>
    </div>
</section>
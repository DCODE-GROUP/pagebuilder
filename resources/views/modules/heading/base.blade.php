<section class="page-heading module-heading grid-x margin-bottom-8 align-center{{ $fields->dark->value ? ' dark' : '' }}" data-aos="fade">
    <h1>
        {{ $fields->heading->value }}
        @if (isset($fields->sub_heading->value))
            / <span class="pink">{{ $fields->sub_heading->value }}</span>
        @endif
    </h1>
</section>

<section class="image-slider
{{ isset($fields->contained->value) && $fields->contained->value ? 'grid-container ' : '' }}
{{ isset($fields->margins->value) && $fields->margins->value ? '' : 'no-margin ' }}
{{ isset($fields->fullHeight->value) && $fields->fullHeight->value ? 'full-height' : '' }}" data-aos="fade">

    @foreach($fields->items->value as $data)
        <img src="{{ $data->image->url }}" alt="">
    @endforeach
</section>
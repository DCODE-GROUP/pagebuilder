<section class="image-slider
{{ isset($fields->contained->value) && $fields->contained->value ? 'grid-container ' : '' }}
{{ isset($fields->margins->value) && $fields->margins->value ? '' : 'no-margin ' }}
{{ isset($fields->fullHeight->value) && $fields->fullHeight->value ? 'full-height' : '' }}" data-aos="fade">

    <image-slider :slides='@json($fields->items->value)'
                  :interval="{{ $fields->interval->value ?? 5000 }}"></image-slider>
</section>
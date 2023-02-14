@php use Illuminate\Support\Str; @endphp
<section class="two-column-with-image
{{ ' ' . $fields->alignment->value . ' ' }}
{{ $fields->style->value ?? null }}
{{ $fields->padding->value ? ' padding' : null }}">
    @if (isset($fields->anchor->value))
        <a class="anchor" id="{{ Str::slug($fields->anchor->value) }}"></a>
    @endif
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <article class="cell small-12 large-6">
                <div>
                    {!! $fields->body->value !!}
                </div>
                <button type="button" class="button read-more">Read more</button>
            </article>
            <aside class="cell small-12 large-6">
                <div>
                    @isset($fields->imageLink->value)
                        <a href="{{ $fields->imageLink->value }}">
                    @endisset

                        <img src="{{ $fields->image->value->url }}">
                    @isset($fields->imageLink->value)
                        </a>
                    @endisset
                </div>
            </aside>
        </div>
    </div>
</section>
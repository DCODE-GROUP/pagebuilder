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
                @if (SiteService::isACN())
                    <div>
                        @isset($fields->imageLink->value)
                            @php $isVideoLink = Video::isVideoLink($fields->imageLink->value); @endphp
                            <a href="{{ $fields->imageLink->value }}" {!! $isVideoLink ? 'class="video-modal"' : null  !!}>
                                @endisset

                                <img src="{{ $fields->image->value }}"
                                     class="{{ $fields->style->value === 'dark' ? 'parallax' : null }} {{ $fields->rounded->value ? ' rounded' : null }}">

                    </div>
                @else
                    @component('cms.modules.wrap.link', [
                        'link' => $fields->imageLink->value ?? null,
                    ])
                        <div class="img-cover"
                             style="background-image:url('{{ backgroundImageUri($fields->image->value) }}')">
                            <img src="{{ $fields->image->value }}"
                                 class="{{ $fields->style->value === 'dark' ? 'parallax' : null }}
                                 {{ $fields->rounded->value ? ' rounded' : null }}"
                            >
                        </div>
                    @endcomponent
                @endif
                @isset($fields->icon->value)
                    <img src="{{ $fields->icon->value }}" class="icon-image"/>
                @endisset
            </aside>
        </div>
    </div>
</section>
<x-page-builder::layouts.page>

    {{--@section('title', $page->seo->title ?? $page->title)--}}
    @section('title', $page->title)

    @if (false && $page->seo)
        @section('description', $page->seo->description)
        @section('keywords', $page->seo->keywords)
    @endif

    @if ($page->featured_image)
        @section('metaImage', $page->featured_image)
    @endif

    {!! $page->render() !!}

</x-page-builder::layouts.page>

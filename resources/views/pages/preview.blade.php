{{--@extends('layouts.acn')--}}

{{--@section('title', $page->seo->title ?? $page->title)--}}

{{--@if ($page->seo)--}}
{{--    @section('description', $page->seo->description)--}}
{{--    @section('keywords', $page->seo->keywords)--}}
{{--@endif--}}

{{--@if ($page->featured_image)--}}
{{--	@section('metaImage', $page->featured_image)--}}
{{--@endif--}}

{{--@section('content')--}}

    {{-- PageService   --}}
    {!! $page->render() !!}

{{--@endsection--}}

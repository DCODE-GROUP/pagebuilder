@php use Dcodegroup\PageBuilder\Models\Page;use Dcodegroup\PageBuilder\Models\Template;use Dcodegroup\PageBuilder\Services\PageService; @endphp
<x-app-layout>
    <div class="pt-8 pb-32">
        @if (isset($page))
        {{ Form::model($page, ['route' => [\Dcodegroup\PageBuilder\Routes::admin('pages.update'), $page], 'method' => 'PUT', 'autocomplete' => 'off', 'name' => 'page_form']) }}
        @else
        {{ Form::open(['route' => \Dcodegroup\PageBuilder\Routes::admin('pages.store'), 'method' => 'post', 'autocomplete' => 'off', 'name' => 'page_form']) }}
        @endif

        <header class="mb-4">
            @if (isset($page))
            <h1>Editing page: <span class="text-brand-green">{{ $page->title }}</span></h1>
            @else
            <h1>Create new page</h1>
            @endif
        </header>
        <div class="top-form grid-container full has-admin-controls">
            @if (!isset($page) || !$page->isDynamic)
            <title-slug set-title="{{ $page->title ?? null }}" title-error="{{ $errors->first('title') }}" set-slug="{{ $page->slug ?? null }}" slug-error="{{ $errors->first('slug') }}"></title-slug>
            @endif
            <section class="flex mb-4 space-x-4">
                <div class="w-1/2">
                    {{ Form::label('parent_id', 'Parent page', ['class' => 'form-label']) }}
                    <span data-tooltip title="If a parent page is selected, this page's URL will be prefixed with the parent page slug.">
                        <i class="fal fa-info-circle"></i>
                    </span>
                    {{ Form::vSelect('parent_id', Page::class,
                 $page->parent_id ?? old('parent_id') ?? null,
                 ['placeholder' => 'Select a parent page']) }}
                    {!! $errors->first('parent_id', '<span class="form-error is-visible">:message</span>') !!}
                </div>
                <div class="w-1/2">
                    {{ Form::label('template_id', 'Template', ['class' => 'form-label']) }}
                    {{ Form::vSelect('template_id', Template::class,
                $page->template_id ?? old('template_id') ?? null,
                ['placeholder' => 'Default template']) }}
                    {!! $errors->first('template_id', '<span class="form-error is-visible">:message</span>') !!}
                </div>
            </section>

            <section class="flex mb-4 space-x-4">
                <div class="w-1/2">
                    {{ Form::label('abstract', 'Abstract', ['class' => 'form-label']) }}
                    <span data-tooltip title="The abstract displayed on listing pages.">
                        <i class="fal fa-info-circle"></i>
                    </span>
                    {{ Form::textarea('abstract', null, ['rows' => 7, 'class' => 'form-input']) }}
                    {!! $errors->first('abstract', '<span class="form-error is-visible">:message</span>') !!}
                </div>
                <div class="w-1/2">
                    <label class="form-label">
                        Featured image
                        <span data-tooltip title="If a featured image is set, it will appear as a hero image on the page.">
                            <i class="fal fa-info-circle"></i>
                        </span>
                    </label>
                    <select-media field="featured_image" value="{{ $page->featured_image ?? null }}" mobile-value="{{ $page->featured_image_mobile ?? null }}"></select-media>
                </div>
            </section>

            <section class="mb-10">
                <div class="cell medium-1 -no-label">
                    @if (!isset($page) || !$page->isDynamic)
                    {{ Form::label('active', 'Active') }}
                    {{ Form::checkbox('active', 1, $page->active ?? true) }}
                    @endif
                </div>
            </section>

            <section class="">
                <header class="mb-8">
                    <h2>Content</h2>
                </header>
                <content-builder :modules="{{ $CMSModules }}" :dynamic-modules="{{ $DynamicCMSModules ?? '{}' }}" :page-content="{{ $pageService->constructPageContent(old('content') ?? $page->content ?? '[]') }}"></content-builder>
                {!! $errors->first('content', '<span class="form-error is-visible">:message</span>') !!}
            </section>
        </div>

        {{ Form::close() }}

        <div class="my-20 border-t border-black"></div>
        @if (isset($page) && !$page->isDynamic)
        @include('page-builder::_partials.delete-confirm', [
        'object' => $page,
        'type' => 'page',
        'route' => \Dcodegroup\PageBuilder\Routes::admin('pages.destroy'),
        'label' => 'page ' . $page->title
        ])
        @endif

        <footer class="fixed bottom-0 left-0 w-full px-6 py-4 bg-brand-almond-100">
            <div class="container">
                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn btn-primary" onclick="document.page_form.submit()">
                        <i class="fal fa-save"></i>
                        {{ isset($page) ? 'Update' : 'Create' }} page
                    </button>

                    <page-preview {{ isset($page) ? 'page-id=' . $page->id : ''}}></page-preview>

                    @isset ($page)
                    <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.revisions.index'), $page) }}" class="btn btn-primary btn-primary-outlined">
                        Revisions {{ $page->revisionsCount ? '(' . $page->revisionsCount . ')' : null }}
                    </a>
                    @endisset
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>

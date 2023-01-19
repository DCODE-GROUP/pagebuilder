@php use Dcodegroup\PageBuilder\Models\Page;use Dcodegroup\PageBuilder\Models\Template;use Dcodegroup\PageBuilder\Services\PageService; @endphp
<x-page-builder::layouts.admin>
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
        <div class="top-form grid-container full has-admin-controls ">
            <title-slug set-title="{{ $page->title ?? null }}" title-error="{{ $errors->first('title') }}" set-slug="{{ $page->slug ?? null }}" slug-error="{{ $errors->first('slug') }}"></title-slug>
            <section class="flex mb-4 space-x-4">
                <div class="w-1/2">
                    <div class="flex items-center">
                        {{ Form::label('parent_id', 'Parent page', ['class' => 'form-label']) }}

                        <tooltip iconclasses="ml-1 -mt-2 text-brand-green">If a parent page is selected, this page's URL will be prefixed with the parent page slug.</tooltip>
                        <!-- <span data-tooltip title="" class="ml-2 -mt-2 text-brand-green">
                            <i class="fa-solid fa-circle-info"></i>
                        </span> -->
                    </div>
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
                    <div class="flex items-center">
                        {{ Form::label('abstract', 'Abstract', ['class' => 'form-label']) }}
                        <tooltip iconclasses="ml-1 -mt-2 text-brand-green">The abstract displayed on listing pages.</tooltip>
                    </div>
                    {{ Form::textarea('abstract', null, ['rows' => 7, 'class' => 'form-input']) }}
                    {!! $errors->first('abstract', '<span class="form-error is-visible">:message</span>') !!}
                </div>
                <div class="w-1/2">
                    <label class="form-label">
                        Featured image
                        <tooltip iconclasses="ml-1 -mt-2 text-brand-green">If a featured image is set, it will appear as a hero image on the page.</tooltip>
                    </label>
                    <select-media field="featured_image" value="{{ $page->featured_image ?? null }}" mobile-value="{{ $page->featured_image_mobile ?? null }}"></select-media>
                </div>
            </section>

            <section class="mb-10">
                <div class="cell medium-1 -no-label">
                    <label class="sm-toggleable sm-switch" for="active">
                        {{ Form::checkbox('active', 1, $page->active ?? true) }}
                        <span class="form-label">Active</span>
                    </label>
                </div>
            </section>

            <section class="">
                <header class="mb-8">
                    <h2>Content</h2>
                </header>
                <content-builder :modules="{{ $CMSModules }}" :page-content="{{ $pageService->constructPageContent(old('content') ?? $page->content ?? '[]') }}"></content-builder>
                {!! $errors->first('content', '<span class="form-error is-visible">:message</span>') !!}
            </section>
        </div>

        {{ Form::close() }}

        <div class="my-20 border-t border-black"></div>
        @if (isset($page))
        @include('page-builder::_partials.delete-confirm', [
        'object' => $page,
        'type' => 'page',
        'route' => \Dcodegroup\PageBuilder\Routes::admin('pages.destroy'),
        'label' => 'page ' . $page->title
        ])
        @endif

        <page-preview {{ isset($page) ? 'page-id=' . $page->id : ''}}></page-preview>

        <footer class="fixed bottom-0 left-0 w-full px-6 py-4 bg-brand-almond-100">
            <div class="container">
                <div class="flex items-center space-x-2">
                    <button type="submit" class="btn btn-primary" onclick="document.page_form.submit()">
                        <i class="mr-2 fa-regular fa-floppy-disk"></i>
                        {{ isset($page) ? 'Update' : 'Create' }} page
                    </button>

                    @isset ($page)
                    <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.revisions.index'), $page) }}" class="btn btn-primary btn-primary-outlined">
                        Revisions {{ $page->revisionsCount ? '(' . $page->revisionsCount . ')' : null }}
                    </a>
                    @endisset
                </div>
            </div>
        </footer>
    </div>
</x-page-builder::layouts.admin>

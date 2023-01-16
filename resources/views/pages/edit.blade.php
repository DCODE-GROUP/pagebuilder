@php use Dcodegroup\PageBuilder\Models\Page;use Dcodegroup\PageBuilder\Models\Template;use Dcodegroup\PageBuilder\Services\PageService; @endphp
<x-app-layout>
    <div class="pt-8">
        @if (isset($page))
        {{ Form::model($page, ['route' => ['admin.pages.update', $page], 'method' => 'PUT', 'autocomplete' => 'off', 'name' => 'page_form']) }}
        @else
        {{ Form::open(['route' => 'admin.pages.store', 'method' => 'post', 'autocomplete' => 'off', 'name' => 'page_form']) }}
        @endif

        <header class="mb-4">
            @if (isset($page))
            <h1>Editing page: <small class="red">{{ $page->title }}</small></h1>
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
                    {{ Form::label('parent_id', 'Parent page') }}
                    <span data-tooltip title="If a parent page is selected, this page's URL will be prefixed with the parent page slug.">
                        <i class="fal fa-info-circle"></i>
                    </span>
                    {{ Form::vSelect('parent_id', Page::class,
                 $page->parent_id ?? old('parent_id') ?? null,
                 ['placeholder' => 'Select a parent page']) }}
                    {!! $errors->first('parent_id', '<span class="form-error is-visible">:message</span>') !!}
                </div>
                <div class="w-1/2">
                    {{ Form::label('template_id', 'Template') }}
                    {{ Form::vSelect('template_id', Template::class,
                $page->template_id ?? old('template_id') ?? null,
                ['placeholder' => 'Default template']) }}
                    {!! $errors->first('template_id', '<span class="form-error is-visible">:message</span>') !!}
                </div>
            </section>

            <section class="flex mb-4 space-x-4">
                <div class="w-1/2">
                    {{ Form::label('abstract', 'Abstract') }}
                    <span data-tooltip title="The abstract displayed on listing pages.">
                        <i class="fal fa-info-circle"></i>
                    </span>
                    {{ Form::textarea('abstract', null, ['rows' => 4]) }}
                    {!! $errors->first('abstract', '<span class="form-error is-visible">:message</span>') !!}
                </div>
                <div class="w-1/2">
                    <label>
                        Featured image
                        <span data-tooltip title="If a featured image is set, it will appear as a hero image on the page.">
                            <i class="fal fa-info-circle"></i>
                        </span>
                    </label>
                    <select-media field="featured_image" value="{{ $page->featured_image ?? null }}" mobile-value="{{ $page->featured_image_mobile ?? null }}"></select-media>
                </div>
                <div class="cell medium-1 -no-label">
                    @if (!isset($page) || !$page->isDynamic)
                    {{ Form::label('active', 'Active') }}
                    {{ Form::checkbox('active', 1, $page->active ?? true) }}
                    @endif
                </div>
            </section>

            <section class="">
                <h2>Content</h2>
                <content-builder :modules="{{ $CMSModules }}" :dynamic-modules="{{ $DynamicCMSModules ?? '{}' }}" :page-content="{{ $pageService->constructPageContent(old('content') ?? $page->content ?? '[]') }}"></content-builder>
                {!! $errors->first('content', '<span class="form-error is-visible">:message</span>') !!}
            </section>
        </div>

        {{ Form::close() }}

        <footer class="fixed-admin-controls">
            <div>
                <div class="grid-x align-justify">
                    <div class="button-group">
                        <button type="submit" class="mr-2 btn btn-primary" onclick="document.page_form.submit()">
                            <i class="fal fa-save"></i>
                            {{ isset($page) ? 'Update' : 'Create' }} page
                        </button>

                        <page-preview {{ isset($page) ? 'page-id=' . $page->id : ''}}></page-preview>

                        @isset ($page)
                        <a href="{{ route('admin.pages.revisions.index', $page) }}" class="btn btn-btn-primary-outlined">
                            <i class="fal fa-history"></i>
                            Revisions {{ $page->revisionsCount ? '(' . $page->revisionsCount . ')' : null }}
                        </a>
                        @endisset
                    </div>
                    @if (isset($page) && !$page->isDynamic)
                    @include('page-builder::_partials.delete-confirm', [
                    'object' => $page,
                    'type' => 'page',
                    'route' => 'admin.pages.destroy',
                    'label' => 'page ' . $page->title
                    ])
                    @endif
                </div>
            </div>
        </footer>
    </div>
</x-app-layout>
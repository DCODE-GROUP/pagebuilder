@php use Dcodegroup\PageBuilder\Models\Page;use Dcodegroup\PageBuilder\Models\Template;use Dcodegroup\PageBuilder\Services\PageService; @endphp
<x-page-builder::layouts.admin page-class="h-full max-w-full px-0 pb-32">
    <v-form
            store-action="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.store')) }}"
            update-action="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.update'), ':page') }}"
            :default-page="{{ json_encode($page) }}"
    >
        <template #fields>
            @csrf
            <div class="flex w-full space-x-4">
                <div class="w-3/12 px-4 pt-8">
                    <header class="mb-4">
                        @if ($page->exists)
                            <h4>Editing page: <span class="text-brand-green">{{ $page?->title }}</span></h4>
                        @else
                            <h4>Create new page</h4>
                        @endif
                    </header>
                    <page-builder-sidebar :page="{{ \Illuminate\Support\Js::from($page) }}">
                        <template #first>
                            <div class="top-form grid-container full has-admin-controls">

                                <section class="mb-4">
                                    <label for="active" class="form-label">Active</label>
                                    <label class="sm-toggleable sm-switch" for="active">
                                        {{ Form::checkbox('active', 1, $page->active ?? true, ['id' => 'active']) }}
                                        <span class="form-label"></span>
                                    </label>
                                </section>

                                <title-slug set-title="{{ $page->title ?? null }}" title-error="{{ $errors->first('title') }}" set-slug="{{ $page->slug ?? null }}" slug-error="{{ $errors->first('slug') }}"></title-slug>

                                <section>
                                    <div class="mb-4">
                                        <div class="flex items-center mb-2">
                                            {{ Form::label('parent_id', 'Parent page', ['class' => 'form-label !mb-0']) }}
                                            <tooltip iconclasses="ml-1 text-brand-green">If a parent page is selected, this page's URL will be prefixed with the parent page slug.</tooltip>
                                        </div>
                                        <div>
                                            {{ Form::vSelect('parent_id', Page::class,
                                                $page->parent_id ?? old('parent_id') ?? null,
                                                ['placeholder' => 'Select a parent page']) }}
                                            {!! $errors->first('parent_id', '<span class="form-error is-visible">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        {{ Form::label('template_id', 'Template', ['class' => 'form-label']) }}
                                        {{ Form::vSelect('template_id', Template::class,
                                $page->template_id ?? old('template_id') ?? null,
                                ['placeholder' => 'Default template']) }}
                                        {!! $errors->first('template_id', '<span class="form-error is-visible">:message</span>') !!}
                                    </div>
                                </section>

                                <section>
                                    <div class="mb-4">
                                        <div class="flex items-center mb-2">
                                            {{ Form::label('abstract', 'Abstract', ['class' => 'form-label !mb-0']) }}
                                            <tooltip iconclasses="ml-1 text-brand-green">The abstract displayed on listing pages.</tooltip>
                                        </div>
                                        {{ Form::textarea('abstract', null, ['rows' => 7, 'class' => 'form-input']) }}
                                        {!! $errors->first('abstract', '<span class="form-error is-visible">:message</span>') !!}
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">
                                            Featured image
                                            <tooltip iconclasses="ml-1 text-brand-green">If a featured image is set, it will appear as a hero image on the page.</tooltip>
                                        </label>
                                        <attachment
                                                :default-model="{{ \Illuminate\Support\Js::from($page ?? []) }}"
                                                model-class="{{ Page::class }}"
                                                upload-endpoint="{{ route(Dcodegroup\PageBuilder\Routes::admin('pages.upload-media')) }}"
                                                field="featured_image"
                                                :desktop-image="{{ \Illuminate\Support\Js::from($featuredImage ?? []) }}"
                                                :mobile-image="{{ \Illuminate\Support\Js::from($mobileFeaturedImage ?? []) }}"
                                        ></attachment>
                                    </div>
                                </section>
                            </div>
                        </template>
                        <template #second>
                            <section class="">
                                <header class="mb-8">
                                    <h2>Content</h2>
                                </header>
                                <content-builder
                                        :modules="{{ $CMSModules }}"
                                        :page-content="{{ $pageService->constructPageContent(old('content') ?? $page->content ?? '[]') }}"
                                        :default-page-model="{{ \Illuminate\Support\Js::from($page ?? []) }}"
                                        page-model-class="{{ Page::class }}"
                                        media-upload-endpoint="{{ route(Dcodegroup\PageBuilder\Routes::admin('pages.upload-media')) }}"
                                        get-folders-endpoint="{{ route(\Dcodegroup\PageBuilder\Routes::admin('folders.index')) }}"
                                        save-folder-endpoint="{{ route(\Dcodegroup\PageBuilder\Routes::admin('folders.store')) }}"
                                        gallery-media-upload-endpoint="{{ route(\Dcodegroup\PageBuilder\Routes::admin('media.upload')) }}"
                                        get-folder-endpoint="{{ route(\Dcodegroup\PageBuilder\Routes::admin('folders.show'), [':folder']) }}"
                                        media-index-endpoint="{{ route(\Dcodegroup\PageBuilder\Routes::admin('media.index')) }}"
                                ></content-builder>
                                {!! $errors->first('content', '<span class="form-error is-visible">:message</span>') !!}
                            </section>
                        </template>
                    </page-builder-sidebar>
                </div>
                <div class="w-9/12 px-4">
                    <page-preview {{ $page->exists ? 'page-id=' . $page->id : ''}}></page-preview>
                </div>
            </div>

            <footer class="fixed bottom-0 left-0 w-full px-6 py-4 bg-brand-almond-100">
                <div class="container">
                    <div class="flex items-center space-x-2">
                        <submit :default-value="{{ json_encode(!$page->exists) }}"></submit>

                        @if ($page->exists)
                            <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.revisions.index'), $page) }}" class="btn btn-primary btn-primary-outlined">
                                Revisions {{ $page->revisionsCount ? '(' . $page->revisionsCount . ')' : null }}
                            </a>
                        @endif

                        @if ($page->exists)
                            <modal button-text="Delete">
                                @include('page-builder::_partials.delete-confirm', [
                                'object' => $page,
                                'type' => 'page',
                                'route' => \Dcodegroup\PageBuilder\Routes::admin('pages.destroy'),
                                'label' => 'page ' . $page->title
                                ])
                            </modal>
                        @endif
                    </div>
                </div>
            </footer>
        </template>
    </v-form>
</x-page-builder::layouts.admin>
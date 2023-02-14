<x-page-builder::layouts.admin page-class="h-full max-w-full px-0">
    <section>

        <header class="admin-header">
            <h2>
                {{ $template->exists ? __('Edit Template') : __('Create Template') }}
            </h2>
        </header>

        @if ($template->exists)
            {{ Form::model($template, ['route' => [\Dcodegroup\PageBuilder\Routes::admin('templates.update'), $template], 'method' => 'PUT', 'autocomplete' => 'off', 'name' => 'template_form']) }}
        @else
            {{ Form::open(['route' => \Dcodegroup\PageBuilder\Routes::admin('templates.store'), 'method' => 'post', 'autocomplete' => 'off', 'name' => 'template_form']) }}
        @endif

        <fieldset>
            <div class="col-span-12">
                <label for="name">
                    {{ __('Name') }}
                </label>
                <input
                        type="text"
                        class="form-input"
                        name="name"
                        placeholder="{{ __('Name') }}"
                        value="{{ request()->old('name', $template->name) }}">
            </div>
            <div class="col-span-12">
                <label for="key">
                    {{ __('Key') }}
                </label>
                <input
                        type="text"
                        class="form-input"
                        name="key"
                        placeholder="{{ __('Key') }}"
                        value="{{ request()->old('key', $template->key) }}">
            </div>
        </fieldset>
        <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
    </section>
</x-page-builder::layouts.admin>
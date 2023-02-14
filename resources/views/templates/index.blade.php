<x-page-builder::layouts.admin>
    <div class="pt-8">
        <header class="mb-4">
            <h1>Templates</h1>
        </header>
        <div class="flex justify-between mb-8">
            <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('templates.create')) }}" class="btn btn-primary">
                <i class="mr-2 fa-solid fa-plus"></i>
                Add
            </a>
            @include('page-builder::_partials.filters.search')
        </div>

        @if ($templates->isNotEmpty())
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Key</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($templates as $template)
                    <tr>
                        <td>
                            {{ $template->name }}
                        </td>
                        <td>{{ $template->key }}</td>
                        <td>
                            <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('templates.edit'), $template) }}">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $templates->appends(request()->except(['template','_token']))->links() }}
        @endif
    </div>
</x-page-builder::layouts.admin>

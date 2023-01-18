<x-app-layout>
    <div class="pt-8">
        <header class="mb-4">
            <h1>Pages</h1>
        </header>
        <div class="flex justify-between mb-8">
            <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.create')) }}" class="btn btn-primary">
                <i class="fal fa-plus"></i>
                Add
            </a>
            @include('page-builder::_partials.filters.search')
        </div>

        @if ($pages->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Last updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>
                        @if ($page->isDynamic)
                        <i class="fal fa-thumbtack"></i>&nbsp;
                        @endif
                        {{ $page->title }}
                    </td>
                    <td>{{ $page->relativeSlug }}</td>
                    <td>{{ $page->status }}</td>
                    <td>{{ $page->updatedAtForHumans }}</td>
                    <td>
                        <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.edit'), $page) }}" class="button secondary tiny">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pages->appends(request()->except(['page','_token']))->links() }}
        @else
        @include('page-builder::_partials.components.no-results', ['label' => 'pages'])
        @endif
    </div>
</x-app-layout>

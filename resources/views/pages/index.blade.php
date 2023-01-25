<x-page-builder::layouts.admin>
    <div class="pt-8">
        <header class="mb-4">
            <h1>Pages</h1>
        </header>
        <div class="flex justify-between mb-8">
            <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.create')) }}" class="btn btn-primary">
                <i class="mr-2 fa-solid fa-plus"></i>
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
                        {{ $page->title }}
                    </td>
                    <td>{{ $page->relativeSlug }}</td>
                    <td>{{ $page->status }}</td>
                    <td>{{ $page->updatedAtForHumans }}</td>
                    <td>
                        <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.edit'), $page) }}">
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pages->appends(request()->except(['page','_token']))->links() }}
        @endif
    </div>
</x-page-builder::layouts.admin>

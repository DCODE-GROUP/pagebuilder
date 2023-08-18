<x-page-builder::layouts.admin>
@section('title', 'Revisions for page ' . $page->title)

<a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.edit'), $page) }}" class="button">
    Back to page
</a>

@if ($revisions->isNotEmpty())
    <table class="text-left">
        <thead>
        <tr>
            <th>Updated</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Latest</td>
            <td>
                <a href="{{ route(\Dcodegroup\PageBuilder\Routes::front('view'), $page->slug) }}" class="btn btn-primary" target="_blank">
                    View revision
                </a>
            </td>
        </tr>
        @foreach($revisions as $revision)
            <tr>
                <td width="70%">{!! nl2br($revision->updatedByForHumans) !!}</td>
                <td>
                    <div class="btn-group space-x-2 flex flex-1">
                        <a href="{{ route(\Dcodegroup\PageBuilder\Routes::admin('pages.revisions.show'), $revision) }}" class="btn btn-primary" target="_blank">
                            View revision
                        </a>
                        {{ Form::open(['route' => [\Dcodegroup\PageBuilder\Routes::admin('pages.revisions.restore'), $revision], 'method' => 'put']) }}
                            <button type="submit" class="btn btn-primary">Restore</button>
                        {{ Form::close() }}
                        <page-builder-modal button-text="Delete">
                        @include('page-builder::_partials.delete-confirm', [
                            'route' => \Dcodegroup\PageBuilder\Routes::admin('pages.revisions.destroy'),
                            'object' => $revision,
                            'label' => 'this page revision',
                            'type' => 'revision'
                        ])
                        </page-builder-modal>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $revisions->appends(request()->except(['page','_token']))->links() }}
@endif
</x-page-builder::layouts.admin>

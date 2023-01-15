@extends('layouts.admin')
@section('title', 'Revisions for page ' . $page->title)

@section('content')

    <a href="{{ route('admin.pages.edit', $page) }}" class="button">
        Back to page
    </a>

    @if ($revisions->isNotEmpty())
        <table>
            <thead>
            <tr>
                <th>Content</th>
                <th>Updated</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($revisions as $revision)
                <tr>
                    <td>
                        <h1>{{ $revision->title }}</h1>
                        <hr />
                        @if ($revision->abstract)
                            <h5>Abstract</h5>
                            {{ $revision->abstract }}
                            <hr />
                        @endif
                        <h5>Content</h5>
                        {!! CMS::render($page) !!}
                    </td>
                    <td>{!! nl2br($revision->updatedByForHumans) !!}</td>
                    <td>
                        <div class="button-group">
                            {{ Form::open(['route' => ['admin.pages.revisions.restore', $revision], 'method' => 'put']) }}
                                <button type="submit" class="button success">Restore</button>
                            {{ Form::close() }}
                            @include('_partials.delete-confirm', [
                                'route' => 'admin.pages.revisions.destroy',
                                'object' => $revision,
                                'label' => 'this page revision',
                                'type' => 'revision'
                            ])
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $revisions->appends(request()->except(['page','_token']))->links() }}
    @else
        @include('_partials.components.no-results', ['label' => 'pages'])
    @endif

@endsection
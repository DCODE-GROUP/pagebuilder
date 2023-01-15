@extends('layouts.admin')

@section('title', 'Edit ' . $menuLocationLabel . ' menu for ' . $site->name)

@section('content')

    <h1>Editing {{ $menuLocationLabel }} location menu</h1>
    <h4>{{ $site->name }}</h4>

    <form method="post">
        @csrf
        <menus :menu="{{ $menu ?? '[]' }}" :resources="{{ $resources }}"></menus>
    </form>

@endsection

@extends('layouts.admin')
@section('title', 'Menus')

@section('content')

<div>
    <h2>ACN menu locations</h2>
    <ul class="menu-list">
        @foreach($menuLocations[1] as $location => $details)
            <li>
                <a href="{{ route('admin.menus.edit', [1, $location]) }}">
                    <p>{{ $details['label'] }}</p>
                    <small>{{ $details['description'] }}</small>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div>
    <h2>TCS menu locations</h2>
    <ul class="menu-list">
        @foreach($menuLocations[2] as $location => $details)
            <li>
                <a href="{{ route('admin.menus.edit', [2, $location]) }}">
                    <p>{{ $details['label'] }}</p>
                    <small>{{ $details['description'] }}</small>
                </a>
            </li>
        @endforeach
    </ul>
</div>

@endsection

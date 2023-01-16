<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="@yield('description')"/>
    <meta name="keywords" content="@yield('keywords')"/>
    <meta name="twitter:card" value="@yield('description')">

    <meta property="og:description" content="@yield('description')"/>
    <meta property="og:image" content="#" />
</head>
<body>
<div>
    @if(isset($header) && $header->isNotEmpty())
        {{ $header }}
    @endif

    <main class="{{ $pageClass ?? null }}">
        {{ $slot }}
    </main>
</div>

</body>
</html>

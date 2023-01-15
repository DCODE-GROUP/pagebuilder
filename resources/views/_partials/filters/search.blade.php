<form method="GET">
    @csrf
    <div class="grid-x filter search">
        <div class="cell medium-2">
            <input type="text" name="search" id="search" placeholder="Search..." value="{{ request('search') ?? old('search') ?? null }}">
        </div>
        <div class="cell medium-6">
            <input type="submit" class="button" value="Search">
            @if (request()->has('search'))
                <a href="{{ request()->url() }}" class="button secondary">Clear</a>
            @endif
            {{ $slot ?? '' }}
        </div>
    </div>
</form>


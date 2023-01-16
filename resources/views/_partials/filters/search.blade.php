<form method="GET">
    @csrf
    <div class="flex items-center">
        <input type="text" name="search" id="search" placeholder="Search..." value="{{ request('search') ?? old('search') ?? null }}">
        <div class="flex items-center ">
            <button type="submit" class="button" value="Search" class="btn btn-primary">
                @if (request()->has('search'))
                <a href="{{ request()->url() }}" class="ml-2">Clear</a>
                @endif
                {{ $slot ?? '' }}
        </div>
    </div>
</form>
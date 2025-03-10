<flux:table.row data-id="{{ $item->id }}">
    <flux:table.cell><x-manta.tables.image :item="$item->image" /></flux:table.cell>
    <flux:table.cell>
        {{ Carbon\Carbon::parse($item->from)->format('d-m-Y H:i') }}
    </flux:table.cell>
    <flux:table.cell>{{ Carbon\Carbon::parse($item->till)->format('d-m-Y H:i') }}</flux:table.cell>
    <flux:table.cell>
        @if (Illuminate\Support\Facades\Route::has('website.agenda'))
            <a href="{{ route('website.agenda', ['slug' => $item->slug]) }}" target="_blank">
                {{ $item->title }} <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        @else
            {{ $item->title }}
        @endif
    </flux:table.cell>
    <flux:table.cell>{{ $item->slug }}</flux:table.cell>
    <flux:table.cell>{{ count($item->images) }}</flux:table.cell>
    <x-manta::flux.manta-flux-delete :$item :$route_name :$moduleClass maps uploads />
</flux:table.row>

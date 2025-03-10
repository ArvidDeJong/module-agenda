<flux:main container>
    <x-manta.breadcrumb :$breadcrumb />
    <x-manta.tabs :$tablist :$tablistShow />
    <form wire:submit="save">
        <h4 class="mb-4 text-lg font-semibold text-gray-800">Geografische gegevens</h4>
        <x-manta::forms.input title="Latitude" name="DEFAULT_LATITUDE" step="0.000000000001" />
        <x-manta::forms.input title="Longitude" name="DEFAULT_LONGITUDE" step="0.000000000001" />
        <x-manta::forms.input title="Adres" name="address" />
        @include('manta::includes.form_error')
        <x-manta::forms.buttons href="{{ route('agenda.list') }}">
            <button type="button" wire:click="getByAddress"
                class="inline-flex items-center justify-center rounded-md bg-yellow-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-offset-2 disabled:opacity-50"><i
                    class="fa-solid fa-map-location-dot"></i> &nbsp;Zoek adres</button>
            </x-cms.forms.buttons>
            <div id="map" class="mt-5 w-full bg-gray-200" style="height:400px;" wire:ignore></div>
    </form>
    @push('scripts')
        @include('manta::includes.google_maps_js_load')
        @include('manta::includes.google_maps_js_set')
    @endpush
</flux:main>

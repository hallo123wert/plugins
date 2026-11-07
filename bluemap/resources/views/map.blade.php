<x-filament-panels::page>
    @if (! $this->hasAllocation())
        <x-filament::section :heading="trans('bluemap::strings.no_allocation_title')">
            {{ trans('bluemap::strings.no_allocation', ['port' => $this->getBlueMapPort()]) }}
        </x-filament::section>
    @else
        <iframe
            src="{{ $this->getMapUrl() }}"
            title="BlueMap"
            loading="lazy"
            referrerpolicy="no-referrer"
            style="width: 100%; height: 78vh; border: 0; border-radius: 0.5rem;"
        ></iframe>
    @endif
</x-filament-panels::page>

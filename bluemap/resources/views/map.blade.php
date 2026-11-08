<x-filament-panels::page>
    <div wire:poll.15s="refreshServerStatus">
        @if (! $isServerRunning)
            <x-filament::section :heading="trans('bluemap::strings.offline_title')">
                {{ trans('bluemap::strings.offline') }}
            </x-filament::section>
        @else
            @php($url = $this->getMapUrl())

            @if ($url === null)
                <x-filament::section :heading="trans('bluemap::strings.no_allocation_title')">
                    {{ trans('bluemap::strings.no_allocation', ['port' => $this->getBlueMapPort()]) }}
                </x-filament::section>
            @else
                <iframe
                    src="{{ $url }}"
                    title="BlueMap"
                    loading="lazy"
                    referrerpolicy="no-referrer"
                    style="width: 100%; height: 78vh; border: 0; border-radius: 0.5rem;"
                ></iframe>
            @endif
        @endif
    </div>
</x-filament-panels::page>

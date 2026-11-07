<?php

namespace Hallo123wert\BlueMap\Filament\Server\Pages;

use App\Models\Server;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Hallo123wert\BlueMap\Services\BlueMapPortResolver;

class BlueMapPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'tabler-map';

    protected static ?string $slug = 'bluemap';

    protected string $view = 'bluemap::map';

    public static function getNavigationLabel(): string
    {
        return trans('bluemap::strings.navigation');
    }

    public function getTitle(): string
    {
        return trans('bluemap::strings.title');
    }

    public function getBlueMapPort(): int
    {
        $server = Filament::getTenant();

        return $server instanceof Server
            ? app(BlueMapPortResolver::class)->getPort($server)
            : BlueMapPortResolver::DEFAULT_PORT;
    }

    public function hasAllocation(): bool
    {
        $server = Filament::getTenant();

        return $server instanceof Server
            && app(BlueMapPortResolver::class)->getAllocation($server) !== null;
    }

    public function getMapUrl(): string
    {
        $server = Filament::getTenant();

        $base = $server instanceof Server
            ? route('bluemap.proxy', ['uuid' => $server->uuid])
            : '';

        return rtrim($base, '/').'/';
    }
}

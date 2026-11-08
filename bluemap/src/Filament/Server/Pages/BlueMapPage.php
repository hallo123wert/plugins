<?php

namespace Hallo123wert\BlueMap\Filament\Server\Pages;

use App\Enums\ContainerStatus;
use App\Models\Server;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Hallo123wert\BlueMap\Services\BlueMapPortResolver;

class BlueMapPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'tabler-map';

    protected static ?string $slug = 'bluemap';

    protected string $view = 'bluemap::map';

    protected static ?int $navigationSort = 31;

    public bool $isServerRunning = false;

    public function mount(): void
    {
        $this->refreshServerStatus();
    }

    private function getServer(): ?Server
    {
        $server = Filament::getTenant();

        return $server instanceof Server ? $server : null;
    }

    private function checkServerStatus(): bool
    {
        $server = $this->getServer();

        return $server !== null
            && $server->retrieveStatus() === ContainerStatus::Running;
    }

    public function refreshServerStatus(): void
    {
        $this->isServerRunning = $this->checkServerStatus();
    }

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
        $server = $this->getServer();

        return $server !== null
            ? app(BlueMapPortResolver::class)->getPort($server)
            : BlueMapPortResolver::DEFAULT_PORT;
    }

    public function getMapUrl(): ?string
    {
        $server = $this->getServer();

        if ($server === null) {
            return null;
        }

        $allocation = app(BlueMapPortResolver::class)->getAllocation($server);

        if ($allocation === null) {
            return null;
        }

        if (request()->isSecure()) {
            return rtrim(route('bluemap.proxy', ['uuid' => $server->uuid]), '/').'/';
        }

        $host = config('bluemap.use_alias') && $allocation->ip_alias
            ? $allocation->ip_alias
            : $allocation->ip;

        return "http://{$host}:{$allocation->port}/";
    }
}

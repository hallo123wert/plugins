<?php

namespace Hallo123wert\BlueMap\Services;

use App\Models\Allocation;
use App\Models\Server;
use App\Repositories\Daemon\DaemonFileRepository;
use Illuminate\Support\Facades\Cache;
use Throwable;

class BlueMapPortResolver
{
    public const DEFAULT_PORT = 8100;

    /** @var array<int, string> */
    private const CONFIG_PATHS = [
        'plugins/BlueMap/webserver.conf',
        'config/bluemap/webserver.conf',
    ];

    public function __construct(private readonly DaemonFileRepository $files) {}

    public function getPort(Server $server): int
    {
        return Cache::remember(
            "bluemap.port.{$server->uuid}",
            60,
            fn () => $this->readPort($server) ?? self::DEFAULT_PORT
        );
    }

    public function getAllocation(Server $server): ?Allocation
    {
        return $server->allocations->firstWhere('port', $this->getPort($server));
    }

    private function readPort(Server $server): ?int
    {
        foreach (self::CONFIG_PATHS as $path) {
            try {
                $content = $this->files->setServer($server)->getContent($path);
            } catch (Throwable) {
                continue;
            }

            return $this->parsePort($content) ?? self::DEFAULT_PORT;
        }

        return null;
    }

    private function parsePort(string $content): ?int
    {
        if (preg_match('/^\s*port\s*:\s*(\d+)/m', $content, $matches) === 1) {
            return (int) $matches[1];
        }

        return null;
    }
}

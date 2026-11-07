<?php

namespace Hallo123wert\BlueMap\Http\Controllers;

use App\Models\Server;
use Hallo123wert\BlueMap\Services\BlueMapPortResolver;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class BlueMapProxyController
{
    /** @var array<int, string> */
    private const FORWARDED_RESPONSE_HEADERS = [
        'Content-Type',
        'Content-Encoding',
        'Cache-Control',
        'ETag',
        'Last-Modified',
    ];

    public function __invoke(Request $request, BlueMapPortResolver $resolver, string $uuid, string $path = ''): Response
    {
        $server = Server::query()->where('uuid', $uuid)->firstOrFail();

        abort_unless(user()?->canAccessTenant($server), 403);
        abort_if(str_contains($path, '..') || str_contains($path, '\\'), 400);

        $allocation = $resolver->getAllocation($server);

        abort_if($allocation === null, 404);

        $host = config('bluemap.use_alias') && $allocation->ip_alias
            ? $allocation->ip_alias
            : $allocation->ip;

        $url = "http://{$host}:{$allocation->port}/{$this->encodePath($path)}";

        if ($query = $request->getQueryString()) {
            $url .= "?{$query}";
        }

        $requestHeaders = array_filter([
            'Accept-Encoding' => $request->header('Accept-Encoding'),
            'If-None-Match' => $request->header('If-None-Match'),
            'If-Modified-Since' => $request->header('If-Modified-Since'),
        ]);

        try {
            $upstream = Http::timeout(30)
                ->withoutRedirecting()
                ->withOptions(['decode_content' => false])
                ->withHeaders($requestHeaders)
                ->get($url);
        } catch (ConnectionException) {
            abort(502, trans('bluemap::strings.unreachable'));
        }

        $headers = [];

        foreach (self::FORWARDED_RESPONSE_HEADERS as $name) {
            if ($upstream->hasHeader($name)) {
                $headers[$name] = $upstream->header($name);
            }
        }

        return response($upstream->body(), $upstream->status(), $headers);
    }

    private function encodePath(string $path): string
    {
        return implode('/', array_map('rawurlencode', explode('/', ltrim($path, '/'))));
    }
}

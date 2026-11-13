<?php

namespace Hallo123wert\StarryNight;

use App\Contracts\Plugins\HasTheme;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\File;

class StarryNightPlugin implements HasTheme, Plugin
{
    public function getId(): string
    {
        return 'starrynight';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}

    public function getThemeColors(): array
    {
        return [
            'danger' => Color::Rose,
            'gray' => Color::Slate,
            'info' => Color::Pink,
            'primary' => Color::Purple,
            'success' => Color::Emerald,
            'warning' => Color::Amber,
        ];
    }

    public function getThemeFont(): ?string
    {
        return null;
    }

    public function getThemeViteEntry(): ?string
    {
        return null;
    }

    public function getThemeRenderHooks(): array
    {
        return [
            PanelsRenderHook::HEAD_END => fn (): string => '<style id="starrynight-css">' . $this->read('resources/css/starry-night.css') . '</style>',

            PanelsRenderHook::BODY_START => fn (): string => '<section class="starrynight-meteors">'
                . str_repeat('<span></span>', 10)
                . '</section>'
                . '<div id="starrynight-stars"></div>'
                . '<script>' . $this->read('resources/js/starry-night.js') . '</script>',
        ];
    }

    private function read(string $relativePath): string
    {
        $file = plugin_path($this->getId(), $relativePath);

        return File::exists($file) ? File::get($file) : '';
    }
}

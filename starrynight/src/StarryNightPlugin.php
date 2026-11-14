<?php

namespace Hallo123wert\StarryNight;

use App\Contracts\Plugins\HasTheme;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;

class StarryNightPlugin implements HasTheme
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

    public function getThemeViteEntry(): string|array|null
    {
        return [
            'plugins/starrynight/resources/css/starry-night.css',
            'plugins/starrynight/resources/js/starry-night.js',
        ];
    }

    public function getThemeRenderHooks(): array
    {
        return [
            PanelsRenderHook::BODY_START => fn (): string => '<section class="starrynight-meteors">'
                . str_repeat('<span></span>', 10)
                . '</section>'
                . '<div id="starrynight-stars"></div>',
        ];
    }
}

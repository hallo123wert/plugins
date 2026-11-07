<?php

namespace Hallo123wert\StarryNight;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\File;

class StarryNightPlugin implements Plugin
{
    public function getId(): string
    {
        return 'starrynight';
    }

    public function register(Panel $panel): void
    {
        $panel->colors([
            'danger' => Color::Rose,
            'gray' => Color::Slate,
            'info' => Color::Pink,
            'primary' => Color::Purple,
            'success' => Color::Emerald,
            'warning' => Color::Amber,
        ]);

        $panel->renderHook(PanelsRenderHook::HEAD_END, function (): string {
            $css = $this->read('resources/css/starry-night.css');

            return '<style id="starrynight-css">' . $css . '</style>';
        });

        $panel->renderHook(PanelsRenderHook::BODY_START, function (): string {
            $js = $this->read('resources/js/starry-night.js');

            return '<section class="starrynight-meteors">'
                . str_repeat('<span></span>', 10)
                . '</section>'
                . '<div id="starrynight-stars"></div>'
                . '<script>' . $js . '</script>';
        });
    }

    public function boot(Panel $panel): void {}

    private function read(string $relativePath): string
    {
        $file = plugin_path($this->getId(), $relativePath);

        return File::exists($file) ? File::get($file) : '';
    }
}

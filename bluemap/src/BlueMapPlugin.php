<?php

namespace Hallo123wert\BlueMap;

use App\Contracts\Plugins\HasPluginSettings;
use App\Traits\EnvironmentWriterTrait;
use Filament\Contracts\Plugin;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Panel;

class BlueMapPlugin implements HasPluginSettings, Plugin
{
    use EnvironmentWriterTrait;

    public function getId(): string
    {
        return 'bluemap';
    }

    public function register(Panel $panel): void
    {
        $panel->discoverPages(plugin_path($this->getId(), 'src/Filament/Server/Pages'),'Hallo123wert\\BlueMap\\Filament\\Server\\Pages');
    }

    public function boot(Panel $panel): void {}

    public function getSettingsFormData(): array
    {
        return config('bluemap');
    }

    public function getSettingsForm(): array
    {
        return [
            Toggle::make('use_alias')
                ->label(trans('bluemap::strings.use_alias'))
                ->hintIcon('tabler-question-mark')
                ->hintIconTooltip(trans('bluemap::strings.use_alias_hint'))
                ->inline(false)
                ->default(fn () => config('bluemap.use_alias')),
        ];
    }

    public function saveSettings(array $data): void
    {
        $this->writeToEnvironment([
            'BLUEMAP_USE_ALIAS' => $data['use_alias'],
        ]);

        Notification::make()
            ->title(trans('bluemap::strings.notifications.settings_saved'))
            ->success()
            ->send();
    }
}

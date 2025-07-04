<?php

namespace NhanChauKP\FilamentCopyActions;

use Filament\Contracts\Plugin;
use Filament\Panel;
use NhanChauKP\FilamentCopyActions\Forms\Actions\CopyAction;

class FilamentCopyActionsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-copyactions';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        CopyAction::configureUsing(fn (CopyAction $action) => $action->copyable(fn ($component, $record) => $component->getState()));
    }
}

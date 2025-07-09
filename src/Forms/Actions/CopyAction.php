<?php

namespace NhanChauKP\FilamentCopyActions\Forms\Actions;

use Filament\Actions\Action as BaseAction;
use Illuminate\Support\Js;
use NhanChauKP\FilamentCopyActions\Concerns\HasCopyable;

class CopyAction extends BaseAction
{
    use HasCopyable {
        HasCopyable::getCopyable as getDefaultCopyable;
    }

    public function getCopyable(): ?string
    {
        if ($this->copyable === null) {
            return Js::from($this->evaluate(fn ($state) => $state));
        }

        return $this->getDefaultCopyable();
    }
}

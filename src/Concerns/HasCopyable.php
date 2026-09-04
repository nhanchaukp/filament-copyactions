<?php

namespace NhanChauKP\FilamentCopyActions\Concerns;

use Closure;
use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;
use JsonException;

trait HasCopyable
{
    use CanCustomizeProcess;

    protected Closure|string|null $copyable = null;

    public static function getDefaultName(): ?string
    {
        return 'copy';
    }

    /**
     * @throws JsonException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this
            ->dispatch('FilamentCopyActions')
            ->successNotificationTitle(__('Copied!'))
            ->failureNotificationTitle(__('Failed to copy!'))
            ->icon('heroicon-o-clipboard-document')
            ->extraAttributes(fn (Action $action) => [
                '@click' => new HtmlString(
                    'window.navigator.clipboard.writeText('.$action->getCopyable().')
                                    .then(() => {
                                    '.(($title = $this->getSuccessNotificationTitle()) ? ' $tooltip('.Js::from($title).', {theme: $store.theme});' : '').'
                                    })
                                    .catch(() => {
                                    '.(($title = $this->getFailureNotificationTitle()) ? ' $tooltip('.Js::from($title).', {theme: $store.theme});' : '').'
                                    });'
                ),
            ], merge: true);

    }

    public function action(Closure|string|null $action): static
    {
        $this->dispatch(null);

        return parent::action($action);
    }

    public function copyable(array|Closure|string $copyable): self
    {
        $this->copyable = $copyable;

        return $this;
    }

    /**
     * @throws JsonException
     */
    public function getCopyable(): ?string
    {
        return Js::from($this->evaluate($this->copyable));
    }
}

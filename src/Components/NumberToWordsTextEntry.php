<?php
namespace NumberToWord\NumberToWords\Components;

use Filament\Infolists\Components\Component;
use Filament\Support\Concerns;
use Filament\Support\Concerns\HasHeading;
use NumberToWord\NumberToWords\Traits\FilamentNumberToWords;

class NumberToWordsTextEntry extends Component
{
    use FilamentNumberToWords;    
    use Concerns\HasExtraAlpineAttributes;
    use HasHeading;

    protected string $view = 'numbertowords::components.infolists.entries.number-to-words-text-entry';

    protected bool $grouped = false;

    protected bool $list = false;

    final public function __construct(?string $label = null)
    {
        $this->label($label);
    }

    public static function make(?string $label = null): static
    {
        $static = app(static::class, ['label' => $label]);
        $static->configure();

        return $static;
    }
}
<?php
namespace NumberToWord\NumberToWords\Actions;

use Filament\Forms\Components\TextInput;
use NumberToWord\NumberToWords\Traits\FilamentWordsToNumbers;

class WordsToNumbersInput extends TextInput
{
    use FilamentWordsToNumbers;

    protected string $lang = 'en';

    public static function make(string $name): static
    {
        $input = parent::make($name);

        $input->lang(config('numbertowords.lang', 'en'));

        $input->formatStateUsing(function ($state) use ($input) {
            return static::wordsToNumbers($state, $input->lang);
        });

        return $input;
    }

    public function lang(string $lang = null): static
    {
        $this->lang = $lang ?? config('numbertowords.lang');

        return $this;
    }
}
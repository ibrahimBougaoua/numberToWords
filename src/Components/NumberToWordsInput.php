<?php

namespace NumberToWord\NumberToWords\Components;

use Filament\Forms\Components\TextInput;
use NumberToWord\NumberToWords\Traits\FilamentNumberToWords;

class NumberToWordsInput extends TextInput
{
    use FilamentNumberToWords;

    protected string $lang = 'en'; // Default language

    /**
     * Create a new component instance.
     */
    public static function make(string $name): static
    {
        $component = parent::make($name);

        // Add an after state updated callback to convert the number to words
        $component->afterStateUpdated(function ($state, $set, $get) {
            $words = static::numberToWords($state, 'en');
            $set('number_to_words', $words);
        });

        return $component;
    }

    /**
     * Set the language for number to words conversion.
     */
    public function lang(string $lang): static
    {
        $this->lang = $lang;

        return $this;
    }
}

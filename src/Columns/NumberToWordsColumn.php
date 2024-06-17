<?php

namespace NumberToWord\NumberToWords\Columns;

use Filament\Tables\Columns\TextColumn;
use NumberToWord\NumberToWords\Traits\FilamentNumberToWords;

class NumberToWordsColumn extends TextColumn
{
    use FilamentNumberToWords;

    protected string $lang = 'en'; // Default language

    /**
     * Create a new column instance.
     *
     * @param string $name
     * @return static
     */
    public static function make(string $name): static
    {
        $column = parent::make($name);

        // Add a display callback to convert the number to words
        $column->formatStateUsing(function ($state, $record, $column) {
            return static::numberToWords($state, $column->lang);
        });

        return $column;
    }

    /**
     * Set the language for number to words conversion.
     *
     * @param string $lang
     * @return static
     */
    public function lang(string $lang = null): static
    {
        $this->lang = $lang ?? config('numbertowords.lang');

        return $this;
    }
}

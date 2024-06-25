<?php

namespace NumberToWord\NumberToWords\Columns;

use Filament\Tables\Columns\TextColumn;
use NumberToWord\NumberToWords\Traits\FilamentWordsToNumbers;

class WordsToNumbersColumn extends TextColumn
{
    use FilamentWordsToNumbers;

    protected string $lang = 'en';

    public static function make(string $name): static
    {
        $column = parent::make($name);

        $column->formatStateUsing(function ($state, $record, $column) {
            return static::wordsToNumbers($state, $column->lang);
        });

        return $column;
    }

    public function lang(string $lang = null): static
    {
        $this->lang = $lang ?? config('numbertowords.lang');

        return $this;
    }
}

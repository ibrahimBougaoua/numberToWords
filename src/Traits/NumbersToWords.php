<?php
namespace NumberToWord\NumberToWords\Traits;

trait NumbersToWords
{
    public static function numbersToWords($number, $lang = 'en'): string
    {
        if (!is_numeric($number)) {
            return 'Invalid number';
        }

        if ($number == 0) {
            return config("numbertowords.words.zero_{$lang}", 'Zero');
        }

        $isNegative = $number < 0;
        $number = abs($number);

        $integerPart = floor($number);
        $fractionalPart = $number - $integerPart;

        $words = static::convertIntegerPart($integerPart, $lang);

        if ($fractionalPart > 0) {
            $fractionWords = static::convertFractionalPart($fractionalPart, $lang);
            $words .= config("numbertowords.words.and_{$lang}", ' and ') . $fractionWords;
        }

        $negativeWord = config("numbertowords.words.negative_{$lang}", 'Negative ');

        return $isNegative ? $negativeWord . $words : $words;
    }

    protected static function convertIntegerPart($number, $lang): string
    {
        $words = '';
        $index = 0;

        while ($number > 0) {
            $remainder = $number % 1000;
            if ($remainder > 0) {
                $words = static::convertThreeDigitNumber($remainder, $lang) . ' ' . static::getThousands($lang)[$index] . ' ' . $words;
            }
            $number = floor($number / 1000);
            $index++;
        }

        return trim($words);
    }

    protected static function convertFractionalPart($fraction, $lang): string
    {
        $fractionDigits = substr(strrchr($fraction, '.'), 1);
        return static::convertIntegerPart($fractionDigits, $lang) . config("numbertowords.words.cents_{$lang}", ' Cents');
    }

    protected static function convertThreeDigitNumber($number, $lang): string
    {
        $hundreds = floor($number / 100);
        $remainder = $number % 100;
        $words = '';

        if ($hundreds > 0) {
            $words .= static::getUnits($lang)[$hundreds] . config("numbertowords.words.hundred_{$lang}", ' Hundred ');
        }

        if ($remainder > 0) {
            if ($remainder < 10) {
                $words .= static::getUnits($lang)[$remainder];
            } elseif ($remainder < 20) {
                $words .= static::getTeens($lang)[$remainder - 10];
            } else {
                $tens = floor($remainder / 10);
                $units = $remainder % 10;
                $words .= static::getTens($lang)[$tens];
                if ($units > 0) {
                    $words .= config("numbertowords.words.and_{$lang}", '-') . static::getUnits($lang)[$units];
                }
            }
        }

        return trim($words);
    }

    protected static function getUnits($lang)
    {
        return config('numbertowords.words.units_' . $lang);
    }

    protected static function getTeens($lang)
    {
        return config('numbertowords.words.teens_' . $lang);
    }

    protected static function getTens($lang)
    {
        return config('numbertowords.words.tens_' . $lang);
    }

    protected static function getThousands($lang)
    {
        return config('numbertowords.words.thousands_' . $lang);
    }
}

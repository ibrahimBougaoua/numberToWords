<?php

namespace NumberToWord\NumberToWords\Traits;

trait WordsToNumbers
{
    public static function wordsToNumbers(string $words, string $lang = 'en')
    {
        $units = array_map('strtolower', config("numbertowords.words.units_{$lang}"));
        $teens = array_map('strtolower', config("numbertowords.words.teens_{$lang}"));
        $tens = array_map('strtolower', config("numbertowords.words.tens_{$lang}"));
        $thousands = array_map('strtolower', config("numbertowords.words.thousands_{$lang}"));
        $zero = strtolower(config("numbertowords.words.zero_{$lang}"));
        $negative = strtolower(config("numbertowords.words.negative_{$lang}"));
        $hundred = strtolower(config("numbertowords.words.hundred_{$lang}"));
        $and = strtolower(config("numbertowords.words.and_{$lang}"));

        $words = strtolower(trim($words));

        if ($words === $zero) {
            return 0;
        }

        $isNegative = false;
        if (strpos($words, $negative) !== false) {
            $isNegative = true;
            $words = str_replace($negative, '', $words);
        }

        $number = 0;
        $current = 0;
        $parts = preg_split('/\s+/', $words);

        foreach ($parts as $part) {
            if (in_array($part, $units)) {
                $current += array_search($part, $units);
            } elseif (in_array($part, $teens)) {
                $current += array_search($part, $teens) + 10;
            } elseif (in_array($part, $tens)) {
                $current += array_search($part, $tens) * 10;
            } elseif ($part === $hundred) {
                $current *= 100;
            } elseif (in_array($part, $thousands)) {
                $thousandIndex = array_search($part, $thousands);
                $number += $current * pow(1000, $thousandIndex);
                $current = 0;
            } elseif ($part === $and) {
                continue;
            }
        }

        $number += $current;

        return $isNegative ? -$number : $number;
    }
}

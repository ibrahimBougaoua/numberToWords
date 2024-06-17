<?php

namespace NumberToWord\NumberToWords\Traits;

trait FilamentNumberToWords
{
    // English words
    protected static $units_en = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];

    protected static $teens_en = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

    protected static $tens_en = ['', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    protected static $thousands_en = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

    // French words
    protected static $units_fr = ['', 'Un', 'Deux', 'Trois', 'Quatre', 'Cinq', 'Six', 'Sept', 'Huit', 'Neuf'];

    protected static $teens_fr = ['Dix', 'Onze', 'Douze', 'Treize', 'Quatorze', 'Quinze', 'Seize', 'Dix-sept', 'Dix-huit', 'Dix-neuf'];

    protected static $tens_fr = ['', 'Dix', 'Vingt', 'Trente', 'Quarante', 'Cinquante', 'Soixante', 'Soixante-dix', 'Quatre-vingts', 'Quatre-vingt-dix'];

    protected static $thousands_fr = ['', 'Mille', 'Million', 'Milliard', 'Billion'];

    // Arabic words
    protected static $units_ar = ['', 'واحد', 'اثنان', 'ثلاثة', 'أربعة', 'خمسة', 'ستة', 'سبعة', 'ثمانية', 'تسعة'];

    protected static $teens_ar = ['عشرة', 'أحد عشر', 'اثنا عشر', 'ثلاثة عشر', 'أربعة عشر', 'خمسة عشر', 'ستة عشر', 'سبعة عشر', 'ثمانية عشر', 'تسعة عشر'];

    protected static $tens_ar = ['', 'عشرة', 'عشرون', 'ثلاثون', 'أربعون', 'خمسون', 'ستون', 'سبعون', 'ثمانون', 'تسعون'];

    protected static $thousands_ar = ['', 'ألف', 'مليون', 'مليار', 'بليون'];

    /**
     * Convert a number to words in the specified language.
     *
     * @param  int|float  $number
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     */
    public static function numberToWords($number, $lang = 'en'): string
    {
        if (! is_numeric($number)) {
            return 'Invalid number';
        }

        if ($number == 0) {
            return match ($lang) {
                'fr' => 'Zéro',
                'ar' => 'صفر',
                default => 'Zero',
            };
        }

        $isNegative = $number < 0;
        $number = abs($number);

        $integerPart = floor($number);
        $fractionalPart = $number - $integerPart;

        $words = static::convertIntegerPart($integerPart, $lang);

        if ($fractionalPart > 0) {
            $fractionWords = static::convertFractionalPart($fractionalPart, $lang);
            $words .= match ($lang) {
                'fr' => ' et '.$fractionWords,
                'ar' => ' و '.$fractionWords,
                default => ' and '.$fractionWords,
            };
        }

        $negativeWord = match ($lang) {
            'fr' => 'Négatif ',
            'ar' => 'سالب ',
            default => 'Negative ',
        };

        return $isNegative ? $negativeWord.$words : $words;
    }

    /**
     * Convert the integer part of the number to words in the specified language.
     *
     * @param  int  $number
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     */
    protected static function convertIntegerPart($number, $lang): string
    {
        $words = '';
        $index = 0;

        while ($number > 0) {
            $remainder = $number % 1000;
            if ($remainder > 0) {
                $words = static::convertThreeDigitNumber($remainder, $lang).' '.static::getThousands($lang)[$index].' '.$words;
            }
            $number = floor($number / 1000);
            $index++;
        }

        return trim($words);
    }

    /**
     * Convert the fractional part of the number to words in the specified language.
     *
     * @param  float  $fraction
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     */
    protected static function convertFractionalPart($fraction, $lang): string
    {
        $fractionDigits = substr(strrchr($fraction, '.'), 1);

        return static::convertIntegerPart($fractionDigits, $lang).match ($lang) {
            'fr' => ' Centimes',
            'ar' => ' قروش',
            default => ' Cents',
        };
    }

    /**
     * Convert a three-digit number to words in the specified language.
     *
     * @param  int  $number
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     */
    protected static function convertThreeDigitNumber($number, $lang): string
    {
        $hundreds = floor($number / 100);
        $remainder = $number % 100;
        $words = '';

        if ($hundreds > 0) {
            $words .= static::getUnits($lang)[$hundreds].match ($lang) {
                'fr' => ' Cent ',
                'ar' => ' مائة ',
                default => ' Hundred ',
            };
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
                    $words .= match ($lang) {
                        'fr' => '-'.static::getUnits($lang)[$units],
                        'ar' => ' و '.static::getUnits($lang)[$units],
                        default => '-'.static::getUnits($lang)[$units],
                    };
                }
            }
        }

        return trim($words);
    }

    /**
     * Get units based on the language.
     *
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     * @return array
     */
    protected static function getUnits($lang)
    {
        return match ($lang) {
            'fr' => static::$units_fr,
            'ar' => static::$units_ar,
            default => static::$units_en,
        };
    }

    /**
     * Get teens based on the language.
     *
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     * @return array
     */
    protected static function getTeens($lang)
    {
        return match ($lang) {
            'fr' => static::$teens_fr,
            'ar' => static::$teens_ar,
            default => static::$teens_en,
        };
    }

    /**
     * Get tens based on the language.
     *
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     * @return array
     */
    protected static function getTens($lang)
    {
        return match ($lang) {
            'fr' => static::$tens_fr,
            'ar' => static::$tens_ar,
            default => static::$tens_en,
        };
    }

    /**
     * Get thousands based on the language.
     *
     * @param  string  $lang  The language code ('en', 'fr', 'ar')
     * @return array
     */
    protected static function getThousands($lang)
    {
        return match ($lang) {
            'fr' => static::$thousands_fr,
            'ar' => static::$thousands_ar,
            default => static::$thousands_en,
        };
    }
}

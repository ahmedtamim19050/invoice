<?php

namespace App\Helpers;

class NumberToWords
{
    private const ONES = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
        'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
        'Seventeen', 'Eighteen', 'Nineteen',
    ];

    private const TENS = [
        '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety',
    ];

    public static function convert(int|float $number): string
    {
        $number = (int) round($number);

        if ($number === 0) {
            return 'Zero';
        }

        if ($number < 0) {
            return 'Minus '.self::convert(abs($number));
        }

        $parts = [];

        if ($number >= 10000000) {
            $crores = intdiv($number, 10000000);
            $parts[] = self::convertHundreds($crores).' Crore';
            $number %= 10000000;
        }

        if ($number >= 100000) {
            $lakhs = intdiv($number, 100000);
            $parts[] = self::convertHundreds($lakhs).' Lakh';
            $number %= 100000;
        }

        if ($number >= 1000) {
            $thousands = intdiv($number, 1000);
            $parts[] = self::convertHundreds($thousands).' Thousand';
            $number %= 1000;
        }

        if ($number > 0) {
            $parts[] = self::convertHundreds($number);
        }

        return implode(' ', array_filter($parts));
    }

    private static function convertHundreds(int $number): string
    {
        $parts = [];

        if ($number >= 100) {
            $parts[] = self::ONES[intdiv($number, 100)].' Hundred';
            $number %= 100;
        }

        if ($number >= 20) {
            $parts[] = self::TENS[intdiv($number, 10)];
            $number %= 10;
        }

        if ($number > 0) {
            $parts[] = self::ONES[$number];
        }

        return implode(' ', array_filter($parts));
    }

    public static function taka(int|float $amount): string
    {
        return self::convert($amount).' Taka Only.';
    }
}

<?php

if (! function_exists('format_taka')) {
    function format_taka(int|float|string $amount): string
    {
        return number_format((float) $amount, 0, '.', ',');
    }
}

if (! function_exists('amount_in_words')) {
    function amount_in_words(int|float|string $amount): string
    {
        return \App\Helpers\NumberToWords::taka($amount);
    }
}

if (! function_exists('watermark_url')) {
    function watermark_url(): string
    {
        return asset('3d-render-hospital-patient-bed-png.webp');
    }
}

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

if (! function_exists('watermark_file')) {
    function watermark_file(): string
    {
        $webp = public_path('3d-render-hospital-patient-bed-png.webp');
        $jpg = public_path('images (1).jpg');

        return file_exists($webp) ? $webp : $jpg;
    }
}

if (! function_exists('watermark_data_uri')) {
    function watermark_data_uri(): ?string
    {
        $path = watermark_file();

        if (! is_readable($path)) {
            return null;
        }

        $mime = mime_content_type($path) ?: 'image/jpeg';

        return 'data:'.$mime.';base64,'.base64_encode(file_get_contents($path));
    }
}

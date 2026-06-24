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

if (! function_exists('file_data_uri')) {
    function file_data_uri(string $path): ?string
    {
        if (! is_readable($path)) {
            return null;
        }

        $mime = mime_content_type($path) ?: 'application/octet-stream';

        return 'data:'.$mime.';base64,'.base64_encode(file_get_contents($path));
    }
}

if (! function_exists('logo_url')) {
    function logo_url(): string
    {
        return asset('logo.png');
    }
}

if (! function_exists('logo_file')) {
    function logo_file(): string
    {
        return public_path('logo.png');
    }
}

if (! function_exists('logo_data_uri')) {
    function logo_data_uri(): ?string
    {
        return file_data_uri(logo_file());
    }
}

if (! function_exists('watermark_url')) {
    function watermark_url(): string
    {
        return asset('placeholder.jpeg');
    }
}

if (! function_exists('watermark_file')) {
    function watermark_file(): string
    {
        $jpeg = public_path('placeholder.jpeg');
        $jpg = public_path('images (1).jpg');

        return file_exists($jpeg) ? $jpeg : $jpg;
    }
}

if (! function_exists('watermark_data_uri')) {
    function watermark_data_uri(): ?string
    {
        return file_data_uri(watermark_file());
    }
}

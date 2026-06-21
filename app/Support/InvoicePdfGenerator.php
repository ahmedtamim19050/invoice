<?php

namespace App\Support;

use Spatie\Browsershot\Browsershot;

class InvoicePdfGenerator
{
    public static function make(string $html): Browsershot
    {
        $browsershot = Browsershot::html($html)
            ->showBackground()
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->waitUntilNetworkIdle()
            ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox']);

        if ($node = self::findBinary('NODE_PATH', [
            'C:\\Program Files\\nodejs\\node.exe',
            'C:\\laragon\\bin\\nodejs\\node-v22\\node.exe',
        ])) {
            $browsershot->setNodeBinary($node);
        }

        if ($npm = self::findBinary('NPM_PATH', ['C:\\Program Files\\nodejs\\npm.cmd', 'C:\\laragon\\bin\\nodejs\\node-v22\\npm.cmd'])) {
            $browsershot->setNpmBinary($npm);
        }

        if ($chrome = self::findBinary('CHROME_PATH', [
            'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
            'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
            'C:\\Program Files\\Microsoft\\Edge\\Application\\msedge.exe',
        ])) {
            $browsershot->setChromePath($chrome);
        }

        return $browsershot;
    }

    private static function findBinary(string $envKey, array $candidates): ?string
    {
        $envValue = env($envKey);

        if ($envValue && file_exists($envValue)) {
            return $envValue;
        }

        foreach ($candidates as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}

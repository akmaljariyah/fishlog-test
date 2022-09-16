<?php

if (!function_exists('static_url')) {
    /**
     * Get a URL for static file requests.
     * 
     * @return string
     */
    function static_url(?string $name = null): string
    {
        return trim(asset($name));
    }
}

if (!function_exists('area_logo_path')) {
    function area_logo_path(string $fileName): string
    {
        return public_path(config('daleman.area_logo_dir') . $fileName);
    }
}

if (!function_exists('area_logo_url')) {
    function area_logo_url(string $fileName): string
    {
        return static_url(config('daleman.area_logo_dir') . $fileName);
    }
}

if (!function_exists('lampiran_kontrak_path')) {
    function lampiran_kontrak_path(string $fileName): string
    {
        return public_path(config('daleman.lampiran_kontrak_dir') . $fileName);
    }
}

if (!function_exists('lampiran_kontrak_url')) {
    function lampiran_kontrak_url(string $fileName): string
    {
        return static_url(config('daleman.lampiran_kontrak_dir') . $fileName);
    }
}

if (!function_exists('should_queue')) {
    /**
     * Check if queue is enabled.
     * 
     * @return bool
     */
    function should_queue() {
        return config('queue.default') != 'sync';
    }
}

if (!function_exists('number_to_roman')) {
    function number_to_roman(int $number): string
    {
        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500,
            'CD' => 400, 'C' => 100, 'XC' => 90,
            'L' => 50, 'XL' => 40, 'X' => 10,
            'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1,
        ];
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}

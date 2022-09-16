<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Throwable;

class FileData implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            [$header,] = explode(';', $value);

            return (bool) preg_match('/data:application\/pdf/i', $header);
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function message()
    {
        return 'Invalid DataURL string.';
    }
}

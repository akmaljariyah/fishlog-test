<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileWriter
{
    public function writeFromBinaryData(string $destination, string $data): void
    {
        file_put_contents($destination, $data);
    }
}

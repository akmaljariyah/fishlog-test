<?php

namespace App\Services;

use App\Models\Area;
use Psr\Log\LoggerInterface;
use Throwable;

class ImageUploadService
{
    private ImageWriter $imageWriter;
    private LoggerInterface $logger;

    public function __construct(ImageWriter $imageWriter, LoggerInterface $logger)
    {
        $this->imageWriter = $imageWriter;
        $this->logger = $logger;
    }

    /**
     * Write an area logo image file with binary data and update the Area with the new logo attribute.
     * 
     * @param string $destination The destination path. Automatically generated if empty.
     */
    public function writeAreaLogo(
        Area $area,
        string $binaryData,
        string $extension,
        string $destination = '',
        bool $cleanUp = true
    ): void {
        try {
            $extension = trim(strtolower($extension), '. ');
            $destination = $destination ?: $this->generateAreaLogoPath($extension);
            $this->imageWriter->writeFromBinaryData($destination, $binaryData);

            if ($cleanUp) {
                $this->deleteAreaLogoFiles($area);
            }

            $area->update(['logo' => basename($destination)]);
        } catch (Throwable $e) {
            $this->logger->error($e);
        }
    }

    /**
     * Generate the absolute path for an area logo image.
     * 
     * @param string $extension The extension of the logo (without dot)
     */
    private function generateAreaLogoPath(string $extension): string
    {
        return area_logo_path(sprintf('%s.%s', sha1(uniqid()), $extension));
    }

    private function deleteAreaLogoFiles(Area $area): void
    {
        if (is_null($area->logo)) {
            return;
        }

        @unlink($area->logo);
    }
}

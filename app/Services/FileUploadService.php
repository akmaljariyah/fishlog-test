<?php

namespace App\Services;

use App\Models\Kontrak;
use Illuminate\Support\Facades\Storage;
use Psr\Log\LoggerInterface;
use Throwable;

class FileUploadService
{
    private FileWriter $fileWriter;
    private LoggerInterface $logger;

    public function __construct(FileWriter $fileWriter, LoggerInterface $logger)
    {
        $this->fileWriter = $fileWriter;
        $this->logger = $logger;
    }

    /**
     * Write a lampiran kontrak file with binary data and update the Kontrak with the new lampiran attribute.
     * 
     * @param string $destination The destination path. Automatically generated if empty.
     */
    public function writeLampiranKontrak(
        Kontrak $kontrak,
        string $binaryData,
        string $extension,
        string $destination = '',
        bool $cleanUp = true
    ): void {
        try {
            $extension = trim(strtolower($extension), '. ');
            $destination = $destination ?: $this->generateLampiranKontrakPath($extension);
            $this->fileWriter->writeFromBinaryData($destination, $binaryData);

            if ($cleanUp) {
                $this->deleteLampiranKontrakFiles($kontrak);
            }

            $kontrak->update(['lampiran' => basename($destination)]);
        } catch (Throwable $e) {
            $this->logger->error($e);
        }
    }

    /**
     * Generate the absolute path for a lampiran kontrak file.
     * 
     * @param string $extension The extension of the file (without dot)
     */
    private function generateLampiranKontrakPath(string $extension): string
    {
        return lampiran_kontrak_path(sprintf('%s.%s', sha1(uniqid()), $extension));
    }

    private function deleteLampiranKontrakFiles(Kontrak $kontrak): void
    {
        if (is_null($kontrak->lampiran)) {
            return;
        }

        @unlink($kontrak->lampiran);
    }

    /**
     * Write a file with binary data and upload to S3 bucket
     * 
     * @param string $destination The destination path. Automatically generated if empty.
     */
    public function writeToS3Bucket(
        string $binaryData,
        string $extension
    ): ?string {
        try {
            $extension = trim(strtolower($extension), '. ');
            $fileName = sprintf('%s.%s', sha1(uniqid()), $extension);

            Storage::disk('s3')->put($fileName, $binaryData, 'public');
            $path = Storage::disk('s3')->url($fileName);

            return $path;
        } catch (Throwable $e) {
            $this->logger->error($e);
        }

        return null;
    }
}

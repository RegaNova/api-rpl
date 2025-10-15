<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Upload an image to storage.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string The stored file path
     */
    public static function uploadImage(UploadedFile $file, string $folder = 'images', string $disk = 'public'): string
    {
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('File upload tidak valid.');
        }

        $folderPath = trim($folder, '/') . '/' . date('Y/m');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Simpan file
        $path = $file->storeAs($folderPath, $filename, $disk);

        return $path; // contoh: images/2025/10/uuid.jpg
    }

    /**
     * Get the public URL of a stored file.
     */
    public static function getUrl(?string $path, string $disk = 'public'): ?string
    {
        return $path ? Storage::disk($disk)->url($path) : null;
    }

    /**
     * Delete file safely from storage.
     */
    public static function deleteFile(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}

<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadHelper
{
    public static function uploadImage(UploadedFile $file, string $folder = 'image'): string
    {
        $folder = $folder . '/' . date('Y/m');
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folder, $filename);
    }

    public static function uploadFile(UploadedFile $file, string $folder = 'files'): string
    {
        $folder = $folder . '/' . date('Y/m');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::random(20) . '.' . $extension;

        // Opsional: batasi hanya file tertentu
        $allowed = ['pdf', 'doc', 'docx'];
        if (!in_array($extension, $allowed)) {
            throw new \Exception("File type '{$extension}' not allowed.");
        }

        return $file->storeAs($folder, $filename);
    }

    public static function deleteFile(?string $path): void
    {
        if (!empty($path) && Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}

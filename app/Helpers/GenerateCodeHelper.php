<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class GenerateCodeHelper
{
    public static function generateCode(string $name): string
    {
        $slug = Str::slug($name, '');
        $length = strlen($slug);

        if ($length < 3) {
            return strtoupper(str_pad($slug, 3, 'X'));
        }

        return strtoupper($slug[0] . $slug[intval($length / 2)] . $slug[$length - 1]);
    }

    public static function generateCodeWithNumber(string $name, string $modelClass, string $column = 'code', int $length = 4): string
    {
        $baseCode = self::generateCode($name);

        $count = $modelClass::query()
            ->where($column, 'like', $baseCode . '%')
            ->count();

        return $baseCode . ($count + 1);
    }

    public static function generateClassNumber(string $name, string $modelClass, string $column = 'class_name'): int
    {
        $count = $modelClass::query()
            ->where($column, $name)
            ->count();

        return $count + 1;
    }

    public static function generateCodeWithPrefix(string $prefix, string $modelClass, string $column): string
    {
        $today = Carbon::now()->format('Ymd'); // 20251003
        $code = $prefix . $today;

        $count = $modelClass::query()
            ->where($column, 'like', $code . '-%')
            ->count();

        $number = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return $code . '-' . $number;
    }

    public static function generateCodeFromName(string $name): string
    {
        // Pisahkan nama berdasarkan spasi
        $words = preg_split('/\s+/', strtoupper(trim($name)));

        $initials = '';
        foreach ($words as $word) {
            if ($word !== '') {
                $initials .= $word[0];
            }
        }

        // Ambil maksimal 2 huruf
        return substr($initials, 0, 2);
    }
}

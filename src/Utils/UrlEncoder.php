<?php

declare(strict_types=1);

namespace App\Utils;

class UrlEncoder
{
    private const ALPHABET_SIZE = 26;
    private const ASCII_OFFSET = 64;

    public static function encodeToShortString(int $id): string
    {
        $result = '';
        while($id != 0) {
           $remainder = ($id - 1) % self::ALPHABET_SIZE;
           $number = round(($id - $remainder) / self::ALPHABET_SIZE);
           $result = chr(self::ASCII_OFFSET + $remainder + 1) . $result;
       }
       return $result;
    }

    public static function decodeToId(string $slug): int
    {
        $result = 0;
        $iteration = 1;
        $slug = strtoupper($slug);
        $length = strlen($string);
        while ($length >= $iteration ) {
            $char = $slug[$length - $iteration];
            $c = ord($char) - self::ASCII_OFFSET;        
            $result += $c * (self::ALPHABET_SIZE ** ($iteration-1));
            $iteration++;
        }
        return $result;
    }

}

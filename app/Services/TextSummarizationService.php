<?php

namespace App\Services;

class TextSummarizationService
{
    /**
     * Summarize text.
     */
    public function summarize(string $text): string
    {
        // Implementasi algoritma meringkas teks di sini
        // Misalnya, kita akan mengembalikan 100 karakter pertama dari teks
        return substr($text, 0, 100);
    }
}

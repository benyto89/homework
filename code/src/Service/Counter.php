<?php

namespace App\Service;

class Counter
{
    public function countReadingTime(string $text, int $minLength = 3, int $wordsPerMin = 200): int
    {
        return (int)ceil($this->countWords($text, $minLength) / $wordsPerMin);
    }

    public function countWords(string $text, int $minLength): int
    {
        $counter = 0;
        $words = str_word_count($text, 1);

        foreach ($words as $word) {
            if (preg_match("/\b\w{{$minLength},}\b/", $word)) {
                $counter++;
            }
        }

        return $counter;
    }
}

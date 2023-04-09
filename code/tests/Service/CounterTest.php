<?php

namespace App\Tests\Service;

use App\Service\Counter;
use PHPUnit\Framework\TestCase;

class CounterTest extends TestCase
{
    private Counter $counter;

    protected function setUp(): void
    {
        $this->counter = new Counter();
    }

    public function testCountReadingTime(): void
    {
        // Test empty text
        $text = '';
        $expectedReadingTime = 0;
        $this->assertEquals($expectedReadingTime, $this->counter->countReadingTime($text));

        // Test text with one word
        $text = 'hello';
        $expectedReadingTime = 1;
        $this->assertEquals($expectedReadingTime, $this->counter->countReadingTime($text));

        // Test text with exactly 200 words
        $text = str_repeat('word ', 200);
        $expectedReadingTime = 1;
        $this->assertEquals($expectedReadingTime, $this->counter->countReadingTime($text));

        // Test text with more than 200 words
        $text = str_repeat('word ', 201);
        $expectedReadingTime = 2;
        $this->assertEquals($expectedReadingTime, $this->counter->countReadingTime($text));
    }

    public function testCountWords(): void
    {
        // Test empty text
        $text = '';
        $minLength = 3;
        $expectedCount = 0;
        $this->assertEquals($expectedCount, $this->counter->countWords($text, $minLength));

        // Test text with only short words
        $text = 'a b c';
        $minLength = 3;
        $expectedCount = 0;
        $this->assertEquals($expectedCount, $this->counter->countWords($text, $minLength));

        // Test text with only long words
        $text = 'hello world this is a long word';
        $minLength = 5;
        $expectedCount = 2;
        $this->assertEquals($expectedCount, $this->counter->countWords($text, $minLength));

        // Test text with a mix of short and long words
        $text = 'the awesome brown dog jumps over the lazy cat';
        $minLength = 4;
        $expectedCount = 5;
        $this->assertEquals($expectedCount, $this->counter->countWords($text, $minLength));
    }
}

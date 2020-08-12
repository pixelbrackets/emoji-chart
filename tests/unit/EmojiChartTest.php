<?php

use Pixelbrackets\EmojiChart\EmojiChart;
use PHPUnit\Framework\TestCase;

class EmojiChartTest extends TestCase
{
    public function testChartsAreNotEmpty()
    {
        $this->assertNotEmpty(EmojiChart::getEmojis());
        $this->assertIsArray(EmojiChart::getEmojis());

        $this->assertNotEmpty(EmojiChart::getCategories());
        $this->assertIsArray(EmojiChart::getCategories());

        $this->assertIsArray(EmojiChart::getEmojisGroupedByCategory());
    }

    public function testGetEmoji()
    {
        $this->assertEmpty(EmojiChart::getEmoji());
        $this->assertNotEmpty(EmojiChart::getEmoji('mahjong tile red dragon'));
        $this->assertEmpty(EmojiChart::getEmoji('does-not-exist-1337'));
        $this->assertContains('1F680', EmojiChart::getEmoji('rocket'));
        $this->assertContains('😀', EmojiChart::getEmoji('grinning face'));
    }
}

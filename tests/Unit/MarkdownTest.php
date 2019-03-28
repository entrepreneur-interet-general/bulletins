<?php

namespace Tests\Unit;

use App\Markdown;
use Tests\TestCase;

class MarkdownTest extends TestCase
{
    public function testParseLine()
    {
        $this->assertEquals(Markdown::parseLine('Hello **world**!'), 'Hello <strong>world</strong>!');
    }

    public function testParseText()
    {
        $this->assertEquals(Markdown::parseText('Hello **world**!'), '<p>Hello <strong>world</strong>!</p>');
    }
}

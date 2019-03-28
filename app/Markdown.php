<?php

namespace App;

use Parsedown;

class Markdown
{
    public static function parseLine($text)
    {
        return (new Parsedown)->line($text);
    }

    public static function parseText($text)
    {
        return (new Parsedown)->text($text);
    }
}

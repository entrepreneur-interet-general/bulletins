<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function testWhyPage()
    {
        $this->get('/why')->assertStatus(200);
    }
}

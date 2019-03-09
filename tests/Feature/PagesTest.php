<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function testAboutPage()
    {
        $this->get(route('about'))->assertStatus(200);
    }
}

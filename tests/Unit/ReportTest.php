<?php

namespace Tests\Unit;

use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReportTest extends TestCase
{
    public function testExample()
    {
        $tests = [
            [Carbon::create(2019, 3, 4), true],
            [Carbon::create(2019, 3, 7), true],
            [Carbon::create(2019, 3, 8, 14, 59), true],
            [Carbon::create(2019, 3, 8, 15), false],
            [Carbon::create(2019, 3, 9), false],
            [Carbon::create(2019, 3, 10), false],
            [Carbon::create(2019, 3, 11), true],
        ];

        foreach ($tests as $test) {
            list($date, $expected) = $test;
            Carbon::setTestNow($date);

            $this->assertEquals($expected, Report::canBeFilled());
        }
    }
}

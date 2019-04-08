<?php

namespace Tests\Unit;

use UnexpectedValueException;
use App\Project;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function testConstructorWrongChannel()
    {
        $this->expectException(UnexpectedValueException::class);
        $project = new Project('The name', $channel = 'foobar', $members = [], 'img.png');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNotifyNoChannel()
    {
        $project = new Project('The name', $channel = null, $members = [], 'img.png');
        $project->notify();
    }
}

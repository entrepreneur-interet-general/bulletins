<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use UnexpectedValueException;

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

    /**
     * @doesNotPerformAssertions
     */
    public function testNotifySlackChannel()
    {
        $project = new Project('The name', $channel = 'slack', $members = [], 'img.png');
        $project->notify();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNotifyEmailChannel()
    {
        $project = new Project('The name', $channel = 'email', $members = [], 'img.png');
        $project->notify();
    }
}

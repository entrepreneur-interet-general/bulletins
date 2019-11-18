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
        factory(Project::class)->make(['channel' => 'foobar']);
    }

    public function testIsActive()
    {
        $project = factory(Project::class)->make();
        $this->assertTrue($project->isActive());

        $project = factory(Project::class)->state('inactive')->make();
        $this->assertFalse($project->isActive());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNotifyNoChannel()
    {
        $project = factory(Project::class)->make();
        $project->notify();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNotifySlackChannel()
    {
        $project = factory(Project::class)->make(['channel' => 'slack']);
        $project->notify();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNotifyEmailChannel()
    {
        $project = factory(Project::class)->make(['channel' => 'email']);
        $project->notify();
    }
}

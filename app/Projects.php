<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

class Projects extends Collection
{
    public static function fromYaml($path)
    {
        $config = collect(Yaml::parse(file_get_contents($path)));

        $projects = $config->map(function ($project) {
            return new Project($project['name'], Arr::get($project, 'notification'), $project['members'], $project['logo']);
        })->sortBy('name');

        return new self($projects);
    }

    public function names()
    {
        return $this->map->name;
    }

    public function add($item)
    {
        if ($this->contains($item->name)) {
            throw new UnexpectedValueException;
        }

        parent::add($item);
    }

    public function filledProjectsFor($week)
    {
        $this->checkIsWeek($week);

        return $this->whereIn('name', Report::where('week_number', $week)->pluck('project'));
    }

    public function unfilledProjectsFor($week)
    {
        $this->checkIsWeek($week);

        return $this->whereNotIn('name', Report::where('week_number', $week)->pluck('project'));
    }

    private function checkIsWeek($week)
    {
        if (! preg_match('/^\d{4}-\d{2}$/', $week)) {
            throw new UnexpectedValueException($week.' is not a valid week.');
        }
    }
}

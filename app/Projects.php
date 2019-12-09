<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

class Projects extends Collection
{
    public static function fromYaml($path)
    {
        if (! file_exists($path)) {
            return new self([]);
        }

        $config = collect(Yaml::parse(file_get_contents($path)));

        $projects = $config->map(function ($project) {
            $attributes = [
                'name' => $project['name'],
                'channel' => Arr::get($project, 'notification'),
                'members' => $project['members'],
                'logoUrl' => $project['logo'],
                'endsOn' => Arr::get($project, 'ends_on'),
            ];

            return new Project($attributes);
        })->sortBy('name');

        return new self($projects);
    }

    public function active()
    {
        return $this->filter->isActive();
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

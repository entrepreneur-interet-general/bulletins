<?php

namespace App;

use UnexpectedValueException;
use Illuminate\Support\Collection;

class Projects extends Collection
{
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

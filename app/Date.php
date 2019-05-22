<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    public $casts = ['date' => 'date'];

    public function scopeForProject($query, $project)
    {
        return $query->where('project', '=', $project);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now())->orderBy('date');
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now())->orderBy('date');
    }
}

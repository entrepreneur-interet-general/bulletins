<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    public function getStartOfWeekAttribute()
    {
        list($year, $week) = explode('-', $this->week_number);
        return now()->setIsoDate($year, $week)->startOfWeek();
    }

    public function getEndOfWeekAttribute()
    {
        return $this->startOfWeek->next(Carbon::FRIDAY);
    }

    public static function canBeFilled()
    {
        $now = now()->timezone(config('app.report_timezone'));
        $dayOfWeek = $now->shortEnglishDayOfWeek;

        if (in_array($dayOfWeek, ['Mon', 'Tue', 'Wed', 'Thu'])) {
            return true;
        }

        if ($dayOfWeek === 'Fri' and $now->hour <= 14) {
            return true;
        }

        return false;
    }

    public static function latestPublishedWeek()
    {
        $startOfWeek = now()->startOfWeek();

        if (self::canBeFilled()) {
            return $startOfWeek->subWeek(1)->format('Y-W');
        }

        return $startOfWeek->format('Y-W');
    }

    public function scopePublished($query)
    {
        return $query->where('week_number', '<=', self::latestPublishedWeek());
    }

    public function projectObject()
    {
        return config('app.projects')->where('name', $this->project)->first();
    }
}

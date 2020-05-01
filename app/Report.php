<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yasumi\Yasumi;

class Report extends Model
{
    protected $guarded = [];
    protected $appends = ['start_of_week', 'end_of_week', 'month'];

    public function getStartOfWeekAttribute()
    {
        [$year, $week] = explode('-', $this->week_number);

        return now()->setIsoDate($year, $week)->startOfWeek();
    }

    public function getEndOfWeekAttribute()
    {
        return $this->startOfWeek->next(Carbon::FRIDAY);
    }

    public function getMonthAttribute()
    {
        return $this->startOfWeek->monthName.' '.$this->startOfWeek->year;
    }

    public static function canBeFilled()
    {
        $now = now(config('app.report_timezone'));
        $target = Carbon::parse('Friday this week 15:05', config('app.report_timezone'));

        return $now < $target;
    }

    public static function latestPublishedWeek()
    {
        $startOfWeek = now()->startOfWeek();

        if (self::canBeFilled()) {
            return $startOfWeek->subWeek(1)->format('Y-W');
        }

        return $startOfWeek->format('Y-W');
    }

    public static function lastWorkingDayOfWeek()
    {
        $now = now(config('app.report_timezone'));
        $candidate = Carbon::parse('Friday this week', config('app.report_timezone'));

        try {
            $country = Yasumi::getProviders()[config('app.report_country_code')];

            return Yasumi::prevWorkingDay($country, $candidate->addDay());
        } catch (\Exception $e) {
            return $candidate;
        }
    }

    public function scopePublished($query)
    {
        return $query->where('week_number', '<=', self::latestPublishedWeek());
    }

    public function scopeForWeek($query, $week)
    {
        return $query->where('week_number', $week);
    }

    public function projectObject()
    {
        return config('app.projects')->where('name', $this->project)->first();
    }
}

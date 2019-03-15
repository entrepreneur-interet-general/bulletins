<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

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

    public function projectObject()
    {
        return config('app.projects')->where('name', $this->project)->first();
    }
}

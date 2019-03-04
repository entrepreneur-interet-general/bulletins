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

        if (in_array($dayOfWeek, ['Mon', 'Tues', 'Wed', 'Thu'])) {
            return true;
        }

        if ($dayOfWeek === 'Fri' and $now->hour <= 14) {
            return true;
        }

        return false;
    }
}

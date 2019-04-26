<?php

use App\Report;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        foreach (config('app.projects')->names() as $name) {
            foreach ($this->weeks() as $week) {
                if ($faker->numberBetween(1, 100) <= 80) {
                    factory(Report::class)->create([
                        'project' => $name,
                        'week_number' => $week,
                    ]);
                }
            }
        }
    }

    private function weeks()
    {
        $thisFriday = new Carbon('friday');
        $weeks = [$thisFriday->format('Y-W')];

        foreach (range(1, 30) as $weekSub) {
            $weeks[] = $thisFriday->copy()->subWeek($weekSub)->format('Y-W');
        }

        return $weeks;
    }
}

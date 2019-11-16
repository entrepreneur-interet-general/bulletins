<?php

use App\Date;
use App\Report;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

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

            for ($i = 0; $i < $faker->numberBetween(3, 10); $i++) {
                factory(Date::class)->create([
                    'project' => $name,
                    'date' => $this->randomDate($faker),
                ]);
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

    private function randomDate($faker)
    {
        return now()->addDays($faker->unique()->numberBetween(-200, 200))->toDateString();
    }
}

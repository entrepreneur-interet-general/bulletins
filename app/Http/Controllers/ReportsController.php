<?php

namespace App\Http\Controllers;

use App\Date;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(Report::canBeFilled(), 403);

        $request->validate([
          'spirit' => ['required', Rule::in(['☹️', '😐', '🙂', '😀'])],
          'project' => ['required', Rule::in(config('app.projects')->names())],
          'priorities' => 'required|max:300',
          'victories' => 'required|max:300',
          'help' => 'max:300',
          'key_date' => [
            'nullable',
            'date',
            'date_format:Y-m-d',
            'required_with:key_date_description',
            'unique:dates,date,null,id,project,'.$request->input('project'),
          ],
          'key_date_description' => 'nullable|max:200|required_with:key_date',
        ]);

        Report::create([
          'project' => $request->input('project'),
          'week_number' => $this->weekNumber(),
          'spirit' => $request->input('spirit'),
          'priorities' => $request->input('priorities'),
          'victories' => $request->input('victories'),
          'help' => $request->input('help'),
        ])->save();

        if ($request->filled('key_date')) {
            Date::create([
            'project' => $request->input('project'),
            'date' => $request->input('key_date'),
            'description' => $request->input('key_date_description'),
          ]);
        }

        return view('success', [
          'week' => $this->week(),
          'gif' => $this->randomGif(),
        ]);
    }

    public function choose()
    {
        abort_if(Report::published()->count() == 0, 404);

        $name = Report::published()->orderBy('project')->first()->project;

        return redirect()->route('reports.index', $name);
    }

    public function index(Request $request, Collection $reports)
    {
        abort_if($reports->count() == 0, 404);

        $currentProject = $request->route()->originalParameter('reports');

        if (! is_null($request->query('signature'))) {
            $projects = collect([$currentProject]);
        } else {
            $projects = Report::published()->select('project')->distinct()->get()->pluck('project');
        }

        return view('reports.index', [
          'reports' => $reports->groupBy->month,
          'currentProject' => $reports->first()->projectObject(),
          'projects' => $projects,
          'shareUrl' => URL::signedRoute('reports.index', $currentProject),
          'downloadUrl' => URL::signedRoute('reports.export', $currentProject),
          'upcomingDates' => Date::forProject($currentProject)->upcoming()->get(),
          'pastDates' => Date::forProject($currentProject)->past()->get(),
        ]);
    }

    public function weekIndex()
    {
        $weekNumbers = Report::published()->latest()->select('week_number')->distinct();

        return view('reports.week_index', [
            'data' => $weekNumbers->get()->groupBy->month,
        ]);
    }

    public function export(Collection $reports)
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $project = $reports->first()->project;
        $filename = $project.'-'.now()->format('Y-m-d').'.csv';

        $callback = function () use ($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys(Report::first()->toArray()));

            foreach ($reports as $report) {
                fputcsv($file, $report->toArray());
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    private function randomGif()
    {
        return (object) collect([
          ['id' => '4Zo41lhzKt6iZ8xff9', 'width' => 480, 'height' => 480],
          ['id' => 'Ztw0p2RGR36E0', 'width' => 480, 'height' => 270],
          ['id' => 'SwImQhtiNA7io', 'width' => 480, 'height' => 297],
          ['id' => 'eYilisUwipOEM', 'width' => 480, 'height' => 348],
          ['id' => 'tQ8uT9t0uK92M', 'width' => 480, 'height' => 270],
        ])->shuffle()->first();
    }
}

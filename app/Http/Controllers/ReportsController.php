<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(Report::canBeFilled(), 403);

        $request->validate([
          'spirit'     => ['required', Rule::in(['☹️', '😐', '🙂', '😀'])],
          'project'    => ['required', Rule::in(config('app.projects')->names())],
          'priorities' => 'required|max:300',
          'victories'  => 'required|max:300',
          'help'       => 'max:300',
        ]);

        Report::create([
          'project'     => $request->input('project'),
          'week_number' => $this->weekNumber(),
          'spirit'  => $request->input('spirit'),
          'priorities'  => $request->input('priorities'),
          'victories'   => $request->input('victories'),
          'help'        => $request->input('help'),
        ])->save();

        return view('success', ['week' => $this->week()]);
    }

    public function choose()
    {
        return redirect()->route('reports.index', config('app.projects')->first()->name);
    }

    public function index(Request $request, Collection $reports)
    {
        abort_if($reports->count() == 0, 404);

        $currentProject = $request->route()->originalParameter('reports');

        if (! is_null($request->query('signature'))) {
            $projects = collect([$currentProject]);
        } else {
            $projects = Report::select('project')->distinct()->get()->pluck('project');
        }

        return view('reports.index', [
          'reports' => $reports,
          'projects' => $projects,
          'shareUrl' => URL::signedRoute('reports.index', $currentProject),
          'downloadUrl' => URL::signedRoute('reports.export', $currentProject),
        ]);
    }

    public function export(Collection $reports)
    {
        $headers = [
            "Content-type" => "text/csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $project = $reports->first()->project;
        $filename = $project."-".now()->format('Y-m-d').'.csv';

        $callback = function() use($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, Schema::getColumnListing('reports'));

            foreach($reports as $report) {
                fputcsv($file, $report->toArray());
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}

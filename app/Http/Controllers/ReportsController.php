<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class ReportsController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(Report::canBeFilled(), 403);

        $request->validate([
          'spirit' => ['required', Rule::in(['☹️', '😐', '🙂', '😀'])],
          'project'    => ['required', Rule::in(config('app.projects'))],
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
        return redirect()->route('reports.index', config('app.projects')[0]);
    }

    public function index(Request $request, Collection $reports)
    {
        abort_if($reports->count() == 0, 404);

        $currentProject = $request->route()->originalParameter('reports');

        if (! is_null($request->query('signature'))) {
          $projects = collect([$currentProject]);
        }
        else {
          $projects = Report::select('project')->distinct()->get()->pluck('project');
        }

        return view('reports.index', [
          'reports' => $reports,
          'projects' => $projects,
          'shareUrl' => URL::signedRoute('reports.index', $currentProject)
        ]);
    }
}

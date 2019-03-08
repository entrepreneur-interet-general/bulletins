<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;

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

    public function index(Collection $reports)
    {
        $projects = Report::select('project')->distinct()->get()->pluck('project');

        return view('reports.index', compact('reports', 'projects'));
    }
}

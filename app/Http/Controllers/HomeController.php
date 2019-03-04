<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'projects' => collect(config('app.projects')),
            'filledProjects' => $this->filledProjects(),
            'week' => $this->week(),
            'canBeFilled' => Report::canBeFilled(),
        ]);
    }

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

    private function week()
    {
        return now()->format('W');
    }

    private function weekNumber()
    {
        return now()->format('Y-W');
    }

    private function filledProjects()
    {
        return Report::where('week_number', $this->weekNumber())->pluck('project');
    }
}

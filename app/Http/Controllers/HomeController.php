<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index()
    {
        $projects = collect(config('app.projects'));
        $filledProjects = $this->filledProjects();
        $week = $this->week();

        return view('index', compact('projects', 'week', 'filledProjects'));
    }

    public function store(Request $request)
    {
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
        return (new Carbon())->format('W');
    }

    private function weekNumber()
    {
        return (new Carbon())->format('Y-W');
    }

    private function filledProjects()
    {
        return Report::where('week_number', $this->weekNumber())->pluck('project');
    }
}

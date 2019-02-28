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
        $projects = $this->projectsToFill();

        $week = $this->weekNumber();

        return view('index', compact('projects', 'week'));
    }

    public function store(Request $request)
    {
        $request->validate([
      'project'    => ['required', Rule::in(config('app.projects'))],
      'priorities' => 'required|max:300',
      'victories'  => 'required|max:300',
      'help'       => 'max:300',
    ]);

        Report::create([
      'project'     => $request->input('project'),
      'week_number' => $this->weekNumber(),
      'priorities'  => $request->input('priorities'),
      'victories'   => $request->input('victories'),
      'help'        => $request->input('help'),
    ])->save();

        return view('success');
    }

    private function projectsToFill()
    {
        $filledProjects = Report::where('week_number', $this->weekNumber())->pluck('project');

        return collect(config('app.projects'))->diff($filledProjects);
    }

    private function weekNumber()
    {
        return (new Carbon())->format('Y-W');
    }
}

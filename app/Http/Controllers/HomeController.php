<?php

namespace App\Http\Controllers;

use App\Report;

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

    private function filledProjects()
    {
        return Report::where('week_number', $this->weekNumber())->pluck('project');
    }
}

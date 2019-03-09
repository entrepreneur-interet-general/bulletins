<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'projects' => $projects = collect(config('app.projects')),
            'filledProjects' => $filledProjects = $this->filledProjects(),
            'allFilled' => $filledProjects->count() === $projects->count(),
            'week' => $this->week(),
            'canBeFilled' => Report::canBeFilled(),
        ]);
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        if ($request->input('password') !== config('app.report_secret')) {
            return back()->with('error', "Le mot de passe n'est pas valide.");
        }

        session(['logged_in' => true]);

        return redirect(route('reports.choose'));
    }

    private function filledProjects()
    {
        return Report::where('week_number', $this->weekNumber())->pluck('project');
    }
}

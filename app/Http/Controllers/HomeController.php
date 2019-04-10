<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'projects' => $projects = config('app.projects'),
            'filledProjects' => $filledProjects = $this->filledProjects(),
            'allFilled' => $filledProjects->count() === $projects->count(),
            'week' => $this->week(),
            'canBeFilled' => Report::canBeFilled(),
        ]);
    }

    public function login()
    {
        return view('login', ['passwordHint' => config('app.reports_password_hint')]);
    }

    public function authenticate(Request $request)
    {
        if ($request->input('password') !== config('app.report_secret')) {
            return back()->with('error', "Le mot de passe n'est pas valide.");
        }

        session(['logged_in' => true]);

        return redirect()->intended(route('reports.choose'));
    }

    private function filledProjects()
    {
        return config('app.projects')->filledProjectsFor($this->weekNumber())->names();
    }
}

<?php

namespace App\Http\Controllers;

use App\Date;
use Illuminate\Http\Request;

class DatesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Date::count() == 0, 404);

        return view('dates.index', [
            'data' => Date::orderBy('date', 'desc')->get()->groupBy->month,
        ]);
    }
}

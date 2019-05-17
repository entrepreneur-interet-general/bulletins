<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class LanguagesController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        if (! in_array($locale, ['en', 'fr'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);

        return redirect()->back();
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Undocumented function
     *
     * @param [type] $locale
     * @return void
     */
    public function setLang($locale)
    {
        return back()->cookie('X-Language', $locale, 60 * 24 * 30 * 12);
    }
}

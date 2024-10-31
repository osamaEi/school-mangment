<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class languageController extends Controller
{
    public function switchLocale($lang)
    {

        if(in_array($lang,['en','ar'])) {
          App::setLocale($lang);
        Session::put('locale', $lang);
    }

    return redirect()->back();


}


}

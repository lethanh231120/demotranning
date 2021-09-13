<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class LanguageController extends Controller
{
    /**
    * Show  the application dashboard to the user
    *
    * @return \Illuminate\View\View
    */
   public function index(Request $request,$locale)
   {
    if($locale){
        Session::put('locale',$locale);
    }
    return redirect()->back();
   }
}

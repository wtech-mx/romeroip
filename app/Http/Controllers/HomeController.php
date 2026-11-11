<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function change(Request $request)
    {
        $request->validate(['lang' => 'required|in:en,es']);
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        $request->user()->setAttribute('preferred_locale', $request->lang)->save();

        return redirect()->back();
    }
}

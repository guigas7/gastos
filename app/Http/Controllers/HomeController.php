<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Month;

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
        return redirect('/centros');
    }

    public function month(Request $request)
    {
        $pieces = explode(" ", $request->month);
        session([
            'month' => Month::where('name', $pieces[0])->first(),
            'year' => $pieces[1],
        ]);
        return back()->withInput();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Month;
use Illuminate\Validation\Rule;
use App\Source;
use App\ExpenseType;
use App\Payment;
use Illuminate\Support\Facades\Storage;



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
        $validatedData = $request->validate([
            'month' => [
                'required',
                Rule::in(Month::all()->pluck('id')->toArray()),
            ],
            'year' => [
                'required',
                Rule::in(yearRange()),
            ],
        ]);

        session([
            'month' => Month::where('id', $validatedData['month'])->first(),
            'year' => $validatedData['year'],
        ]);

        return back()->withInput();
    }
}

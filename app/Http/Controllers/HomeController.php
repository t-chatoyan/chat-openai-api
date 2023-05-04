<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

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
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function customersList()
    {
        $customers = Customer::all();
        return view('customersList',compact('customers'));
    }
}

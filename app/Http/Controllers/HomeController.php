<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaleOrderDetails;
use App\SaleOrder;
use Illuminate\Support\Facades\DB;

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

        $viewer = SaleOrder::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'asc')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('count', 'month_name');
        $labels = $viewer->keys();
        $data = $viewer->values();

        return view('home', compact('labels', 'data'));
    }
}

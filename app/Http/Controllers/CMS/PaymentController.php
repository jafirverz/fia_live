<?php

namespace App\Http\Controllers\CMS;

use App\Invoice;
use App\Payment;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class PaymentController extends Controller
{

    /**
     * BannerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'PAYMENT';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.PAYMENT');
        $payments = Invoice::orderBy('id', 'desc')->get();
        return view("admin.payment.index", compact("payments", "title"));
    }

    public function date_range_search(Request $request)
    {
        //dd($request->all());
        $title = __('constant.PAYMENT');
        $daterange_old = $request->daterange;
        $daterange = str_replace('/', '-', explode('-', $request->daterange));
        $start_date = $daterange[0];
        $end_date = $daterange[1];

        $payments = Invoice::whereBetween('created_at', [$start_date, $end_date])->get();

        return view('admin.payment.index', compact('title', 'payments', 'daterange_old'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }


}

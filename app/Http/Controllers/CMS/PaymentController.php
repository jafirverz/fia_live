<?php

namespace App\Http\Controllers\CMS;

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
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.PAYMENT');
        $payments = Payment::orderBy('id','desc')->get();
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

        $payments = Payment::whereBetween('payments.created_at', [$start_date, $end_date])->select('payments.*')->get();

        return view('admin.payment.index', compact('title', 'payments', 'daterange_old'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');
        //get pages detail
        return view("admin.payment.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $request->validate([
            'payment_id' => 'required|max:255|unique:payments',
			'payment_date' => 'required|date',
			'subscription_date' => 'required|date',
			'renewal_date' => 'required|date',
			'payee_email_id' => 'required | email',
            'payee_name' => 'required|max:255'
        ]);

        $payment = new Payment;
        $payment->payment_id = $request->payment_id;
        $payment->payment_date = $request->payment_date;
		$payment->subscription_date = $request->subscription_date;
		$payment->subscription_status = ($request->subscription_status?$request->subscription_status:0);
		$payment->renewal_date = $request->renewal_date;
		$payment->payee_email_id = $request->payee_email_id;
		$payment->payee_name = $request->payee_name;
        $payment->created_at = Carbon::now()->toDateTimeString();
		$payment->payment_mode = ($request->payment_mode?$request->payment_mode:0);
		$payment->status = ($request->status?$request->status:0);
        $payment->save();
        return redirect(route('payment.index'))->with('success', __('constant.CREATED', ['module' => __('constant.PAYMENT')]));

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');
        $payment = Payment::findorfail($id);
        return view("admin.payment.edit", compact("title", "payment"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $payment = Payment::findorfail($id);
        
		$request->validate([
            'payment_id' => 'required|max:255|unique:payments,payment_id,'.$id,
			'payment_date' => 'required|date',
			'subscription_date' => 'required|date',
			'renewal_date' => 'required|date',
			'payee_email_id' => 'required | email',
            'payee_name' => 'required|max:255'
        ]);


        $payment->payment_id = $request->payment_id;
        $payment->payment_date = $request->payment_date;
		$payment->subscription_date = $request->subscription_date;
		$payment->subscription_status = ($request->subscription_status?$request->subscription_status:0);
		$payment->renewal_date = $request->renewal_date;
		$payment->payee_email_id = $request->payee_email_id;
		$payment->payee_name = $request->payee_name;
		$payment->payment_mode = ($request->payment_mode?$request->payment_mode:0);
		$payment->status = ($request->status?$request->status:0);
        $payment->updated_at = Carbon::now()->toDateTimeString();
        $payment->save();
        return redirect(route('payment.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.PAYMENT')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $payment = Payment::findorfail($id);

        $status = ObjectDelete($payment);
        if ($status) {
            return redirect(route('payment.index'))->with('success', __('constant.REMOVED', ['module' => __('constant.PAYMENT')]));
        } else {
            return redirect(route('payment.index'))->with('error', __('constant.CANNOT_DELETE', ['module' => __('constant.PAYMENT')]));
        }

    }
}

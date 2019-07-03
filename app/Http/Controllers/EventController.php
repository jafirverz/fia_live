<?php

namespace App\Http\Controllers;

use App\Event;
use App\Page;
use App\Banner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Illuminate\Support\Facades\Storage;
class EventController extends Controller
{
    //use DynamicRoute;
    //use GetEmailTemplate;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index(BreadcrumbsManager $breadcrumbs)
    {
        //get page data

		$cur_date=  date('Y-m-d');
        $page=Page::where('pages.slug','events')
            ->where('pages.status', 1)
            ->first();
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banner = Banner::where('page_name', $page->id)->first();

        $title = __('constant.EVENT');
       // $breadcrumbs = $breadcrumbs->generate('front_event_listing');
		$events =Event::all();
        return view('event/index', compact('title', 'events', 'page', 'banners'));
    }
    public function search(BreadcrumbsManager $breadcrumbs, Request $request)
    {

        $page = $this->pageDetail(__('constant.EVENTS_ROUTE'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);

        $title = __('constant.EVENT');
        $breadcrumbs = $breadcrumbs->generate('front_event_listing');
        //dd($request);
        $search_content = $request->search_content;
        if ($search_content != "" && $request->eventtype == "")
            {
			//$events = Event::whereDate('start_date', '>', Carbon::now())->where('title', 'LIKE', '%' . $search_content . '%')->get();

		$events = DB::select("SELECT * FROM events WHERE events.title LIKE '%".$search_content."%' AND (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0  ORDER BY start_date ASC");
			

			}
        else if ($search_content == "" && $request->eventtype != "")
         {
			if($request->eventtype=='all')
			{$events = DB::select("SELECT * FROM events WHERE (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0  ORDER BY start_date ASC");}
			else
			{
			$events = DB::select("SELECT * FROM events WHERE events.type=".$request->eventtype." AND (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0   ORDER BY start_date ASC");
			}
		}
        else
        {
//$events = Event::whereDate('start_date', '>', Carbon::now())->where('title', 'LIKE', '%' . $search_content . '%')->where('type', $request->eventtype)->get();
		$events = DB::select("SELECT * FROM events WHERE events.type=".$request->eventtype." AND events.title LIKE '%".$search_content."%' AND (events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL) AND delete_status=0   ORDER BY start_date ASC");
		}
        //print_r($events);die;

        return view('event/events', compact('title', 'breadcrumbs', 'events', 'page', 'banners'));
    }

	 public function myGuestCart(BreadcrumbsManager $breadcrumbs)
    {

        $breadcrumbs = $breadcrumbs->generate('my_events_cart');
        $orders = Order::join('order_item', 'orders.order_id', '=', 'order_item.order_id')->where('orders.payment_status', 0)->where('orders.type', 'event')->where('orders.id',$_REQUEST['order_id'])->get();

        $page = $this->pageDetail(__('constant.MY_EVENT_CART'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);

        return view('cart.my-guest-cart', compact('title', 'page', 'banners', 'orders','breadcrumbs'));
    }

    public function detail(BreadcrumbsManager $breadcrumbs, $id)
    {

        $page = $this->pageDetail(__('constant.EVENTS_DETAIL_ROUTE'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $title = __('constant.EVENT_DETAIL');

        $breadcrumbs = $breadcrumbs->generate('front_event_listing');
		//$events = Event::whereDate('start_date', '>=', Carbon::now())->where('id', $id)->get();
		$events = DB::select("SELECT events.* FROM events WHERE events.id=".$id." AND ((events.end_date>now() OR events.start_date>now()) OR (start_date IS NULL AND end_date IS NULL)) AND delete_status=0 ");
		if (count($events)==0) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
		$event = $events[0];
		//print_r($event);
        $event_type = \DB::table('event_types')->where('id', $event->type)->get();
        //dd($news);
        return view('event/event-details', compact('title', 'breadcrumbs', 'event', 'event_type', 'page'));
    }


    public function apply_event(BreadcrumbsManager $breadcrumbs)
    {

        //dd($request->all());
        $page = $this->pageDetail(__('constant.EVENTS_APPLY_ROUTE'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $title = __('constant.APP_EVENT');

        $breadcrumbs = $breadcrumbs->generate('front_event_app');
        $event = Event::findorfail($_REQUEST['event_id']);
        $event_type = \DB::table('event_types')->where('id', $event->type)->get();
        //dd($news);
        return view('event/event-apply', compact('title', 'breadcrumbs', 'event', 'event_type', 'page'));
    }

    public function cart(BreadcrumbsManager $breadcrumbs)
    {

        $page = $this->pageDetail(__('constant.EVENT_ATTENDEE_ROUTE'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);

        $title = __('constant.APP_EVENT');

        $breadcrumbs = $breadcrumbs->generate('front_event_attendee');
        $event = Event::findorfail($_GET['event_id']);
        $eventProcess = EventProcess::findorfail($_GET['reg_id']);
        $data = array('event_id' => $_GET['event_id'], 'reg_id' => $_GET['reg_id']);
        $event_type = \DB::table('event_types')->where('id', $event->type)->get();
        //dd($news);

        return view('event/event-cart', compact('title', 'breadcrumbs', 'event', 'eventProcess', 'data', 'page', 'banners'));
    }

    public function check_voucher(Request $request)
    {
        $cur_date=  date('Y-m-d');
		$voucher = \DB::table('vouchers')->where('discount_for', 'Events')->where('discount_code', $request->voucher)->where('start_date', '<=', $cur_date)->where('end_date', '>=', $cur_date)->get();

		$coupon_used = getUsedCoupon($request->voucher);

		echo ($voucher->count() && $coupon_used <$voucher[0]->valid_no_uses) ? 1 : 0;

    }



public function paymentGuest()
    {

        $page = $this->pageDetail('checkout');
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);
		$order = Order::findorfail($_REQUEST['order_id']);
		$product = Session::get('productG');
		//print_r($product);
        return view('payment-guest', compact('title', 'page', 'banners', 'order'));
    }

    public function paymentPost(Request $request)
    {

 $request->validate([
            'payer_name' => 'required|max:255',
			'payer_email' => 'required|email|max:255',
            'card_no' => 'required|min:8|max:16',
            'exp_date' => 'required',
            'cvv2' => 'required|numeric'
        ]);
		$product = Session::get('productG');
        $amount = DB::table('orders')->where('id', $request->order_id)->first()->amount;

        $detail = $request->all();
        $detail['exp_date'] = substr_replace($request->exp_date, '', 2, 1);
        $detail['order_id']= $order_id = $request->order_id;
        $detail['payer_email'] = $request->payer_email;
        $detail['amount'] = $amount;

        if($amount==0)
        {
            $order_confirm = Order::where('id', $request->order_id)->first();
            $order_confirm->payment_status = 1;
            $order_confirm->save();
            session()->forget('product');
            return redirect('thank-you/'.__('constant.EVENT_OFFLINE_THANK_TYPE'));
        }

        $response = RDP($detail);
		//dd($response);
        if ($response['response_code'] == 0) {

        $order_confirm = Order::where('id', $request->order_id)->first();
        $order_confirm->transaction_id = $response['transaction_id'];
        $order_confirm->payment_status = 1;
        $order_confirm->save();

		/*Invoice Start*/
		 $order = DB::table('orders')->join('order_item', 'orders.order_id', '=', 'order_item.order_id')->select("orders.*","order_item.product_id")->where('orders.id', $order_id)->first();
//print_r($order);die;
		$amount = $order->amount;
		$emailTemplate = $this->emailTemplate(__('constant.INVOICE'));

            if ($emailTemplate) {
                $i = 1;
                $sub_total = []; $discount = [];
                //return $emailTemplate;
                $file_single_name = 'invoice/' . date('Y-m-d') . '__' . guid() . '.pdf';
                $file_name = 'public/'.$file_single_name;
                $content = [];
                $content[] = '<table class="table table-bordered"><thead><tr class="table-thead"><th>Sr No</th><th>Type</th><th>Description</th><th>Amount</th></tr></thead><tbody>';
                $event_title = [];

                    $part_total = []; $event = getEventProcess($order->product_id);
                    $event_details = getEvents($event->event_id);

                    $sub_total[] = $part_total[] = round(getFeesEventFeesCategory($event->fees_id), 2);
                    if($event->voucher)
                    {
                        $discount[] = round(getDiscountVoucherCode($event->voucher, round(getFeesEventFeesCategory($event->fees_id), 2), 'Events'), 2);
                    }
                    $attendees = DB::table('event_attendees')->where('reg_id', $event->id)->get();
                    foreach($attendees as $attendee)
                    {
                        $sub_total[] = $part_total[] = round(getFeesEventFeesCategory($attendee->fees, 2));
                        if($attendee->voucher)
                        {
                            $discount[] = round(getDiscountVoucherCode($attendee->voucher, $attendee->fees, 'Events'), 2);
                        }
                        /*$attendees = DB::table('event_attendees')->where('reg_id', $event->id)->get();
                        foreach ($attendees as $attendee) {
                            $sub_total[] = $part_total[] = round(getFeesEventFeesCategory($attendee->fees, 2));
                            if ($attendee->voucher) {
                                $discount[] = round(getDiscountVoucherCode($attendee->voucher, $attendee->fees, 'Events'), 2);
                            }
                        }
                        $content[] = '<tr><td>' . $i . '</td><td>Event</td><td>' . $event_details->title . '</td><td>' . array_sum($part_total) . '</td>';*/
                        $i++;
                    }
                    $content[] = '<tr><td>'.$i.'</td><td>Event</td><td>'.$event_details->title.'</td><td>'. array_sum($part_total) .'</td>';
                    $i++;
                    $event_title[] = $event_details->title;


                    $content[] = '</tr><tr><td>&nbsp;</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td class="text-right">Subtotal</td><td class="text-right">' . array_sum($sub_total) . '</td></tr><tr><td></td><td></td><td class="text-right">Discount</td><td class="text-right">' . array_sum($discount) . '</td></tr><tr><td></td><td></td><td class="text-right">Total</td><td class="thank-text">$' . (array_sum($sub_total) - array_sum($discount)) . '</td></tr></tbody></table>';

                $content = join(' ', $content);

                $logo = "<img src=".public_path('images/logo.png')." />";
                $key = ['{{logo}}','{{date}}', '{{name}}', '{{order_id}}', '{{content}}'];
                $value = [$logo,date('M d, Y'), $request->payer_name, $order->order_id, $content];
                $newContents = replaceStrByValue($key, $value, $emailTemplate->contents);
                //return view('pdf-invoice', compact('newContents'));
                $pdf = PDF::loadView('pdf-invoice', compact('newContents'));
                Storage::put($file_name, $pdf->output());

                $emailTemplate = $this->emailTemplate(__('constant.EVENT_EMAIL_USER_SUCCESS_TEMP_ID'));
                if ($emailTemplate) {

                    $data = [];
                    $e_title = implode('<br/>', $event_title);
                    $data['subject'] = $emailTemplate->subject;
                    $data['email_sender_name'] = setting()->email_sender_name;
                    $data['from_email'] = setting()->from_email;
                    $key = ['{{name}}', '{{event_name}}', '{{attachment}}'];
                    $value = [$request->payer_name, $e_title, url('storage/'.$file_single_name)];
                    $newContents = replaceStrByValue($key, $value, $emailTemplate->contents);
                    $data['contents'] = $newContents;
                   /* try {
						$mail = \Mail::to($request->payer_email)->send(new UserSideMail($data));

                    } catch (Exception $exception) {
                        //dd($exception);
                        return redirect(url('/contact-us'))->with('error', __('constant.OPPS'));
                    }*/
                }
            }


		/*Invoice End*/




		\DB::table('event_processes')->where('id',$product['item'][0])->update(['payment_status' => 'Y']);

		    $attendee_list=get_attendee_list($product['item'][0]);
			$registrant_list=get_registrant_list($product['item'][0]);
			$registrant = EventProcess::findorfail($product['item'][0]);
			$event = Event::findorfail($registrant->event_id);


			$emailTemplate_user = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_USER_TEMP_ID'));
			$key_user = ['{{name}}','{{event_name}}','{{attendee_list}}'];
    		$value_user = [$registrant->a_name,$event->title,$registrant_list];


			$emailTemplate_admin = $this->emailTemplate(__('constant.EVENT_EMAIL_ADMIN_SUCCESS_TEMP_ID'));
			$key_admin = ['{{event_name}}','{{attendee_list}}'];
    		$value_admin = [$event->title,$attendee_list];

			if ($emailTemplate_user) {
			$todayDate = date("Y-m-d");
            $data = [];
            $data['subject']= $emailTemplate_user->subject;
            $data['email_sender_name']= setting()->email_sender_name;
            $data['from_email']= setting()->from_email;

            $newContents = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
            $data['contents']= $newContents;
            }

			if ($emailTemplate_admin) {
			$todayDate = date("Y-m-d");
            $data_admin = [];
            $data_admin['subject']= $emailTemplate_admin->subject;
            $data_admin['email_sender_name']= setting()->email_sender_name;
            $data_admin['from_email']= setting()->from_email;

            $newContents_admin = replaceStrByValue($key_admin, $value_admin, $emailTemplate_admin->contents);
            $data_admin['contents']= $newContents_admin;
            }

		 /*try {
                $mail = \Mail::to(setting()->to_email)->send(new AdminSideMail($data_admin));
				$mail_user = \Mail::to($registrant->email_address)->send(new UserSideMail($data));

            } catch (Exception $exception) {
                //dd($exception);

            }*/

		$attendees=EventAttendee::where('reg_id',$product['item'][0])->get();
			if($attendees->count()>0)
			{
				foreach($attendees as $att)
				{

							$attendee_msg="";
							$attendee_msg.="Name: ".$att->a_name.'<br>';
							$attendee_msg.="Email: ".$att->email_address.'<br>';
							$attendee_msg.="Contact Number: ".$att->telephone.'<br>';

							if($att->church=='Other')
							$attendee_msg .= "Church: " . $att->church_other . '<br>';
							else
							$attendee_msg .= "Church: " . $att->church . '<br>';

							$emailTemplate_attendee = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_USER_TEMP_ID'));
							$key_user = ['{{name}}','{{event_name}}','{{attendee_list}}'];
							$value_user = [$att->a_name,$event->title,$attendee_msg];



							if ($emailTemplate_attendee) {
							$todayDate = date("Y-m-d");
							$data_attendee = [];
							$data_attendee['subject']= $emailTemplate_attendee->subject;
							$data_attendee['email_sender_name']= setting()->email_sender_name;
							$data_attendee['from_email']= setting()->from_email;

							$newContents = replaceStrByValue($key_user, $value_user, $emailTemplate_attendee->contents);
							$data_attendee['contents']= $newContents;
							}

							/*try{
							\Mail::to($att->email_address)->send(new UserSideMail($data_attendee));
							} catch (Exception $exception) {
							dd($exception);
							}*/
				}
			}

		session()->forget('product');
		return redirect('/thank-you/'.__('constant.EVENT_OFFLINE_THANK_TYPE'));
        }else{
		return redirect('/payment-guest?order_id='.$request->order_id);
		}

    }

    public function payment(BreadcrumbsManager $breadcrumbs)
    {
        $page = $this->pageDetail(__('constant.PAYMENT_EVENTS_ROUTE'));
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);
        $title = __('constant.EVENT_PAY');
        $breadcrumbs = $breadcrumbs->generate('front_event_pay');
        $attendees = \DB::table('event_attendees')->whereIn('id', [36])->get();
        $event = \DB::table('events')->where('id', $attendees[0]->event_id)->get();
        $data = array('e_id' => $attendees[0]->event_id, 'a_id' => $attendees[0]->reg_id);
        return view('event/event-pay', compact('breadcrumbs', 'attendees', 'event', 'page', 'banners', 'data'));
    }

    public function payment2(BreadcrumbsManager $breadcrumbs, $e_id, $a_id)
    {

        $event = Event::findorfail($e_id);

		$datas['item'][] = $a_id;
		$value=array();


		if($event->paid_event==0)
		{
		   // dd($request);die;
		    $registrant = EventProcess::findorfail($a_id);
			$attendee_list="";
		    $attendee_list.="Attendee 1".'<br>';
			$attendee_list.="Name: ".$registrant->a_name.'<br>';
			$attendee_list.="Email: ".$registrant->email_address.'<br>';
			$attendee_list.="Contact Number: ".$registrant->telephone.'<br>';
			if($registrant->church=='Other')
		$attendee_list .= "Church: " . $registrant->church_other . '<br>';
		else
        $attendee_list .= "Church: " . $registrant->church . '<br>';

		   \DB::table('event_processes')->where('id',$a_id)->update(['payment_status' => 'Y']);

		    if(Auth::check())
			{
				$student_id = Auth::user()->id;
			}
			else
			{
				 $student_id =0;
			}

			$order_id = guid();
			$type = 'event';

			$amount =0;
			$payment_mode = '';

			$order = new Order;
			$order->order_id = $order_id;
			$order->payment_status = 1;

			$order->student_id = $student_id;
			$order->type = $type;
			$order->amount = $amount;
			$order->payment_mode = $payment_mode;
			$order->save();


			$order_detail = new OrderDetail;
			$order_detail->order_id = $order_id;
			$order_detail->product_id = $a_id;
			$order_detail->save();


			$emailTemplate_user = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_USER_TEMP_ID'));
			$key_user = ['{{name}}','{{event_name}}','{{attendee_list}}'];
    		$value_user = [$registrant->a_name,$event->title,$attendee_list];

			$emailTemplate_admin = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_ADMIN_TEMP_ID'));
			$key_admin = ['{{event_name}}','{{attendee_list}}'];
    		$value_admin = [$event->title,$attendee_list];

			if($emailTemplate_user) {
			$todayDate = date("Y-m-d");
            $data = [];
            $data['subject']= $emailTemplate_user->subject;
            $data['email_sender_name']= setting()->email_sender_name;
            $data['from_email']= setting()->from_email;

            $newContents = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
            $data['contents']= $newContents;
            }

			if($emailTemplate_admin) {
			$todayDate = date("Y-m-d");
            $data_admin = [];
            $data_admin['subject']= $emailTemplate_admin->subject;
            $data_admin['email_sender_name']= setting()->email_sender_name;
            $data_admin['from_email']= setting()->from_email;

            $newContents_admin = replaceStrByValue($key_admin, $value_admin, $emailTemplate_admin->contents);
            $data_admin['contents']= $newContents_admin;
            }

		 /*try{
                $mail = \Mail::to(setting()->to_email)->send(new AdminSideMail($data_admin));
				$mail_user = \Mail::to($registrant->email_address)->send(new UserSideMail($data));
            } catch (Exception $exception) {
                dd($exception);
            }*/
		return redirect('/thank-you/'.__('constant.EVENT_OFFLINE_THANK_TYPE'));
		}

	    if(!isset($request->action))
	    {
			if(Auth::check())
			{
				$student_id = Auth::user()->id;
				$order_check = Order::where('orders.payment_status', 0)->where('orders.type', 'event')->where('orders.student_id', Auth::user()->id)->get();
				$order_count=$order_check->count();

			}
			else
			{
				 $student_id =0;
				 $order_count=0;
			}




			if($order_count>=1)
			{

			$order = Order::where('order_id', $order_check[0]['order_id'])->first();
			$amount =get_actual_price($a_id)-get_used_coupon_discount($a_id);

			$Orders = Order::findorfail($order['id']);
			$Orders->amount = $amount+$order->amount;
			$Orders->discount = get_used_coupon_discount($a_id)+$order->discount;
			$Orders->save();

			$order_detail = new OrderDetail;
			$order_detail->order_id = $order_check[0]['order_id'];
			$order_detail->product_id = $a_id;
			$order_detail->save();

			}
			else
			{

			$order_id = guid();
			$type = 'event';

			if($event->paid_event==1)
			$amount =get_actual_price($a_id)-get_used_coupon_discount($a_id);
			else
			$amount =0;

			$payment_mode = 'online';
			$order = new Order;
			$order->order_id = $order_id;
			$order->student_id = $student_id;
			$order->type = $type;
			$order->amount = $amount;
			$order->discount = get_used_coupon_discount($a_id);
			$order->payment_mode = $payment_mode;
			$order->save();

			$order_detail = new OrderDetail;
			$order_detail->order_id = $order_id;
			$order_detail->product_id = $a_id;
			$order_detail->save();
			}

		if(Auth::check())
        {
			if(Session::has('product') && isset(Session::get('product')['item']))
			{
			$value = Session::get('product');
			$merge=array_merge_recursive($value,$datas);
			//print_r($merge);die;
			Session::put('product', $merge);
			}
			else
			{
			Session::put('product', $datas);
			}
		}
		else
		{

			Session::put('productG', $datas);


		}
	  }


		if(Auth::check())
         return redirect(route('cart.event'))->with('success', __('constant.CREATED', ['module' => __('constant.EVENT_PAY')]));
		else
		 return redirect(route('cart.eventGuest', array('order_id' => $order->id)));
    }

    public function attendee_store(Request $request)
    {
       // dd($request);die;

	   $event = Event::findorfail($request->event_id);
	   if(isset($request->action) && $request->action=='Edit')
	   {

	   for ($i = 0; $i < count($request->a_id); $i++) {
		   if($request->a_id[$i]==0)
		   {
            $eventAttendee = new EventAttendee;
            $eventAttendee->event_id = $request->event_id;
            $eventAttendee->reg_id = $request->reg_id;
            $eventAttendee->a_name = $request->a_name[$i];
            $eventAttendee->telephone = $request->telephone[$i];
            $eventAttendee->church = $request->church[$i];
			$eventAttendee->church_other = isset($request->church_other[$i])?$request->church_other[$i]:"";
            $eventAttendee->email_address = $request->email_address[$i];
            $eventAttendee->occupation = $request->occupation[$i];
            $eventAttendee->voucher = $request->voucher[$i];
            $eventAttendee->fees = $request->fees_category[$i];
            $eventAttendee->created_at = Carbon::now()->toDateTimeString();
            $eventAttendee->save();
			/*$data = array($request->reg_id);
			if(Session::has('event_cart'))
			Session::push('event_cart', $request->reg_id);
			else
			Session::put('event_cart', $data);*/
		   }
		   else
		   {

			$eventAttendee = EventAttendee::findorfail($request->a_id[$i]);
            $eventAttendee->a_name = $request->a_name[$i];
            $eventAttendee->telephone = $request->telephone[$i];
            $eventAttendee->church = $request->church[$i];
			$eventAttendee->church_other = isset($request->church_other[$i])?$request->church_other[$i]:"";
            $eventAttendee->email_address = $request->email_address[$i];
            $eventAttendee->occupation = $request->occupation[$i];
            $eventAttendee->voucher = $request->voucher[$i];
            $eventAttendee->fees = $request->fees_category[$i];
            $eventAttendee->updated_at = Carbon::now()->toDateTimeString();
            $eventAttendee->save();

		   }
        }

			$order = Order::findorfail($_REQUEST['order_id']);

            $amount =get_actual_price($request->reg_id)-get_used_coupon_discount($request->reg_id);

			$order->amount = $amount;
			$order->discount = get_used_coupon_discount($request->reg_id);
			$order->save();


	   }
	   else
	   {

		$registrant = EventProcess::findorfail($request->reg_id);



		$attendee_list="";$registrant_list="";
		    $attendee_list.="Attendee 1".'<br>';
			$registrant_list.="Name: ".$registrant->a_name.'<br>';
			$registrant_list.="Email: ".$registrant->email_address.'<br>';
			$registrant_list.="Contact Number: ".$registrant->telephone.'<br>';

		if($registrant->church=='Other')
		$registrant_list.= "Church: " . $registrant->church_other . '<br>';
		else
        $registrant_list.="Church: " . $registrant->church . '<br>';


        for ($i = 0; $i < count($request->a_name); $i++) {

            $EventAttendee = new EventAttendee;
            $EventAttendee->event_id = $request->event_id;
            $EventAttendee->reg_id = $request->reg_id;
            $EventAttendee->a_name = $request->a_name[$i];
            $EventAttendee->telephone = $request->telephone[$i];
            $EventAttendee->church = $request->church[$i];
			$EventAttendee->church_other = isset($request->church_other[$i])?$request->church_other[$i]:"";
            $EventAttendee->email_address = $request->email_address[$i];
            $EventAttendee->occupation = $request->occupation[$i];
            $EventAttendee->voucher = $request->voucher[$i];

			$attendee_list.=$registrant_list;

			$attendee_list.="<br>Attendee ".($i+2).'<br>';
			$attendee_list.="Name: ".$request->a_name[$i].'<br>';
			$attendee_list.="Email: ".$request->email_address[$i].'<br>';
			$attendee_list.="Contact Number: ".$request->telephone[$i].'<br>';

			if($request->church[$i]=='Other')
		$attendee_list .= "Church: " . $request->church_other[$i] . '<br>';
		else
        $attendee_list .= "Church: " . $request->church[$i] . '<br>';

			if($event->paid_event==1)
            $EventAttendee->fees = $request->fees_category[$i];
            $EventAttendee->created_at = Carbon::now()->toDateTimeString();
            $EventAttendee->save();

        }


		//$product = Session::get('product');


	  			if(Auth::check())
				{
					$student_id = Auth::user()->id;
					$order_check = Order::where('orders.payment_status', 0)->where('orders.type', 'event')->where('orders.student_id', Auth::user()->id)->get();
					$order_count=$order_check->count();

				}
				else
				{
					$student_id =0;
					$order_count=0;

				}

			if($order_count>=1)
			{

			$order = Order::where('order_id', $order_check[0]['order_id'])->first();
			$amount =get_actual_price($request->reg_id)-get_used_coupon_discount($request->reg_id);
			//print_r($order);die;
			$Orders = Order::findorfail($order['id']);
			$Orders->amount = $amount+$order->amount;
			$Orders->discount = get_used_coupon_discount($request->reg_id)+$order->discount;
			$Orders->save();

			$order_detail = new OrderDetail;
			$order_detail->order_id = $order_check[0]['order_id'];
			$order_detail->product_id = $request->reg_id;
			$order_detail->save();

			}
			else
			{
				$order_id = guid();
				$type = 'event';

				if($event->paid_event==1)
				$amount =get_actual_price($request->reg_id)-get_used_coupon_discount($request->reg_id);
				else
				$amount =0;
				$payment_mode = 'online';

				$order = new Order;
				$order->order_id = $order_id;
				if($event->paid_event==0)
				$order->payment_status = 1;
				else
				$order->payment_status = 0;
				$order->student_id = $student_id;
				$order->type = $type;
				$order->amount = $amount;
				$order->discount = get_used_coupon_discount($request->reg_id);
				$order->payment_mode = $payment_mode;
				$order->save();


				$order_detail = new OrderDetail;
				$order_detail->order_id = $order_id;
				$order_detail->product_id = $request->reg_id;
				$order_detail->save();
			}


				if(Auth::check())
				{

					$data['item'][] = $request->reg_id;
					if(Session::has('product') && isset(Session::get('product')['item']))
					{
					$value = Session::get('product');
					$merge=array_merge_recursive($value,$data);
					Session::put('product', $merge);
					}
					else
					{
					Session::put('product', $data);
					}
				}
				else
				{

					$data['item'][] = $request->reg_id;
					Session::put('productG', $data);

				}

	   }


	    if(Auth::check() && $event->paid_event!=0)
		{
        return redirect(route('cart.event'))->with('success', __('constant.CREATED', ['module' => __('constant.EVENT_PAY')]));
		}
		else if($event->paid_event==0)
		{
		   // dd($request);die;
		   \DB::table('event_processes')->where('id',$request->reg_id)->update(['payment_status' => 'Y']);

			$attendees=EventAttendee::where('reg_id',$request->reg_id)->get();
			
			if($attendees->count()>0)
			{
				foreach($attendees as $att)
				{

							$attendee_msg="";
							$attendee_msg.="Name: ".$att->a_name.'<br>';
							$attendee_msg.="Email: ".$att->email_address.'<br>';
							$attendee_msg.="Contact Number: ".$att->telephone.'<br>';

							if($att->church=='Other')
							$attendee_msg .= "Church: " . $att->church_other . '<br>';
							else
							$attendee_msg .= "Church: " . $att->church . '<br>';

							$emailTemplate_attendee = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_USER_TEMP_ID'));
							$key_user = ['{{name}}','{{event_name}}','{{attendee_list}}'];
							$value_user = [$att->a_name,$event->title,$attendee_msg];



							if ($emailTemplate_attendee) {
							$todayDate = date("Y-m-d");
							$data_attendee = [];
							$data_attendee['subject']= $emailTemplate_attendee->subject;
							$data_attendee['email_sender_name']= setting()->email_sender_name;
							$data_attendee['from_email']= setting()->from_email;

							$newContents = replaceStrByValue($key_user, $value_user, $emailTemplate_attendee->contents);
							$data_attendee['contents']= $newContents;
							}

							/*try{
							\Mail::to($att->email_address)->send(new UserSideMail($data_attendee));
							} catch (Exception $exception) {
							dd($exception);
							}*/
				}
			}

			$emailTemplate_user = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_USER_TEMP_ID'));
			$key_user = ['{{name}}','{{event_name}}','{{attendee_list}}'];
    		$value_user = [$registrant->a_name,$event->title,$registrant_list];



			if ($emailTemplate_user) {
			$todayDate = date("Y-m-d");
            $data = [];
            $data['subject']= $emailTemplate_user->subject;
            $data['email_sender_name']= setting()->email_sender_name;
            $data['from_email']= setting()->from_email;

            $newContents = replaceStrByValue($key_user, $value_user, $emailTemplate_user->contents);
            $data['contents']= $newContents;
            }
			$emailTemplate_admin = $this->emailTemplate(__('constant.EVENT_FREE_EMAIL_ADMIN_TEMP_ID'));
			$key_admin = ['{{event_name}}','{{attendee_list}}'];
    		$value_admin = [$event->title,$attendee_list];

			if ($emailTemplate_admin) {
			$todayDate = date("Y-m-d");
            $data_admin = [];
            $data_admin['subject']= $emailTemplate_admin->subject;
            $data_admin['email_sender_name']= setting()->email_sender_name;
            $data_admin['from_email']= setting()->from_email;

            $newContents_admin = replaceStrByValue($key_admin, $value_admin, $emailTemplate_admin->contents);
            $data_admin['contents']= $newContents_admin;
            }

		/* try{
                $mail = \Mail::to(setting()->to_email)->send(new AdminSideMail($data_admin));
				$mail_user = \Mail::to($registrant->email_address)->send(new UserSideMail($data));
            } catch (Exception $exception) {
                dd($exception);
            }*/
		return redirect('/thank-you/'.__('constant.EVENT_OFFLINE_THANK_TYPE'));
		}
		else
		{
		return redirect(route('cart.eventGuest', array('order_id' => $order->id)));
		}

    }

    public function detail_store(Request $request)
    {
        //dd($request);
        $request->validate([
            'event_fees' => 'required'
        ]);
        $data['event_id'] = $request->event_id;
        $data['event_fees'] = $request->event_fees;
        return redirect(route('events.apply', $data));
    }

	 public function guest_review(Request $request)
    {
        $orders = Order::join('order_item', 'orders.order_id', '=', 'order_item.order_id')->where('orders.type', 'event')->where('orders.id',$_REQUEST['order_id'])->get();
        $page = $this->pageDetail('review-cart');
        if (!$page) {
            return redirect(url('/home'))->with('error', __('constant.OPPS'));
        }
        $banners = $this->bannersDetail($page->id);
		//dd($orders);
        return view('event.review-cart', compact('page', 'banners', 'orders'));
    }

    public function event_store(Request $request)
    {
        $request->validate([
            'titie' => 'required|max:255',
            'titie_other' => 'required_if:titie,==,Other|max:255',
            'a_name' => 'required|max:255',
            'telephone' => 'required|min:8|max:10',
            'church' => 'required|max:255',
            //'email_address' => 'required|email|unique:event_processes,email_address,NULL,id,payment_status,Y,event_id,'.$request->event_id,
            'email_address' => 'required|email|max:255',
			'occupation' => 'required|max:255',
			'occupation_other' => 'requiredIf:occupation,==,Other',
            'industry' => 'required|max:255',
			'industry_other' => 'requiredIf:industry,==,Other',
			'hear_about' => 'required|max:255',
			'hear_about_other' => 'requiredIf:hear_about,==,Other'
        ]);


        $user = Auth::user();
        $eventProcess = new EventProcess;
        $eventProcess->titie = $request->titie;
        $eventProcess->titie_other = ($request->titie_other ? $request->titie_other : '');
        $eventProcess->event_id = $request->event_id;
        $eventProcess->fees_id = $request->event_fees;
        $eventProcess->student_id = isset($user->id) ? $user->student_id : "";
        $eventProcess->a_name = $request->a_name;
        $eventProcess->telephone = $request->telephone;
        $eventProcess->church = $request->church;
        $eventProcess->church_other = ($request->church_other ? $request->church_other : '');
        $eventProcess->email_address = $request->email_address;
        $eventProcess->occupation = $request->occupation;
        $eventProcess->occupation_other = ($request->occupation_other ? $request->occupation_other : '');

        $eventProcess->industry = $request->industry;
        $eventProcess->industry_other = ($request->industry_other ? $request->industry_other : '');
        $eventProcess->first_bgst_event = ($request->first_bgst_event ? $request->first_bgst_event : 'N');
	    $eventProcess->hear_about = ($request->hear_about ? $request->hear_about : '');
		$eventProcess->hear_about_other = ($request->hear_about_other ? $request->hear_about_other : '');
		$eventProcess->voucher = ($request->voucher ? $request->voucher : '');
        $eventProcess->created_at = Carbon::now()->toDateTimeString();
        $eventProcess->save();
        //dd($_REQUEST);
        return redirect(route('events.cart', array('event_id' => $request->event_id, 'reg_id' => $eventProcess->id)));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Str;
use App\Banner;
use App\Regulatory;
use Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Traits\GetEmailTemplate;
use App\Mail\UserSideMail;
use App\Mail\AdminSideMail;

class PagesFrontController extends Controller
{
    use GetEmailTemplate;

	public function __construct()
    {
        $this->module_name = 'COUNTRY_INFORMATION';
    }

    public function index($slug)
    {
		 $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->firstOrFail();
            $banner = get_page_banner($page->id);
            $breadcrumbs = getBreadcrumb($page);
        if(!$page)
        {

            return abort(404);

        }


        if($page->slug=='country-information')
        {
            return view('country_information.country-information', compact("page", "banner", "breadcrumbs"));
        }

        elseif($page->slug=='regulatory-updates')
        {
            return view('regulatory.regulatory-updates', compact("page", "banner", "breadcrumbs"));
        }
        if($page->slug=='profile')
        {
            if(!Auth::check())
            {
                return redirect(url('login'));
            }
            $user = User::find(Auth::user()->id);
            return view('auth.profile', compact("page", "banner", "breadcrumbs", 'user'));
        }
      elseif ($page->page_type == 0) {


                return view("cms", compact("page", "banner", "breadcrumbs"));

            }

    }

    public function country_information_details()
    {
        $title_breadcrumb = [
            'slug'  =>  url()->full(),
            'title' =>  $_GET['country'] . ' ' . $_GET['category'],
        ];
        $slug = 'country-information';
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->firstOrFail();

        $breadcrumbs = getBreadcrumb($page, $title_breadcrumb);
        $slug = __('constant.COUNTRY_INFORMATION_DETAILS');
        $page = Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->firstOrFail();
        $banner = get_page_banner($page->id);

        return view('country_information.country-information-details', compact("page", "banner", "breadcrumbs"));
    }

    public function country_information_print()
    {
        return view('country_information.country-information-print');
    }

    public function regulatory_details($slug)
    {
        $regulatory = Regulatory::where('slug', $slug)->firstOrFail();
        $child_regulatory = Regulatory::childregulatory($regulatory->id);

        $slug_page = 'regulatory-updates';
        $page = Page::where('pages.slug', $slug_page)
            ->where('pages.status', 1)
            ->firstOrFail();


        $title_breadcrumb = [
            'slug'  =>  $regulatory->slug,
            'title' =>  $regulatory->title,
        ];
        $breadcrumbs = getBreadcrumb($page, $title_breadcrumb);
        $slug_page = __('constant.REGULATORY_DETAILS');
        $page = Page::where('pages.slug', $slug_page)
            ->where('pages.status', 1)
            ->firstOrFail();
        $banner = get_page_banner($page->id);

        return view('regulatory.regulatory-update-details', compact('regulatory', 'child_regulatory', "page", "banner", "breadcrumbs"));
    }

    public function regulatory_print($slug)
    {

        $regulatory = Regulatory::where('slug', $slug)->firstOrFail();
        $child_regulatory = null;
        $id = $_GET['id'] ?? '';
        if($id)
        {
            if(strpos($id, ',') !== false)
            {
                $id = explode(',', $id);
                $child_regulatory = Regulatory::whereIn('id', $id)->latest()->get();
            }
            else
            {
                $child_regulatory = Regulatory::where('id', $id)->get();
            }
        }
        return view('regulatory.regulatory-print', compact('regulatory', 'child_regulatory'));
    }

    public function regulatory_details_search()
    {
        $country = isset($_GET['country']) ? $_GET['country'][0] : '';
        $month = isset($_GET['month']) ? $_GET['month'][0] : '';
        $year = isset($_GET['year']) ? $_GET['year'][0] : '';
        $topic = isset($_GET['topic']) ? $_GET['topic'][0] : '';
        $stage = isset($_GET['stage']) ? $_GET['stage'][0] : '';
        $option_type = isset($_GET['option_type']) ? $_GET['option_type'] : '';

        $query = Regulatory::query();
        if($country)
        {
            $query->whereIn('regulatories.country_id', $country);
        }
        if($month)
        {
            $query->whereMonth('regulatories.regulatory_date', date('m', strtotime($month)));
        }
        if($year)
        {
            $query->whereYear('regulatories.regulatory_date', $year);
        }
        if($topic)
        {
            $query->where('regulatories.topic_id', 'like', '%'.$topic.'%');
        }
        if($stage)
        {
            $query->where('regulatories.stage_id', $stage);
        }

        $result = $query->join('filters', 'regulatories.country_id', '=', 'filters.id')->where('filters.filter_name', 1)->orderBy('filters.tag_name', 'asc')->orderBy('regulatories.title', 'asc')->select('regulatories.id as regulatories_id', 'regulatories.*', 'filters.*')->get();

        if(!$country && !$month && !$year && !$topic && !$stage)
        {
            $result = Regulatory::latestregulatory();
        }
        if($option_type)
        {
            $result = Regulatory::latestregulatory();
        }
        ?>
            <h1 class="title-1 text-center">Search Results</h1>
            <?php
            if($result->count())
            {
            ?>
            <div class="grid-2 eheight clearfix mbox-wrap" data-num=<?php echo setting()->pagination_limit ?? 8 ?>">
        <?php

        foreach($result as $value)
        {
            $regulatory = getRegulatoryData($value->parent_id);
            if($regulatory)
            {
        ?>

                <div class="item mbox">
                    <div class="box-4">
                        <figure><img src="<?php if($regulatory->country_id) { echo getFilterCountryImage($regulatory->country_id); } ?>" alt="<?php if($regulatory->country_id) { echo getFilterCountry($regulatory->country_id); } ?> flag" /></figure>
                        <div class="content">
                            <div class="ecol">
                                <h3 class="title"><?php echo $value->title ?></h3>
                                <p class="date"><span class="country"><?php if($regulatory->country_id) { echo getFilterCountry($regulatory->country_id); } ?></span> |
                                    <?php echo date('M d, Y', strtotime($value->regulatory_date)); ?></p>
                                    <p><?php echo html_entity_decode(Str::limit(strip_tags($value->description), 300)); ?></p>
                            </div>
                        </div>
                        <a class="detail" href="<?php if($regulatory->slug) { echo url('regulatory-details', $regulatory->slug) . '?id=' . $value->regulatories_id; } else { echo 'javascript:void(0)'; } ?>">View detail</a>
                    </div>
                </div>


        <?php
        }}
        ?>
                <div class="more-wrap"><button id="btn-load-2" class="btn-4 load-more"> Load more <i
                    class="fas fa-angle-double-down"></i></button></div>
            </div>

        <?php
            }
            else {
                ?>
                    <p class="text-center">No result found.</p>
                <?php
            }
    }

    public function profileUpdate(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'organization' => 'required|string',
            'country'   =>  'required',
            'password' => 'required',
        ]);

        $user = User::where('user_id', $id)->firstOrFail();
        if(password_verify($request->password, $user->password))
        {
            $user->salutation = $request->salutation;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->organization = $request->organization;
            $user->job_title = $request->job_title;
            $user->telephone_code = $request->telephone_code;
            $user->telephone_number = $request->telephone_number;
            $user->mobile_code = $request->mobile_code;
            $user->mobile_number = $request->mobile_number;
            $user->country = $request->country;
            $user->city = $request->city;
            $user->address1 = $request->address1;
            $user->address2 = $request->address2;
            $user->save();
            return redirect('profile')->with('success',  'Success! Profile have been updated.');
        }
        return redirect('profile')->with('error',  'Sorry! Password does not match.');
    }

	 public function profileDetail($slug="")
    {
        if(Auth::check())
		{
		$slug=__('constant.PROFILE_DETAIL');
		$title = __('constant.PROFILE');
		$page=Page::where('pages.slug', $slug)
            ->where('pages.status', 1)
            ->firstOrFail();

		$banner = get_page_banner($page->id);

		if (!$page) {
		return abort(404);
		}
		$breadcrumbs = getBreadcrumb($page);
        $id = Auth::user()->id;
		$user = User::find($id);
		$paid_user = userPayments($id);
		$last_user_paid = latestUserPayments($id);

		//dd($last_user_paid);
        return view('profile-detail', compact('title', 'user','last_user_paid','paid_user','page','banner','breadcrumbs'));
		}else{
			return redirect('/login');
		}
    }

	public function updateStatus(Request $request)
    {


			$response = [];
            $user = User::findorfail($request->id);
			$user->status =$request->status;
            $response['msg'] = "Status updated successfully.";
            $response['status'] = "success";
            $res=$user->save();
		    if($res)
			{
		    Auth::logout();
			$emailTemplate = $this->emailTemplate(__('constant.UNSUBSCRIBE_ADMIN_EMAIL_TEMP_ID'));
					 if ($emailTemplate) {

					$data = [];

					$data['subject'] = $emailTemplate->subject;

					$data['email_sender_name'] = setting()->email_sender_name;

					$data['from_email'] = setting()->from_email;

					$data['subject'] = $emailTemplate->subject;

					$key = ['{{name}}',  '{{user_id}}'];

					$name=$user->firstname.' '.$user->lastname;
					$value = [$name,$user->user_id];

					$newContents = replaceStrByValue($key, $value, $emailTemplate->contents);

					$data['contents'] = $newContents;
					$toEmail = setting()->to_email;
					try {
						$mail = Mail::to($toEmail)->send(new AdminSideMail($data));
					} catch (Exception $exception) {
						dd($exception);
					}



				}
            return redirect('/thank-you')->with($response['status'], $response['msg']);
			}
    }


}

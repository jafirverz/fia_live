<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();

        $result = $this->members();
        $chart1 = $result['chart1'];
        $chart2 = $result['chart2'];

        return view('admin.home', compact('chart1', 'chart2'));
    }

    public function members()
    {
        $result = [];

        $memberbycountry = User::get();

        $membership_growth_date = User::whereYear('created_at', date('Y'))->where('status', '!=', __('constant.NEWSLATTER_SUBSCRIBER'))->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') new_date"), 'users.*')->groupby('new_date')->get();
        $membership_growth = User::whereYear('created_at', date('Y'))->where('status', '!=', __('constant.NEWSLATTER_SUBSCRIBER'))->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') new_date"), 'users.*')->get();
        //dd($membership_growth->where('renew_status', 1)->where('new_date', '2019-07')->count());
        // CHART1
        $country_array = $memberbycountry->groupBy('country')->toArray();

        $fia_member_dataset = [];
        $member_dataset = [];
        $complimentary_dataset = [];
        $fia_member_dataset_color = [];
        $member_dataset_color = [];
        $complimentary_dataset_color = [];

        foreach (array_keys($country_array) as $value) {
            $fia_member_dataset[] = $memberbycountry->where('member_type', 1)->where('country', $value)->count();
            $fia_member_dataset_color[] = 'rgb(0,192,239)';
            $member_dataset[] = $memberbycountry->where('member_type', 2)->where('country', $value)->count();
            $member_dataset_color[] = 'rgb(60,141,188)';
            $complimentary_dataset[] = $memberbycountry->where('member_type', 3)->where('country', $value)->count();
            $complimentary_dataset_color[] = 'rgb(210,214,222)';
        }

        //CHART2
        $new_dataset = [];
        $expired_dataset = [];
        $renewed_dataset = [];
        foreach ($membership_growth_date as $value) {
            $new_dataset[] = $membership_growth->where('renew_status', 1)->where('new_date', $value->new_date)->count();
            $expired_dataset[] = $membership_growth->where('renew_status', 3)->where('new_date', $value->new_date)->count();
            $renewed_dataset[] = $membership_growth->where('renew_status', 2)->where('new_date', $value->new_date)->count();
        }
        $result['chart1'] = app()->chartjs
            ->name('memberbycountry')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(array_keys($country_array))
            ->datasets([
                [
                    "label" => "FIA Member",
                    'backgroundColor' => $fia_member_dataset_color,
                    'data' => $fia_member_dataset
                ],
                [
                    "label" => "Member",
                    'backgroundColor' => $member_dataset_color,
                    'data' => $member_dataset
                ],
                [
                    "label" => "Complimentary",
                    'backgroundColor' => $complimentary_dataset_color,
                    'data' => $complimentary_dataset
                ]
            ])
            ->optionsRaw([
                'responsive' => true,
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => '#000'
                    ]
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'stacked' => true,
                            'gridLines' => [
                                'display' => true
                            ]
                        ]
                    ],
                    'yAxes' => [
                        [
                            'stacked' => true,
                            'gridLines' => [
                                'display' => true
                            ]
                        ]
                    ]
                ]
            ]);

        $result['chart2'] = app()->chartjs
            ->name('membershipgrowth')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($membership_growth_date->pluck('new_date')->toArray())
            ->datasets([
                [
                    "label" => "New",
                    'borderColor' => ['rgb(251,189,11)'],
                    'data' => $new_dataset
                ],
                [
                    "label" => "Expired",
                    'borderColor' => ['rgb(234,67,53)'],
                    'data' => $expired_dataset
                ],
                [
                    "label" => "Renewed",
                    'borderColor' => ['rgb(0,192,239)'],
                    'data' => $renewed_dataset
                ]
            ])
            ->optionsRaw([
                'maintainAspectRatio' => false,
                'spanGaps' => false,
                'elements' => [
                    'line' => [
                        'tension' => 0.000001
                    ],
                ],
                'scales' => [
                    'yAxes' => [
                        [
                            'stacked' => true,
                        ]
                    ]
                ],
                'plugins' => [
                    'filler' => [
                        'propagate' => false
                    ],
                    'samples-filler-analyser' => [
                        'target' => 'chart-analyser'
                    ],
                ],
            ]);
        return $result;
    }
}

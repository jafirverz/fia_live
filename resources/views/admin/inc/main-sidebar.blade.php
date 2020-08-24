@php
$sidebar = [
[
'title' => __('constant.DASHBOARD'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/home',
],
[
'title' => __('constant.FILTER'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/filter',
],
[
'title' => 'CMS',
'icon' => '<i class="fa fa-check"></i>',
'url' => '#',
'sub-menu' =>
[
[
'title' => __('constant.MENU'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/menu',
],
[
'title' => __('constant.BANNER'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/banner',
],
[
'title' => __('constant.PAGE'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/page',
],
],
],
[
'title' => __('constant.EVENT'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/events',
],
[
'title' => __('constant.TOPICAL_REPORT'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/topical-report',
],
[
'title' => __('constant.PODCAST'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/podcast',
],
[
'title' => __('constant.THINKING_PIECE'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/thinking_piece',
],
[
'title' => __('constant.PAYMENT'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/payment',
],
[
'title' => __('constant.COUNTRY_INFORMATION'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/country-information',
],
[
'title' => __('constant.REGULATORY'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/regulatory',
],
[
'title' => __('constant.CONTACTENQUIRY'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/contact-enquiry',
],
[
'title' => __('constant.GROUPMANAGEMENT'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/group-management',
],
[
'title' => __('constant.EMAIL_TEMPLATE'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/email-template',
],
[
'title' => __('constant.ROLES_AND_PERMISSION'),
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/roles-and-permission',
],
[
'title' => __('constant.USER'),
'icon' => '<i class="fa fa-check"></i>',
'url' => '#',
'sub-menu' =>
[
[
'title' => "All",
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/user',
],
[
'title' => "Pending Email Approval",
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/user?status=1',
],
[
'title' => "Pending Admin Approval",
'icon' => '<i class="fa fa-check"></i>',
'url' => 'admin/user?status=2',
],
],
],
];

function hasChildUrl($url, $sub_menu)
{
foreach($sub_menu as $value)
{
if(strpos($url, $value['url'])!==false)
{
return true;
}
}
return false;
}
@endphp
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            @if($sidebar)
            @foreach ($sidebar as $item)
            <li
                class="@if(array_key_exists('sub-menu', $item)) treeview @if(hasChildUrl(url()->current(), $item['sub-menu'])!==false) menu-open @endif @endif @if(strpos(url()->current(), $item['url'])!==false) active @endif">
                <a href="{{ url($item['url']) }}">{!! $item['icon'] !!}<span>{{ $item['title'] }}</span>
                    @if(array_key_exists('sub-menu', $item))
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    @endif
                </a>
                @if(array_key_exists('sub-menu', $item))
                <ul class="treeview-menu" @if(hasChildUrl(url()->current(), $item['sub-menu'])!==false)
                    style="display:block;" @endif>
                    @if($item['sub-menu'])
                    @foreach ($item['sub-menu'] as $subitem)
                    @if(strpos($subitem['url'],\Request::segment(2))!==false)
                    <?php 
                                                 if (isset($_GET["status"]) && trim($_GET["status"]) == 1){
                                                    $activeLink = 'admin/user?status=1';
                                                 } elseif (isset($_GET["status"]) && trim($_GET["status"]) == 2){
                                                     $activeLink = 'admin/user?status=2';
                                                 }else{
                                                     $activeLink = 'admin/user';
                                                 }
                                                 ?>
                    <li class=" @if($activeLink == $subitem['url']) active @endif">
                        <a href="{{ url($subitem['url']) }}">{!! $subitem['icon']
                            !!}<span>{{ $subitem['title']  }} </span></a>
                    </li>
                    @else
                    <li class="@if(strpos(url()->current(), $subitem['url'])!==false) active @endif">
                        <a href="{{ url($subitem['url']) }}">{!! $subitem['icon']
                            !!}<span>{{ $subitem['title']}}</span></a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                </ul>
                @endif
            </li>
            @endforeach
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
    </section>
    <!-- /.sidebar -->
</aside>
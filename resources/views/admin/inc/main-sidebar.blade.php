<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="active">
                <a href="{{ url('/admin/home') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.DASHBOARD') }}</span></a>
            </li>
            <li><a href="{{ url('admin/filter') }}"><i class="fa fa-check"></i> {{ __('constant.FILTER') }}</a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-check"></i> <span>CMS</span>
                    <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                    <ul class="treeview-menu">
                     <li><a href="{{ url('admin/menu') }}"><i class="fa fa-check"></i> {{ __('constant.MENU') }}</a></li>
                     <li><a href="{{ url('admin/banner') }}"><i class="fa fa-check"></i> {{ __('constant.BANNER') }}</a></li>
                     <li><a href="{{ url('admin/page') }}"><i class="fa fa-check"></i> {{ __('constant.PAGE') }}</a></li>
                     </ul>
            </li>
           
             <li>
                <a href="{{ url('/admin/events') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.EVENT') }}</span></a>
            </li>
             <li>
                <a href="{{ url('/admin/topical-report') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.TOPICAL_REPORT') }}</span></a>
            </li>
            <li>
                <a href="{{ url('/admin/payment') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.PAYMENT') }}</span></a>
            </li>
            <li>
                <a href="{{ url('/admin/country-information') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.COUNTRY_INFORMATION') }}</span></a>
            </li>
            <li>
                <a href="{{ url('/admin/regulatory') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.REGULATORY') }}</span></a>
            </li>
            <li>
                <a href="{{ url('/admin/contact-enquiry') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.CONTACTENQUIRY') }}</span></a>
            </li>
            <li>
                <a href="{{ url('/admin/group-management') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.GROUPMANAGEMENT') }}</span></a>
            </li>
             <li>
                <a href="{{ url('/admin/email-template') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.EMAIL_TEMPLATE') }}</span></a>
            </li>
            <li>
                <a href="{{ url('/admin/roles-and-permission') }}"><i class="fa fa-check"></i>
                    <span>{{ __('constant.ROLES_AND_PERMISSION') }}</span></a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
    </section>
    <!-- /.sidebar -->
</aside>

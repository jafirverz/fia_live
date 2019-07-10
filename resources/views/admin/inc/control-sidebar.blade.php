<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading"> <a href="{{ route('system-setting.index') }}">
                        <i class="fa fa-cog"></i> <span>{{ __('constant.SYSTEM_SETTING')}}</span>
                    </a></h3>

            <h3 class="control-sidebar-heading"> <a href="{{ route('master-setting.index') }}">
                    <i class="fa fa-support"></i> <span>{{ __('constant.MASTER_SETTING')}}</span>
                </a></h3>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

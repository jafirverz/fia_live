@extends('admin.layout.dashboard')
@section('content')
        <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
            <small>{{ $subtitle }}</small>
        </h1>
        {{ Breadcrumbs::render('user-login-log') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- SELECT2 EXAMPLE -->

                <!-- /.box -->
                
                <div class="box">
                    

                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="users-log" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Login at</th>
                                <th>Logout at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($users->count())
                                @foreach($users as $user)
                                    <tr>
                                        
                                        <td>{{ $user->ip_address ?? '-' }}</td>
                                    <td data-order="{{$user->login_at}}">{{ \Carbon\Carbon::parse($user->login_at)->format('d M, Y h:i A') ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->logout_at)->format('d M, Y h:i A') ?? '-' }}</td>
                                        


                                    </tr>
                                @endforeach
                            @endif
                            </tbody>

                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
        
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@push('scripts')
<script>
   
    $('#users-log').DataTable({
        "pageLength": 50,
        'order': [
            [1, 'desc']
        ],
});
</script>
@endpush

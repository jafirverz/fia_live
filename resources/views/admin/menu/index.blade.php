@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains  content -->
<div class="content-wrapper">
    <!-- Content Header ( header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> 

        {{ Breadcrumbs::render('sub_menu',$parentMenu,$type) }}
        
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                <div class="box">
                    <div class="box-header with-border">
                   
                        <a href="{{ route("menu-create",["parent"=>$parent,"type"=>$type]) }}" class="btn btn-primary pull-right">Create</a>
                   
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="menu-table" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                               <th>S. No.</th>
                                <th>Title</th>
                                <th>Page</th>
                                
                                <th>Status</th>
                                <th>Created on</th>
                                <th>Updated on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($menus->count())
                           @php  $k=0; @endphp
                                @foreach($menus as $k=> $menu)
                                @php $k++; @endphp
                                    <tr>
                                        <td>
                                            {{ $k }}
                                        </td>
                                        <td>
                                            {{ $menu->title }}
                                        </td>
                                        <td>
                                            @if($menu->target_value!=1 && $menu->page_id>0)
                                             {{ get_page_name($menu->page_id) }}
                                            @elseif($menu->target_value==1 && $menu->external_link!="")    
                                             {{ $menu->external_link}}
                                            @else
                                             {{__('constant.NONE')}}    
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @if($menu->status==1)
                                                {{__('constant.ACTIVATE')}}
                                            @elseif($menu->status==0)
                                                {{__('constant.DEACTIVATE')}}
                                            @endif
                                        </td>
                                        <td data-order="{{ $menu->created_at }}">
                                            @if (!is_null($menu->created_at))
                                                {{$menu->created_at->format('d M, Y h:i A')}}
                                            @endif
                                        </td>
                                        <td data-order="{{ $menu->updated_at }}">@if (!is_null($menu->updated_at))
                                                {{$menu->updated_at->format('d M, Y h:i A')}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route("menu-edit",["id"=>$menu->id,"parent"=>$parent,"type"=>$type]) }}"
                                               title="Edit Menu">
                                                <i class="fa fa-pencil btn btn-primary" aria-hidden="true"></i>
                                            </a>

                                            <a href="{{ route("menu-destroy",["id"=>$menu->id,"parent"=>$parent]) }}"
                                               title="Delete Menu" class=""
                                               onclick="return confirm('Are you sure you want to delete this Menu?');">
                                                <i class="fa fa-trash btn btn-danger " aria-hidden="true"></i>
                                            </a>

                                            <a class="" title="Menu List"
                                               href="{{ route("get-sub-menu",["id"=>$menu->id,"type"=>$type]) }}">
                                                <i class="fa fa-list btn btn-default "></i>
                                            </a>
                                        </td>
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

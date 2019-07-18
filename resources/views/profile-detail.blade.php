@extends('layouts.app')

@section('content')
            <div class="main-wrap">   
				@include('inc.banner')
				<div class="container space-1">
					<div class="profile-wrap">
						<h1 class="title-1 text-center">{{$title}}</h1>
						<div class="row break-480">
							<div class="col-xs-6 col">								
								<div class="lb">Subscription Type:</div>
								<div class="group">{{$last_user_paid->subscription_type}}</div>
							</div>
							<div class="col-xs-6 col">		
								<div class="lb">Subscription ID:</div>
								<div class="group">{{$last_user_paid->transaction_id}}</div>
							</div>
						</div>
						<div class="row break-480">
							<div class="col-xs-6 col">								
								<div class="lb">Subscription Duration:</div>
								<div class="group">{{$last_user_paid->period_value.' '.$last_user_paid->period_type}}</div>
							</div>
							<div class="col-xs-6 col">		
								<div class="lb">Payment Status:</div>
								<div class="group">@if(!is_null($user->invoice()) && $user->invoice()->paid==1 )
                                                       Paid @elseif(!is_null($user->invoice()) && $user->invoice()->paid==0)
                                                       Unpaid @else - @endif</div>
							</div>
						</div>
						<div class="row break-480">
							<div class="col-xs-6 col">								
								<div class="lb">Subscription Date:</div>
								<div class="group">@if(!is_null($user->invoice()) )
                                               {{ date('j, F Y H:i A',strtotime($user->invoice()->created_at)) }}
                                               @else - @endif</div>
							</div>
							<div class="col-xs-6 col">		
								<div class="lb">Subscription Status:</div>
								<div class="group">@if($user->status==5)Active @else Inactive @endif</div>
							</div>
						</div>
						<div class="row break-480">
							<div class="col-xs-6 col">								
								<div class="lb">Renewal Date:</div>
								<div class="group">{{ date('j, F Y H:i A',strtotime($user->expired_at)) }}</div>
							</div>
							<div class="col-xs-6 col">		
								<div class="lb">PayPal Account Details:</div>
								<div class="group">- </div>
							</div>
						</div>
						<a class="coll-title" data-toggle="collapse" href="#history">Transaction History</a>
						<div class="collapse in" id="history">
							<div class="coll-content">
								<div class="table-responsive tb-1">
									<table id="payments" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th style="width: 50px;">S/N</th>
												<th>Payer Email</th>
												<th>Payer ID</th>
												<th>Payment Date</th>
												<th>Amount</th>
												<th>Currency</th>
											</tr>
										</thead>
										<tbody>
                          
                            @if($paid_user->count())
                                @foreach($paid_user as $key => $payment)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{ $payment->user_email ?? '-' }}</td>
                                        <td>{{ $payment->order_id ?? '-' }}</td>
                                        <td data-order="<?php if (!is_null($payment->created_at)) {
                                            echo $payment->created_at->format('d M, Y H:i:s');
                                        }?>">@if(!is_null($payment->created_at) )
                                                {{ $payment->created_at->format('d M, Y')}}
                                            @else - @endif
                                        </td>
                                        <td>
                                            {{$payment->total}}
                                        </td>
                                        <td>{{$payment->currency}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
									</table>
								</div>
							</div>
						</div>
                        @if($user->status!=11)
						<div class="output text-center">
							<a href="#pp" class="btn-2" data-toggle="modal">Unsubscribe</a>
						</div>
                        @else
                        <div class="output text-center">
							<a href="#pp" class="btn-2" data-toggle="modal">Subscribe</a>
						</div>
                        @endif	
						
						<div id="pp" class="modal fade">
							<div class="modal-dialog" style="max-width: 500px;">
								<div class="modal-content">						
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
									<div class="note-content">
										<h3>Are you sure want to delete?</h3>
										<div class="output">
											<a class="btn-2" title="Unsubscribe" href="{{ route('update-profile-status',['id'=>$user->id,'status'=>11]) }}">Yes</a>											
											<button type="button" class="btn-4" data-dismiss="modal">No</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>	
				</div>							
                
            </div><!-- //main -->
            
<script>
 $(document).ready(function() {   
	$('#payments').DataTable(
            {
                "pageLength": 10,
                'ordering': true,
                'order': [[3, 'asc']],
                "aoColumnDefs": [{
                    "aTargets": [],
                    "bSortable": false
                },
                    {width: 100, targets: 0},
                    {width: 150, targets: 1},
                    {width: 300, targets: 2},
                    {width: 150, targets: 3},
                    {width: 150, targets: 4},
                    {width: 150, targets: 5}

                ]
            });
			
		$("#closeBtn").on("click",function(){
		 alert(123);
		});

});
</script>
@endsection

@extends('layouts.app')
@section('content')
        <!-- Content Containers -->
<div class="main-container">
    @include('inc.breadcrumb-banner')
    <?php $user = Auth::user();?>
            <!-- Section -->
    @include('admin.inc.message')
    <div class="fullcontainer">
        <div class="inner-container">
            <div class="container">
                <h2 class="text-center mb0"><strong>{{ $event->title }}</strong></h2>
            </div>
        </div>
        <div class="fullwidth-img">

            @if($event->banner_image)
                <img src="{!! asset($event->banner_image) !!}" class="responsive"
                     alt="BIBLICAL GRADUATE SCHOOL OF THEOLOGY."/>
            @else
                <div style="padding-bottom: 90px;"></div>
            @endif
        </div>
    </div>
    <!-- Section END -->
    <!-- Section -->
    <div class="fullcontainer bg-color2 info-container">
        <div class="width-sml md fleft">
            <div class="textColLeft">
                <div class="textContent xs">
                    <div class="info-content">
                        <h5 class="mb10">@if($event_type->count())
                                {{ $event_type[0]->event_type_title }}
                            @endif
                            <strong>{{ $event->title }} </strong></h5>
                             @if($event->start_date)
                        <!--<label>Start: </label>--> {{ date("F j Y",strtotime($event->start_date)) }} | {{ date("h:m A",strtotime($event->start_date)) }}<br />
                        @endif
                            
                            @if($event->end_date)
                        <!--<label>End: </label>--> {{ date("F j Y",strtotime($event->end_date)) }}   |   {{ date("h:m A",strtotime($event->end_date)) }}<br />
                                                     @endif
 													<?php /*?>@if($event->oth_date!=null)
                                                    <label>Other Date: </label> {{ $event->oth_date }}<br />
                                                    @endif<?php */?>
                                                    <span class="badge">{{ ($event->paid_event==1)? 'PAID' : 'FREE' }}</span></p>
                        {!! $event->description !!}
                        <h6><strong>Location: </strong>{{ $event->location }}</h6>
                            
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="width-sm md fright">
            <div class="intro-img"><img src="{!! asset($event->event_image) !!}" alt="" class="responsive"></div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- Section END -->
    <!-- Section -->
   
    <div class="fullcontainer">
	
		
        
        @if($event->speaker)
		<?php

        $speaker = json_decode($event->speaker);
        $sp = "";
        foreach($speaker as $key=>$value)
        {
        $sp = \DB::table('teachers')->where('id', $value)->get();
        if($sp->count())
        {
        ?>
       <div class="inner-container">
        <div class="container">
			<div class="row">
				<div class="col-sm-3"> <img src="{{ url($sp[0]->teacher_picture) }}" alt="" class="responsive-mx"> </div>
				<div class="col-sm-9">
					<h5>Lecturer : <strong>{{ $sp[0]->teacher_name }}</strong></h5>
					{{ $sp[0]->teacherbio }}			
                    </div>
            </div> 
         </div>
      </div>
        <?php }}?>
      @endif
      					
		
	
	<div class="clear"></div>
</div>


    <!-- Section END --
    
    
	</div>
	<!-- Content Containers END -->
</div>
<div class="fullcontainer">
	<div class="inner-container">
		<div class="container">
        <div class="col-sm-12">
@if($event->paid_event==1)
<h5><strong>EVENT FEES</strong></h5>
@endif
 						{!! Form::open(['name'=>'event-detail-store','url' => 'events/detail-store/', 'method' => 'post']) !!}
                        <div class="event-fees-holder">
                           
                            <div class="row">
                                @if($event->paid_event)
                                    <?php
                                    $fees_category = array_values(json_decode($event->fees_category));
                                    //print_r($fees_category);
                                    $feescategory = \DB::table('events_feescategories')->where('category_name', '!=', "")->whereIn('id', $fees_category)->get();
                                    //print_r($feescategory);

                                    if($feescategory->count() > 0)
                                    {
                                    foreach($feescategory as $key=>$category){
                                    ?>
                                    <div class="col-xs-4">
                                        <input type="radio" @if($key==0)checked="checked" @endif name="event_fees"
                                               value="{{ $category->id }}"
                                               id="fee_{{ $category->id }}" class="input-hidden alt"/>
                                        <label for="fee_{{ $category->id }}"> {{ $category->category_name }} <span>$
                                                {{ $category->category_price }}</span> </label>
                                    </div>

                                    <?php } }?>

                                @else
                                    <input checked="checked" type="hidden" name="event_fees" value="0" id="fee_0"
                                           class="input-hidden alt"/>


                                @endif


                            </div>

                        </div>
                        <div class="text-right">
                            <input type="hidden" name="event_id" value="{{ $event->id }}"/>
                            @if(Auth::check())
                                <button class="button alt">Register for this Event</button>
                            @else <a href="#" class="button" data-toggle="modal" data-target="#SkipLoginModal">Register for this Event</a>
                            @endif
                        </div>
                        {!! Form::close() !!}
         </div>
    </div>
	<div class="clear"></div>
</div>
</div>
<script type="application/javascript">
    function skipLogin(){
       $("form[name='event-detail-store']").submit();
    }

</script>
@endsection

@if($page->slug=="home")
<div class="banner">
    <div class="bn-slide" id="slider">
    	@foreach($banners as $banner)
        <div class="item bg">
            <img class="bgimg" src="{{asset($banner->banner_image)}}" alt="" />
            <div class="caption">
                {{$banner->caption}}
                <a href="{{url('about-us')}}" class="btn">See more <i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="search-wrap">
        <h2>What are you searching for?</h2>
        <form action="{{ url('/search-results')}}" class="tb-col search-wrap-2 break-320">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="col sl-country hideico">
                <select name="country" class="selectpicker">
                    <option value="" data-content='<strong>COUNTRY</strong>'>COUNTRY</option>
                    @foreach(getAllCountry() as $country)
      <option value="{{$country->id}}" data-content='<img src="{{$country->country_image}}" alt="{{$country->tag_name}}" /> {{$country->tag_name}}'>{{$country->tag_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <div class="input-group">
                    <input required="required" name="search_content" type="text" class="form-control"
                        placeholder="Regulation / Guideline / Standard / Topic / Issue" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn-5"><i class="fas fa-search"></i></button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
@elseif($page->slug=="search-results")
<div class="bn-inner bg">
@if(isset($banner))
					<img class="bgimg" src="{{asset($banner->banner_image)}}" alt="Search Results" />
@endif
					<div class="container">
						<div class="tb-col">
							<div class="col">
								<h2>What Can We Help Search For You?</h2>
                                <form action="{{ url('/search-results')}}" class="tb-col search-wrap-2 break-320">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
								<div class="tb-col search-wrap-2 break-320">
									<div class="col sl-country hideico">
										<select class="selectpicker">
											<option value="" data-content='<strong>COUNTRY</strong>'>COUNTRY</option>
                                            @foreach(getAllCountry() as $country)
      <option value="{{$country->id}}" data-content='<img src="{{$country->country_image}}" alt="{{$country->tag_name}}" /> {{$country->tag_name}}'>{{$country->tag_name}}</option>
                    @endforeach
										</select>
									</div>
									<div class="col">
										<div class="input-group">
											<input required="required" type="text" class="form-control" value="{{$_GET['search_content']}}" placeholder="Name of Regulation / Issue / Topic..." />
											<span class="input-group-btn">
												<button type="submit" class="btn-5"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								</div>
                                </form>
							</div>
						</div>
					</div>
				</div>
				<div class="breadcrumb-wrap">
					<div class="container">
						<ul class="breadcrumb">
							<li><a href="index.html">Home</a></li>
							<li>Search Results</li>
						</ul>
					</div>
				</div>
@else
<div class="bn-inner bg nobg">

					@if(isset($banner))
                    <img class="bgimg" src="{{asset($banner->banner_image)}}" alt="{{ $page->title }}" />
                    @endif
					<div class="container">
						<div class="tb-col">
							<div class="col">
								<h2>{{ $page->title }}</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="breadcrumb-wrap">
					<div class="container">
                        @if (isset($breadcrumbs) && count($breadcrumbs))
                            <ul class="breadcrumb">
                                @foreach ($breadcrumbs as $breadcrumb)
                                @if(is_array($breadcrumb))
                                @if($loop->last)
                                    <li><strong>{{ $breadcrumb['title'] }}</strong></li>
                                @else
                                    <li><a href="{{ url($breadcrumb['slug']) }}">{{ $breadcrumb['title'] }}</a></li>
                                @endif
                                @else
                                @if ($breadcrumb->url && !$loop->last)
                                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                                @else
                                    <li><strong>{{ $breadcrumb->title }}</strong></li>
                                @endif
                                @endif
                                @endforeach
                            </ul>
                        
                    @endif
					</div>
				</div>
@endif
@if($page->slug=="home")
<div class="banner">
    <div class="bn-slide" id="slider">
    	@foreach($banners as $banner)
        <div class="item bg">
            <img class="bgimg" src="{{asset($banner->banner_image)}}" alt="" />
            <div class="caption">
                {{$banner->caption}}
                <a href="about.html" class="btn">See more <i class="fas fa-angle-double-right"></i></a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="search-wrap">
        <h2>What are you searching for?</h2>
        <form action="search-result.html" class="tb-col search-wrap-2 break-320">
            <div class="col sl-country hideico">
                <select class="selectpicker">
                    <option data-content='<strong>COUNTRY</strong>'>COUNTRY</option>
                    <!--<option data-content='<img src="images/tempt/flag-afghanistan.jpg" alt="china" /> Afghanistan'> Afghanistan</option>-->
                    <option
                        data-content='<img src="images/tempt/flag-australia.jpg" alt="australia" /> Australia'>
                        Australia</option>
                    <!--<option data-content='<img src="images/tempt/flag-bangladesh.jpg" alt="bangladesh" /> Bangladesh'> Bangladesh</option>-->
                    <!--<option data-content='<img src="images/tempt/flag-bhutan.jpg" alt="bhutan" /> Bhutan'> Bhutan</option>-->
                    <option data-content='<img src="images/tempt/flag-brunei.jpg" alt="brunei" /> Brunei'>
                        Brunei</option>
                    <option data-content='<img src="images/tempt/flag-combodia.jpg" alt="combodia" /> Combodia'>
                        Combodia</option>
                    <option data-content='<img src="images/tempt/flag-china.jpg" alt="china" /> China'>
                        China</option>
                    <option data-content='<img src="images/tempt/flag-hongkong.jpg" alt="hongkong" /> Hongkong'>
                        Hongkong</option>
                    <option
                        data-content='<img src="images/tempt/flag-indonesia.jpg" alt="indonesia" /> Indonesia'>
                        Indonesia</option>
                    <option data-content='<img src="images/tempt/flag-india.jpg" alt="india" /> India'>
                        India</option>
                    <option data-content='<img src="images/tempt/flag-japan.jpg" alt="japan" /> Japan'>
                        Japan</option>
                    <option data-content='<img src="images/tempt/flag-korea.jpg" alt="korea" />South  Korea'>
                        South Korea</option>
                    <option data-content='<img src="images/tempt/flag-laos.jpg" alt="Laos" /> Laos'> Laos
                    </option>
                    <option data-content='<img src="images/tempt/flag-macau.jpg" alt="macau" /> Macau'>
                        Macau</option>
                    <option data-content='<img src="images/tempt/flag-malaysia.jpg" alt="malaysia" /> Malaysia'>
                        Malaysia</option>
                    <!--<option data-content='<img src="images/tempt/flag-mongolia.jpg" alt="mongolia" /> Mongolia'> Mongolia</option>-->
                    <option data-content='<img src="images/tempt/flag-myanmar.jpg" alt="myanmar" /> Myanmar'>
                        Myanmar</option>
                    <!--<option data-content='<img src="images/tempt/flag-nepal.jpg" alt="nepal" /> Nepal'> Nepal</option>-->
                    <option
                        data-content='<img src="images/tempt/flag-new-zealand.jpg" alt="New Zealand" /> New Zealand'>
                        New Zealand</option>
                    <!--<option data-content='<img src="images/tempt/flag-pakistan.jpg" alt="pakistan" /> Pakistan'> Pakistan</option>-->
                    <option
                        data-content='<img src="images/tempt/flag-philippines.jpg" alt="philippines" /> Philippines'>
                        Philippines</option>
                    <option
                        data-content='<img src="images/tempt/flag-singapore.jpg" alt="singapore" /> Singapore'>
                        Singapore</option>
                    <option
                        data-content='<img src="images/tempt/flag-sri-lanka.jpg" alt="sri-lanka" /> Sri Lanka'>
                        Sri Lanka</option>
                    <option
                        data-content='<img src="images/tempt/flag-taipei.jpg" alt="taipei" /> Chinese Taipei'>
                        Chinese Taipei</option>
                    <option data-content='<img src="images/tempt/flag-thailand.jpg" alt="thailand" /> Thailand'>
                        Thailand</option>
                    <!--<option data-content='<img src="images/tempt/flag-timor-leste.jpg" alt="timor-leste" /> Timor-Leste'> Timor-Leste</option>-->
                    <option data-content='<img src="images/tempt/flag-vietnam.jpg" alt="vietnam" /> Vietnam'>
                        Vietnam</option>
                </select>
            </div>
            <div class="col">
                <div class="input-group">
                    <input type="text" class="form-control"
                        placeholder="Regulation / Guideline / Standard / Topic / Issue" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn-5"><i class="fas fa-search"></i></button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
@else
<div class="bn-inner bg nobg">
					@isset($banner->banner_image)
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
						<ul class="breadcrumb">
							<li><a href="{{ url('/') }}">Home</a></li>
							<li>{{ $page->title }}</li>
						</ul>
					</div>
				</div>
@endif
@extends('layouts.app')

@section('content')

<div id="toppage" class="page">
    <div class="main-wrap">
        @include('inc.breadcrumb');
        <div class="filter-wrap fw-type">
            <div class="container">
                <div class="cw-1">
                    <label>Filter by</label>
                </div>
                <div class="cw-2">
                    <div class="cw-3 sl-country hideico">
                        <select class="selectpicker" data-actions-box="true" multiple>
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
                            <option data-content='<img src="images/tempt/flag-china.jpg" alt="china" /> China'> China
                            </option>
                            <option data-content='<img src="images/tempt/flag-hongkong.jpg" alt="hongkong" /> Hongkong'>
                                Hongkong</option>
                            <option
                                data-content='<img src="images/tempt/flag-indonesia.jpg" alt="indonesia" /> Indonesia'>
                                Indonesia</option>
                            <option data-content='<img src="images/tempt/flag-india.jpg" alt="india" /> India'> India
                            </option>
                            <option data-content='<img src="images/tempt/flag-japan.jpg" alt="japan" /> Japan'> Japan
                            </option>
                            <option data-content='<img src="images/tempt/flag-korea.jpg" alt="korea" />South  Korea'>
                                South Korea</option>
                            <option data-content='<img src="images/tempt/flag-laos.jpg" alt="Laos" /> Laos'> Laos
                            </option>
                            <option data-content='<img src="images/tempt/flag-macau.jpg" alt="macau" /> Macau'> Macau
                            </option>
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
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker">
                                <option>Month</option>
                                <option>January</option>
                                <option>February</option>
                                <option>March</option>
                                <option>April</option>
                                <option>May</option>
                                <option>June</option>
                                <option>July</option>
                                <option>August</option>
                                <option>September</option>
                                <option>October</option>
                                <option>November</option>
                                <option>December</option>
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker">
                                <option>Year</option>
                                <option>2019</option>
                                <option>2020</option>
                                <option>2021</option>
                            </select>
                        </div>
                    </div>
                    <div class="cw-4">
                        <div class="iw-1">
                            <select class="selectpicker">
                                <option>Topic</option>
                            </select>
                        </div>
                        <div class="iw-2">
                            <select class="selectpicker">
                                <option>Stage</option>
                            </select>
                        </div>
                    </div>
                    <div class="cw-5">
                        <a class="lk-back" href="#">Clear all</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-tempt">
            <div class="container space-1">
                <h1 class="title-1 text-center">Highlights</h1>
                <div id="list-1" class="masony grid-4" data-num="8" data-load="#btn-load-1">
                    <div class="item w-1">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-korea.jpg" alt="korean flag" /></figure>
                            <div class="content">
                                <h3 class="title">Sample Title Here Regulatory</h3>
                                <p class="date"><span class="country">Korea</span> | Jan 27, 2019</p>
                                <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis
                                    dolor repellendus. Temporibus autem officiis quibusdam et aut debitis. Lorem ipsum
                                    pellentesque. Accusantium doloremque laudantium. Omnis voluptas assumenda est.</p>
                                <p>Temporibus autem officiis quibusdam et aut debitis. Lorem ipsum pellentesque.
                                    Accusantium doloremque laudantium. Omnis voluptas assumenda est.Lorem ipsum
                                    pellentesque. Accusantium doloremque laudantium. Omnis voluptas assumenda est.
                                    Temporibus autem officiis quibusdam et aut debitis. Lorem ipsum pellentesque.
                                    Accusantium doloremque laudantium. </p>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="updates-details.html">View detail</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-laos.jpg" alt="Laos flag" /></figure>
                            <div class="content">
                                <h3 class="title">Sample Title Here Regulatory</h3>
                                <p class="date"><span class="country">Laos</span> | Jan 27, 2019</p>
                                <p>Voluptatem accusantium doloremque lau aut debitis.</p>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="updates-details.html">View detail</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-hongkong.jpg" alt="hongkong flag" /></figure>
                            <div class="content">
                                <h3 class="title">Sample Title Here Regulatory</h3>
                                <p class="date"><span class="country">Hongkong</span> | Jan 27, 2019</p>
                                <p>Voluptatem accusantium doloremque lau aut debitis.</p>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="updates-details.html">View detail</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-singapore.jpg" alt="Singapore flag" /></figure>
                            <div class="content">
                                <h3 class="title">Sample Title Here Regulatory</h3>
                                <p class="date"><span class="country">Singapore</span> | Jan 27, 2019</p>
                                <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis
                                    dolor repellendus.</p>
                                <p>Lorem ipsum pellentesque. Accusantium doloremque laudantium. Temporibus autem
                                    officiis quibusdam et aut debitis.</p>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="updates-details.html">View detail</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-singapore.jpg" alt="Singapore flag" /></figure>
                            <div class="content">
                                <h3 class="title">Sample Title Here Regulatory</h3>
                                <p class="date"><span class="country">Singapore</span> | Jan 27, 2019</p>
                                <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis
                                    dolor repellendus.</p>
                                <p>Lorem ipsum pellentesque. Accusantium doloremque laudantium. Temporibus autem
                                    officiis quibusdam et aut debitis.</p>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="updates-details.html">View detail</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="box-4">
                            <figure><img src="images/tempt/flag-thailand.jpg" alt="thailand flag" /></figure>
                            <div class="content">
                                <h3 class="title">Sample Title Here Regulatory</h3>
                                <p class="date"><span class="country">thailand</span> | Jan 27, 2019</p>
                                <p>Voluptatem accusantium doloremque.</p>
                                <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                            </div>
                            <a class="detail" href="updates-details.html">View detail</a>
                        </div>
                    </div>

                    <!-- no loop this element -->
                    <div class="grid-sizer"></div> <!-- no loop this element -->
                </div>
                <div class="more-wrap"><button id="btn-load-1" class="btn-4 load-more"> Load more <i
                            class="fas fa-angle-double-down"></i></button></div>
            </div>
        </div>
        <div class="container space-1">
            <h1 class="title-1 text-center">Latest Updates</h1>
            <div id="list-2" class="masony grid-2" data-num="8" data-load="#btn-load-2">
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-korea.jpg" alt="thailand flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">thailand</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-thailand.jpg" alt="thailand flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">thailand</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-singapore.jpg" alt="singapore flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">singapore</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-laos.jpg" alt="laos flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">laos</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-hongkong.jpg" alt="hongkong flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">hongkong</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-singapore.jpg" alt="singapore flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">singapore</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-japan.jpg" alt="japan flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">japan</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-singapore.jpg" alt="singapore flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">singapore</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-japan.jpg" alt="japan flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">japan</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-india.jpg" alt="india flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">india</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-korea.jpg" alt="korea flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">korea</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>
                <div class="item">
                    <div class="box-4">
                        <figure><img src="images/tempt/flag-indonesia.jpg" alt="indonesia flag" /></figure>
                        <div class="content">
                            <h3 class="title">Sample Title Here Regulatory</h3>
                            <p class="date"><span class="country">india</span> | Jan 27, 2019</p>
                            <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est, omnis dolor
                                repellendus. Temporibus autem officiis quibusdam et aut debitis.</p>
                            <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                        </div>
                        <a class="detail" href="updates-details.html">View detail</a>
                    </div>
                </div>

                <!-- no loop this element -->
                <div class="grid-sizer"></div> <!-- no loop this element -->
            </div>
            <div class="more-wrap"><button id="btn-load-2" class="btn-4 load-more"> Load more <i
                        class="fas fa-angle-double-down"></i></button></div>
        </div>
    </div><!-- //main -->

</div><!-- //page -->
@endsection

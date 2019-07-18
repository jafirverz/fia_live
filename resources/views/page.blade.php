@extends('layouts.app')

@section('content')
<div id="toppage" class="page">
    <div class="main-wrap">
        <h1 class="hidden">Food Industry Asia</h1>
        @include('inc.banner')
        <div class="map-wrap">
            <div class="map-pins">
                <img src="images/map.jpg" alt="map" />
                <!--<a class="pin p-mon" href="#mongolia"><span class="flag"><img src="images/tempt/flag-mongolia.jpg" alt="MONGOLIA flag" /></span><span class="text">MONGOLIA</span></a>-->
                <a class="pin p-chi" href="#china"><span class="flag"><img src="images/tempt/flag-china.jpg"
                            alt="China flag" /></span><span class="text">China</span></a>
                <a class="pin p-jap" href="#japan"><span class="flag"><img src="images/tempt/flag-japan.jpg"
                            alt="Japan flag" /></span><span class="text">Japan</span></a>
                <!--<a class="pin p-nep" href="#nepal"><span class="flag"><img src="images/tempt/flag-nepal.jpg" alt="Nepal flag" /></span><span class="text">Nepal</span></a>-->
                <a class="pin p-kor" href="#korea"><span class="flag"><img src="images/tempt/flag-korea.jpg"
                            alt="Korea flag" /></span><span class="text">Korea</span></a>
                <!--<a class="pin p-bhu" href="#bhutan"><span class="flag"><img src="images/tempt/flag-bhutan.jpg" alt="Bhutan flag" /></span><span class="text">Bhutan</span></a>-->
                <a class="pin p-tai" href="#taipei"><span class="flag"><img src="images/tempt/flag-taipei.jpg"
                            alt="Taipei flag" /></span><span class="text">Chinese Taipei</span></a>
                <!--<a class="pin p-afg" href="#afghanistan"><span class="flag"><img src="images/tempt/flag-afghanistan.jpg" alt="Afghanistan flag" /></span><span class="text">Afghanistan</span></a>-->
                <a class="pin p-hon open" href="#hongkong"><span class="flag"><img src="images/tempt/flag-hongkong.jpg"
                            alt="Hongkong flag" /></span><span class="text">Hongkong SAR</span></a>
                <!--<a class="pin p-ban" href="#bangladesh"><span class="flag"><img src="images/tempt/flag-bangladesh.jpg" alt="Bangladesh flag" /></span><span class="text">Bangladesh</span></a>-->
                <!--<a class="pin p-pak" href="#pakistan"><span class="flag"><img src="images/tempt/flag-pakistan.jpg" alt="Pakistan flag" /></span><span class="text">Pakistan</span></a>-->
                <a class="pin p-mac" href="#macau"><span class="flag"><img src="images/tempt/flag-macau.jpg"
                            alt="Macau SAR flag" /></span><span class="text">Macau SAR</span></a>
                <a class="pin p-mya" href="#myanmar"><span class="flag"><img src="images/tempt/flag-myanmar.jpg"
                            alt="Myanmar flag" /></span><span class="text">Myanmar</span></a>
                <a class="pin p-lao" href="#macau"><span class="flag"><img src="images/tempt/flag-laos.jpg"
                            alt="Laos flag" /></span><span class="text">Laos</span></a>
                <a class="pin p-ind" href="#india"><span class="flag"><img src="images/tempt/flag-india.jpg"
                            alt="India flag" /></span><span class="text">India</span></a>
                <a class="pin p-tha" href="#thailand"><span class="flag"><img src="images/tempt/flag-thailand.jpg"
                            alt="Thailand flag" /></span><span class="text">Thailand</span></a>
                <a class="pin p-vie" href="#vietnam"><span class="flag"><img src="images/tempt/flag-vietnam.jpg"
                            alt="Vietnam flag" /></span><span class="text">Vietnam</span></a>
                <a class="pin p-phi" href="#philippines"><span class="flag"><img src="images/tempt/flag-philippines.jpg"
                            alt="Philippines flag" /></span><span class="text">Philippines</span></a>
                <a class="pin p-sri" href="#sri"><span class="flag"><img src="images/tempt/flag-sri-lanka.jpg"
                            alt="Sri lanka flag" /></span><span class="text">Sri lanka</span></a>
                <a class="pin p-cam" href="#cambodia"><span class="flag"><img src="images/tempt/flag-combodia.jpg"
                            alt="cambodia flag" /></span><span class="text">cambodia</span></a>
                <a class="pin p-mal" href="#malaysia"><span class="flag"><img src="images/tempt/flag-malaysia.jpg"
                            alt="Malaysia flag" /></span><span class="text">Malaysia</span></a>
                <a class="pin p-bru" href="#brunei"><span class="flag"><img src="images/tempt/flag-brunei.jpg"
                            alt="brunei flag" /></span><span class="text">brunei</span></a>
                <a class="pin p-sin" href="#singapore"><span class="flag"><img src="images/tempt/flag-singapore.jpg"
                            alt="singapore flag" /></span><span class="text">singapore</span></a>
                <a class="pin p-indo" href="#indonesia"><span class="flag"><img src="images/tempt/flag-indonesia.jpg"
                            alt="Indonesia flag" /></span><span class="text">Indonesia</span></a>
                <!--<a class="pin p-tim" href="#timor"><span class="flag"><img src="images/tempt/flag-timor-leste.jpg" alt="TIMOR-LESTE flag" /></span><span class="text">TIMOR-LESTE</span></a>-->
                <a class="pin p-aus" href="#australia"><span class="flag"><img src="images/tempt/flag-australia.jpg"
                            alt="Australia flag" /></span><span class="text">Australia</span></a>
                <a class="pin p-new" href="#new"><span class="flag"><img src="images/tempt/flag-new-zealand.jpg"
                            alt="NEW ZEALAND flag" /></span><span class="text">NEW ZEALAND</span></a>
            </div>
            <!--<div id="mongolia" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>Mongolia</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <div id="china" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>China</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="japan" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Japan</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="nepal" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>Nepal</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <div id="korea" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Korea</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="bhutan" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>Bhutan</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <div id="taipei" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Chinese Taipei</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="afghanistan" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>Afghanistan</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <div id="hongkong" class="pin-pp openpp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Hongkong SAR</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="bangladesh" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>Bangladesh</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <!--<div id="pakistan" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>pakistan</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <div id="macau" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Macau SAR</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="myanmar" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Myanmar</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="laos" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Laos</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="india" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>India</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="thailand" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Thailand</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="vietnam" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Vietnam</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="philippines" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>philippines</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sri" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Sri lanka</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="cambodia" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Cambodia</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="malaysia" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Malaysia</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="brunei" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Brunei</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="singapore" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>singapore</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="indonesia" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Indonesia</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="timor" class="pin-pp">
                    <div class="tb-col">
                        <div class="col">
                            <div class="content">
                                <a href="#new" class="fas fa-times">Close</a>
                                <h2>TIMOR-LESTE</h2>
                                <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                                <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                            </div>
                        </div>
                    </div>
                </div>-->
            <div id="australia" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>Australia</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="new" class="pin-pp">
                <div class="tb-col">
                    <div class="col">
                        <div class="content">
                            <a href="#new" class="fas fa-times">Close</a>
                            <h2>NEW ZEALAND</h2>
                            <a class="fas fa-angle-double-right link" href="updates.html"><span class="ico"><img
                                        src="images/tempt/ico-5.png" alt="" /></span> Regulatory Updates</a>
                            <a class="fas fa-angle-double-right link" href="country.html"><span class="ico"><img
                                        src="images/tempt/ico-6.png" alt="" /></span> Country Information</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-home-1 container-fluid">
            <div class="row">
                <div class="col-sm-5">
                    <div class="intro spleft">
                        <h2>Latest Regulatory Updates</h2>
                        <p>Sed ut perspiciatis unde omnis iste natus error venenatis voluptatem accusantium
                            doloremque laudantium.</p>
                        <a class="btn-4" href="updates.html">See all</a>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="grid-2 slick-1">
                        <div class="item">
                            <div class="box-4">
                                <figure><img src="images/tempt/flag-korea.jpg" alt="thailand flag" /></figure>
                                <div class="content">
                                    <h3 class="title">Sample Title Here Regulatory</h3>
                                    <p class="date"><span class="country">thailand</span> | Jan 27, 2019</p>
                                    <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est,
                                        omnis dolor repellendus. Temporibus autem officiis quibusdam et aut debitis.
                                    </p>
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
                                    <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est,
                                        omnis dolor repellendus. Temporibus autem officiis quibusdam et aut debitis.
                                    </p>
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
                                    <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est,
                                        omnis dolor repellendus. Temporibus autem officiis quibusdam et aut debitis.
                                    </p>
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
                                    <p>Voluptatem accusantium doloremque laudantium. Omnis voluptas assumenda est,
                                        omnis dolor repellendus. Temporibus autem officiis quibusdam et aut debitis.
                                    </p>
                                    <p class="read-more">Read more <i class="fas fa-angle-double-right"></i></p>
                                </div>
                                <a class="detail" href="updates-details.html">View detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-home-2 tb-col break-720">
            <div class="col">
                <video controls>
                    <source src="videos/food.mp4" type="video/mp4">
                </video>
            </div>
            <div class="col spright">
                <h2>Insert Title Video Here</h2>
                <p>Sed ut perspiciatis unde omnis iste natus error venenatis voluptatem accusantium doloremque
                    laudantium. Lorem ipsum omnis venenatis vivamus magna dolor diam inste pellentesque natus set
                    perspiciatis.</p>
            </div>
        </div>
        @include('inc.subscription-footer')

    </div><!-- //main -->

</div><!-- //page -->
@endsection

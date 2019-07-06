<header class="header-container fixed-header">
    <div class="info">
        <div class="container">
            <div class="tb-col">
                <div class="col">
                    Hi Guest, Welcome to <strong>Food Industry Asia!</strong>
                </div>
                <div class="col text-right">
                    <a class="btn-1" href="sign-in.html">Sign in</a>
                    <a class="btn-2" href="register.html">Register</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="logo">
                <a href="{{url('/')}}"><img src="{{asset(setting()->logo)}}" alt="FIA" /></a>
            </div>
            <nav id="menu" class="menu">
                <div class="mb-btn clearfix">
                    <a class="btn-1" href="sign-in.html">Sign in</a>
                    <a class="btn-2" href="register.html">Register</a>
                </div>
                {!! get_menu_has_child(0,1,$page->id) !!}
                <!--<ul>
                    <li class="active"><a href="index.html">Home</a></li>
                    <li><a href="about.html">About us</a></li>
                    <li><a href="updates.html">regulatory updates</a></li>
                    <li><a href="reports.html">resources</a>
                        <ul>
                            <li><a href="reports.html">Topical Reports</a></li>
                            <li><a href="events.html">Upcoming Events</a></li>
                        </ul>
                    </li>
                    <li><a href="country.html">country information</a></li>
                </ul>-->
            </nav>
            <a href="#menu" class="control-page btn-menu">
                <span class="burger-icon-1"></span>
                <span class="burger-icon-2"></span>
                <span class="burger-icon-3"></span>
            </a>
        </div>
    </div>
</header>

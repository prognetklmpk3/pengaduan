<div class="container-fluid">
    <div class="nk-header-wrap">
        <div class="nk-menu-trigger d-xl-none ml-n1">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
        <div class="nk-header-brand d-xl-none">
            <a href="{{URL('/')}}" class="logo-link">
                <!-- <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark"> -->
                <img class="logo-light logo-img" src="{{asset('assets/images/logo-balimed.png')}}" srcset="{{asset('assets/images/logo-balimed.png')}}" alt="logo">
                <img class="logo-dark logo-img" src="{{asset('assets/images/logo-balimed.png')}}" srcset="{{asset('assets/images/logo-balimed.png')}}" alt="logo-dark">
            </a>
        </div><!-- .nk-header-brand -->
        <div class="nk-header-news d-none d-xl-block">
            <div class="nk-news-list">
                <a class="nk-news-item" href="#">
                    <div class="nk-news-icon">
                        <em class="icon ni ni-card-view"></em>
                    </div>
                    <div class="nk-news-text">
                        <!-- <p>Do you know the latest update of 2022? <span> A overview of our is now available on YouTube</span></p> -->
                        <p>Sistem Informasi Manajemen <span>CRUD<span></p>
                        <em class="icon ni ni-external"></em>
                    </div>
                </a>
            </div>
        </div><!-- .nk-header-news -->
        <div class="nk-header-tools">
            <ul class="nk-quick-nav">
                @guest
                <a href="/" class="btn btn-sm btn-primary">Login Pegawai</a>
                @endguest
                @auth
                <!-- .dropdown -->
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="d-flex align-items-center">
                            <div class="user-toggle mr-1">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                            </div>
                            <p>{{ Str::limit(Auth::guard('pegawai')->user()->nama, 15) }}</p>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1 is-light">
                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="lead-text">{{ Auth::guard('pegawai')->user()->nama }}</span>
                                    <span class="sub-text">{{ Auth::guard('pegawai')->user()->username }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-inner">
                            <ul class="link-list">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <em class="icon ni ni-signout"></em><span>Sign out</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- .dropdown -->
                @endauth
                
            </ul><!-- .nk-quick-nav -->
        </div><!-- .nk-header-tools -->
    </div><!-- .nk-header-wrap -->
</div><!-- .container-fliud -->
<div class="page-sidebar " id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
        <div class="user-info-wrapper sm">
            <div class="profile-wrapper sm">
                <img src="{{ asset('assets') }}/img/profiles/avatar.jpg" alt="" data-src="{{ asset('assets') }}/img/profiles/avatar.jpg"
                     data-src-retina="{{ asset('assets') }}/img/profiles/avatar2x.jpg" width="69" height="69"/>
                <div class="availability-bubble online"></div>
            </div>
            <div class="user-info sm">
                <div class="username">{{ \Illuminate\Support\Facades\Auth::user()->name }} <span class="semi-bold"></span></div>
                <div class="status">Life goes on...</div>
            </div>
        </div>
        <!-- END MINI-PROFILE -->
        <!-- BEGIN SIDEBAR MENU -->
        <p class="menu-title sm">BROWSE <span class="pull-right"><a href="javascript:;"><i class="material-icons">refresh</i></a></span>
        </p>
        <ul>
            <li>
                <a href="{{ action('HomeController@index') }}">
                    <i class="material-icons">home</i>
                    <span class="title">{{ @trans('labels.nav_home') }}</span>
                    <span class="label label-important bubble-only pull-right "></span>
                </a>
            </li>
{{--            <li>--}}
{{--                <a href="javascript:;"> <i class="material-icons">apps</i> <span--}}
{{--                            class="title">{{ @trans('labels.nav_countries') }}</span> <span class=" arrow"></span> </a>--}}
{{--                <ul class="sub-menu">--}}
{{--                    <li><a href="{{ action('CountryController@getIndex') }}">{{ @trans('labels.nav_list') }}</a></li>--}}
{{--                    <li><a href="{{ action('CountryController@getCreate') }}">{{ @trans('labels.nav_create') }}</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            <li>
                <a href="javascript:;"> <i class="material-icons">category</i> <span
                            class="title">{{ @trans('labels.nav_main_cats') }}</span> <span class=" arrow"></span> </a>
                <ul class="sub-menu">
                    <li><a href="{{ action('CategoryController@getIndex') }}">{{ @trans('labels.nav_list') }}</a></li>
                    <li><a href="{{ action('CategoryController@getCreate') }}">{{ @trans('labels.nav_create') }}</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"> <i class="material-icons">apps</i> <span
                            class="title">{{ @trans('labels.nav_services') }}</span> <span class=" arrow"></span> </a>
                <ul class="sub-menu">
                    <li><a href="{{ action('ServicesController@getIndex') }}">{{ @trans('labels.nav_list') }}</a></li>
                    <li><a href="{{ action('ServicesController@getCreate') }}">{{ @trans('labels.nav_create') }}</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"> <i class="material-icons">apps</i> <span
                            class="title">{{ @trans('labels.nav_job_types') }}</span> <span class=" arrow"></span> </a>
                <ul class="sub-menu">
                    <li><a href="{{ action('JobTypeController@getIndex') }}">{{ @trans('labels.nav_list') }}</a></li>
                    <li><a href="{{ action('JobTypeController@getCreate') }}">{{ @trans('labels.nav_create') }}</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"> <i class="material-icons">apps</i> <span
                            class="title">{{ @trans('labels.nav_devices') }}</span> <span class=" arrow"></span> </a>
                <ul class="sub-menu">
                    <li><a href="{{ action('DeviceTypeController@getIndex') }}">{{ @trans('labels.nav_list') }}</a></li>
                    <li><a href="{{ action('DeviceTypeController@getCreate') }}">{{ @trans('labels.nav_create') }}</a></li>
                </ul>
            </li>

            <li>
                <a href="javascript:;"> <i class="material-icons">apps</i> <span
                            class="title">{{ @trans('labels.nav_job_reqs') }}</span> <span class=" arrow"></span> </a>
                <ul class="sub-menu">
                    <li><a href="{{ action('JobReqController@getIndex') }}">{{ @trans('labels.nav_list') }}</a></li>
                </ul>
            </li>


        </ul>

        <div class="clearfix"></div>
        <!-- END SIDEBAR MENU -->
    </div>
</div>

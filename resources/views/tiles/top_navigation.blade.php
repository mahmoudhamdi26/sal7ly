<?php
/**
 * Created by PhpStorm.
 * User: mhamdi
 * Date: 3/18/19
 * Time: 8:18 PM
 */
?>
<div class="navbar-inner">
    <div class="header-seperation">
        <ul class="nav pull-left notifcation-center visible-xs visible-sm">
            <li class="dropdown">
                <a href="#main-menu" data-webarch="toggle-left-side">
                    <i class="material-icons">menu</i>
                </a>
            </li>
        </ul>
        <!-- BEGIN LOGO -->
        <a href="index.html">
            <img src="{{ asset('assets') }}/img/logo.png" class="logo" alt="" data-src="{{ asset('assets') }}/img/logo.png"
                 data-src-retina="{{ asset('assets') }}/img/logo2x.png" width="106" height="21"/>
        </a>
        <!-- END LOGO -->
        <ul class="nav pull-right notifcation-center">
            <li class="dropdown hidden-xs hidden-sm">
                <a href="index.html" class="dropdown-toggle active" data-toggle="">
                    <i class="material-icons">home</i>
                </a>
            </li>
            <li class="dropdown hidden-xs hidden-sm">
                <a href="email.html" class="dropdown-toggle">
                    <i class="material-icons">email</i><span class="badge bubble-only"></span>
                </a>
            </li>
            <li class="dropdown visible-xs visible-sm">
                <a href="#" data-webarch="toggle-right-side">
                    <i class="material-icons">chat</i>
                </a>
            </li>
        </ul>
    </div>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <div class="header-quick-nav">
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="pull-left">
            <ul class="nav quick-section">
                <li class="quicklinks">
                    <a href="#" class="" id="layout-condensed-toggle">
                        <i class="material-icons">menu</i>
                    </a>
                </li>
            </ul>
            <ul class="nav quick-section">
                <li class="quicklinks  m-r-10">
                    <a href="{{ action('HomeController@index') }}" class="">
                        <i class="material-icons">refresh</i>
                    </a>
                </li>
                <li class="quicklinks"><span class="h-seperate"></span></li>
                <li class="quicklinks">
                    <a href="#" class="" id="my-task-list" data-placement="bottom" data-content=''
                       data-toggle="dropdown" data-original-title="Notifications">
                        <i class="material-icons">notifications_none</i>
                        <span class="badge badge-important bubble-only"></span>
                    </a>
                </li>
                <li class="m-r-10 input-prepend inside search-form no-boarder">
                    <span class="add-on"> <i class="material-icons">search</i></span>
                    <input name="" type="text" class="no-boarder " placeholder="Search Dashboard"
                           style="width:250px;">
                </li>
            </ul>
        </div>
        <div id="notification-list" style="display:none">
            @include('tiles.notifications')
        </div>
        <!-- END TOP NAVIGATION MENU -->
        <!-- BEGIN CHAT TOGGLER -->
        <div class="pull-right">
            <div class="chat-toggler sm">
                <div class="profile-pic">
                    <img src="{{ asset('assets') }}/img/profiles/avatar_small.jpg" alt=""
                         data-src="{{ asset('assets') }}/img/profiles/avatar_small.jpg"
                         data-src-retina="{{ asset('assets') }}/img/profiles/avatar_small2x.jpg" width="35" height="35"/>
                    <div class="availability-bubble online"></div>
                </div>
            </div>
            <ul class="nav quick-section ">
                <li class="quicklinks">
                    <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                        <i class="material-icons">tune</i>
                    </a>
                    <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                        <li>
                            <a href="user-profile.html"> My Account</a>
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="calender.html">My Calendar</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="email.html"> My Inbox&nbsp;&nbsp;--}}
                                {{--<span class="badge badge-important animated bounceIn">2</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li class="divider"></li>
                        <li>
                            <a href="{{ action('LoginController@getLogout') }}"><i class="material-icons">power_settings_new</i>&nbsp;&nbsp;{{ @trans('labels.nav_logout') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="quicklinks"><span class="h-seperate"></span></li>
            </ul>
        </div>
        <!-- END CHAT TOGGLER -->
    </div>
    <!-- END TOP NAVIGATION MENU -->
</div>

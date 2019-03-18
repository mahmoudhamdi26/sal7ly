<?php
/**
 * Created by PhpStorm.
 * User: mhamdi
 * Date: 3/18/19
 * Time: 8:08 PM
 */
?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8"/>
    <title>Webarch - Responsive Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets') }}/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets') }}/plugins/jquery-metrojs/MetroJs.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/plugins/shape-hover/css/demo.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/plugins/shape-hover/css/component.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/plugins/owl-carousel/owl.carousel.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/plugins/owl-carousel/owl.theme.css"/>
    <link href="{{ asset('assets') }}/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="{{ asset('assets') }}/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css"
          media="screen"/>
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/jquery-ricksaw-chart/css/rickshaw.css" type="text/css" media="screen">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/Mapplic/mapplic/mapplic.css" type="text/css" media="screen">
    <!-- END PLUGIN CSS -->
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets') }}/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="{{ asset('assets') }}/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets') }}/plugins/bootstrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets') }}/plugins/animate.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets') }}/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css"/>
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="{{ asset('webarch') }}/css/webarch.css" rel="stylesheet" type="text/css"/>
    <!-- END CORE CSS FRAMEWORK -->

    @yield('css')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse ">
    <!-- BEGIN TOP NAVIGATION BAR -->
@include('tiles.top_navigation')
<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
    <!-- BEGIN SIDEBAR -->
    @include('tiles.side_nav')
    <a href="#" class="scrollup">Scroll</a>
@include('tiles.side_footer')
<!-- END SIDEBAR -->
    <!-- BEGIN PAGE CONTAINER-->
    @if(Session::has('message'))
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <div class="alert alert-info alert-{{ Session::get('alert-class', 'info') }}">
                <p>Test {{ Session::get('message') }}</p>
            </div>
        </div>
    </div>
@endif
@yield('content')
<!-- BEGIN CHAT -->
@include('tiles.chat_window')
<!-- END CHAT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script src="{{ asset('assets') }}/plugins/pace/pace.min.js" type="text/javascript"></script>
<!-- BEGIN JS DEPENDECENCIES-->
<script src="{{ asset('assets') }}/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<!-- END CORE JS DEPENDECENCIES-->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{ asset('webarch') }}/js/webarch.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/js/chat.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="{{ asset('assets') }}/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-ricksaw-chart/js/raphael-min.js"></script>
<script src="{{ asset('assets') }}/plugins/jquery-ricksaw-chart/js/d3.v2.js"></script>
<script src="{{ asset('assets') }}/plugins/jquery-ricksaw-chart/js/rickshaw.min.js"></script>
<script src="{{ asset('assets') }}/plugins/jquery-sparkline/jquery-sparkline.js"></script>
<script src="{{ asset('assets') }}/plugins/skycons/skycons.js"></script>
<script src="{{ asset('assets') }}/plugins/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="{{ asset('assets') }}/plugins/jquery-gmap/gmaps.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/Mapplic/js/jquery.easing.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/Mapplic/js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/Mapplic/js/hammer.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/Mapplic/mapplic/mapplic.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-flot/jquery.flot.js" type="text/javascript"></script>
<script src="{{ asset('assets') }}/plugins/jquery-metrojs/MetroJs.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="{{ asset('assets') }}/js/dashboard_v2.js" type="text/javascript"></script>
@yield('scripts')
</body>
</html>

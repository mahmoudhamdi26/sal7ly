<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 2/10/17
 * Time: 3:23 PM
 */
        ?>

@extends('layouts.app')

@section('app_header')
    <div class="app-header white bg b-b">
        <div class="navbar" data-pjax>
            <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
                <i class="ion-navicon"></i>
            </a>
            <!-- link and dropdown -->
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <span class="navbar-item text-md">Users</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="{{ action('AccountsController@getCreate') }}">
				            <span class="">
				            	<i class="fa fa-fw fa-plus"></i>
				            	<span class="hidden-sm-down">New User</span>
				            </span>
                    </a>
                </li>
            </ul>
            <!-- / link and dropdown -->

            <!-- nabar right -->
        @include('tiles.nav_bar_right')
        <!-- / navbar right -->
        </div>
    </div>

    {{--<div class="app-header hidden-lg-up black lt b-b">--}}
        {{--<div class="navbar" data-pjax>--}}
            {{--<a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">--}}
                {{--<i class="ion-navicon"></i>--}}
            {{--</a>--}}
            {{--<div class="navbar-item pull-left h5" id="pageTitle">Users</div>--}}

            {{--<!-- nabar right -->--}}
        {{--@include('tiles.nav_bar_right')--}}
        {{--<!-- / navbar right -->--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection

@section('content')
    <div class="app-body-inner">
        @if(Session::has('message'))
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                    <div class="alert alert-{{ Session::get('alert-class', 'info') }}">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="row-col">
            <div class="white hide bg b-b">
                <div class="navbar no-radius box-shadow-z1">
                    <a data-toggle="modal" data-target="#subnav" data-ui-modal class="navbar-item pull-left hidden-lg-up">
					<span class="btn btn-sm btn-icon info">
			      		<i class="fa fa-th"></i>
			        </span>
                    </a>
                    <a data-toggle="modal" data-target="#list" data-ui-modal class="navbar-item pull-left hidden-md-up">
			    	<span class="btn btn-sm btn-icon white">
			      		<i class="fa fa-list"></i>
			      	</span>
                    </a>
                    <!-- link and dropdown -->
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <span class="navbar-item text-md">Users</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted" href="{{ action('AccountsController@getCreate') }}">
				            <span class="">
				            	<i class="fa fa-fw fa-plus"></i>
				            	<span class="hidden-sm-down">New User</span>
				            </span>
                            </a>
                        </li>
                    </ul>
                    <!-- / link and dropdown -->
                </div>
            </div>


            <div class="row-row">
                <div class="row-col">
                    <div class="col-xs w modal fade aside aside-md b-r" id="subnav">
                        <div class="row-col light bg">
                            <!-- flex content -->
                            <div class="row-row">
                                <div class="row-body scrollable hover">
                                    <div class="row-inner">
                                        <!-- content -->
                                        <div class="navside m-t">
                                            <nav class="nav-border b-primary" data-ui-nav>
                                                <ul class="nav">
                                                    <li id="roleItemAll" class="active" onclick="getContacts(this)">
                                                        <a href="#">
												      	<span class="nav-label">
									                    	<b class="label warn rounded hide" id="allTotalText">{{ $usersCount }}</b>
									                  	</span>
                                                            <span class="nav-text">All</span>
                                                        </a>
                                                    </li>
                                                    @foreach($roles as $role)
                                                        <li id="roleItem{{ $role->id }}" onclick="getContacts(this)" data-role="{{ $role->id }}">
                                                            <a href="#">
                                                                <span class="nav-label">
                                                                    <b class="label primary rounded hide">{{ $role->num_of_users }}</b>
                                                                </span>
                                                                <span class="nav-text">{{ $role->label }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / -->
                            <!-- footer -->
                            <div class="p-a b-t">
                                <a href="#" class="btn btn-xs rounded primary"  data-toggle="modal" data-target="#modal-new-group" title="New Group"><i class="fa fa-plus m-r-xs"></i> New Group</a>
                            </div>
                            <!-- / -->
                        </div>
                    </div>
                    <div class="col-xs modal fade aside aside-sm  b-r" id="list">
                        <div class="row-col">
                            <div class="row-row">
                                <div class="row-col">
                                    <!-- col -->
                                    <div class="col-xs w-40 white bg b-r">
                                        <div class="row-col">
                                            <div class="row-row">
                                                <div class="row-body scrollable hover">
                                                    <div class="row-inner">
                                                        <div class="text-center text-sm p-y-sm">
                                                            <a href="#" class="block text-muted">A</a>
                                                            <a href="#" class="block text-muted active text-primary _600">B</a>
                                                            <a href="#" class="block text-muted">C</a>
                                                            <a href="#" class="block text-muted">D</a>
                                                            <a href="#" class="block text-muted">E</a>
                                                            <a href="#" class="block text-muted">F</a>
                                                            <a href="#" class="block text-muted">G</a>

                                                            <a href="#" class="block text-muted">H</a>
                                                            <a href="#" class="block text-muted">I</a>
                                                            <a href="#" class="block text-muted">J</a>
                                                            <a href="#" class="block text-muted">K</a>
                                                            <a href="#" class="block text-muted">L</a>
                                                            <a href="#" class="block text-muted">M</a>
                                                            <a href="#" class="block text-muted">N</a>

                                                            <a href="#" class="block text-muted">O</a>
                                                            <a href="#" class="block text-muted">P</a>
                                                            <a href="#" class="block text-muted">Q</a>
                                                            <a href="#" class="block text-muted">R</a>
                                                            <a href="#" class="block text-muted">S</a>
                                                            <a href="#" class="block text-muted">T</a>

                                                            <a href="#" class="block text-muted">U</a>
                                                            <a href="#" class="block text-muted">V</a>
                                                            <a href="#" class="block text-muted">W</a>
                                                            <a href="#" class="block text-muted">X</a>
                                                            <a href="#" class="block text-muted">Y</a>
                                                            <a href="#" class="block text-muted">Z</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- col -->
                                    <div class="col-xs">
                                        <div class="row-col white bg">
                                            <!-- flex content -->
                                            <div class="row-row">
                                                <div class="row-body scrollable hover">
                                                    <div class="row-inner">
                                                        <!-- left content -->
                                                        <div id="usersListContainer" class="list" data-ui-list="b-r b-3x b-primary" data-ui-list-target="#detail" data-ui-list-target-class="show">

                                                        </div>
                                                        <!-- / -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- / -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- footer -->
                            <div class="white bg p-a b-t clearfix">
                                <div class="btn-group pull-right">
                                    <a href="#" onclick="prevPage()"
                                       class="btn btn-xs white circle"><i class="fa fa-fw fa-angle-left"></i></a>
                                    <a href="#" onclick="nextPage()"
                                       class="btn btn-xs white circle"><i class="fa fa-fw fa-angle-right"></i></a>
                                </div>
                                <span class="text-sm text-muted">Total: <strong id="spanTotal"></strong></span>
                            </div>
                            <!-- / -->
                        </div>
                    </div>
                    <div class="col-xs hidden-lg-up" id="detail">
                        <div class="row-col white bg">
                            <!-- flex content -->
                            <div class="row-row">
                                <div class="row-body scrollable hover">
                                    <div class="row-inner">
                                        <!-- content -->
                                        <div class="p-a-lg text-center">
                                            <img id="detailsImg" src="images/a3.jpg" class="w circle animated rollIn" alt=".">
                                            <div class="animated fadeInUp">
                                                <div>
                                                    <span id="spanName" class="text-md m-t block">Mohamed Ramadan</span>
                                                    <small id="spanJob" class="text-muted">Consultant / Admin</small>
                                                </div>
                                                <div class="block clearfix m-t hide">
                                                    <a href="" class="btn btn-icon btn-social rounded indigo">
                                                        <i class="fa fa-facebook"></i>
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                    <a href="" class="btn btn-icon btn-social rounded light-blue">
                                                        <i class="fa fa-twitter"></i>
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                    <a href="" class="btn btn-icon btn-social rounded red">
                                                        <i class="fa fa-google-plus"></i>
                                                        <i class="fa fa-google-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-a-md animated fadeInUp">
                                            <ul class="nav">
                                                <li class="nav-item m-b-xs">
                                                    <a class="nav-link text-muted block">
								                	<span class="pull-right text-sm">
								                		<i class="fa fa-fw fa-phone"></i>
								                	</span>
                                                        <span id="spanPhone">0122 2367626</span>
                                                    </a>
                                                </li>
                                                {{--<li class="nav-item m-b-xs">--}}
                                                    {{--<a class="nav-link text-muted block">--}}
								                	{{--<span class="pull-right text-sm">--}}
								                		{{--<i class="fa fa-fw fa-birthday-cake"></i>--}}
								                	{{--</span>--}}
                                                        {{--<span id="spanBirthdate">July 03</span>--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                                <li class="nav-item m-b-xs">
                                                    <a class="nav-link text-muted block">
								                	<span class="pull-right text-sm">
								                		<i class="fa fa-fw fa-envelope"></i>
								                	</span>
                                                        <span id="spanEmail">example@example.com</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- / -->
                                    </div>
                                </div>
                            </div>
                            <!-- / -->

                            <!-- footer -->
                            <div class="p-a b-t clearfix">
                                <div class="pull-right">
                                    <a id="aLinkDetailsdeleteUser"
                                       onclick="return confirm('Are you sure you want to delete this item?');"
                                       href="#" class="btn btn-xs white rounded">
                                        <i class="fa fa-trash m-r-xs"></i>
                                        Delete
                                    </a>
                                </div>
                                <a id="aLinkDetailsEditUser" href="#" class="btn btn-xs primary rounded">
                                    <i class="fa fa-pencil m-r-xs"></i>
                                    Edit
                                </a>
                            </div>
                            <!-- / -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-new-group">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ action('ACLController@postCreateRole') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Group</h5>
                    </div>
                    <div class="modal-body text-center p-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Group Name</label>
                            <input type="text" class="form-control" name="label"
                                   id="exampleInputEmail1" placeholder="Group Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                        <button type="submit" class="btn success p-x-md">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        var nextURL = null;
        var prevURL = null;

        $(document).ready(function(){
            getContacts($('#roleItemAll'));
        });

        function getContacts(ele){
            var url = '{{ action('AccountsController@getFilter') }}';
            var roleid = $(ele).attr('data-role');
            if(roleid != undefined){
                url = url+'?roles_id='+roleid;
            }
            getContactsAjax(url);
        }
        function getContactsAjax(url){
            $.ajax({
                url: url,
                success: function (result) {
                    var next = $(result).attr('data-next');
                    if(next!='' && next!=undefined){
                        nextURL = next;
                    }else{
                        nextURL = null;
                    }

                    var prev = $(result).attr('data-prev');
                    if(prev!='' && prev!=undefined){
                        prevURL = prev;

                    }else{
                        prevURL = null;
                    }

                    var total = $(result).attr('data-total');
                    $('#spanTotal').html(total);
//                    $('#allTotalText').html(total).show();
                    $('#usersListContainer').html($(result).html());
                    $('#detail').removeClass('show');


                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /// Show error message
                    alert('Something went wrong, Please try again.');
                }
            });
        }

        function nextPage(){
            if(nextURL != '' && nextURL != null && nextURL != undefined){
                getContactsAjax(nextURL);
            }
        }

        function prevPage(){
            if(prevURL != '' && prevURL != null && prevURL != undefined){
                getContactsAjax(prevURL);
            }
        }

        function userDetails(ele){
            console.log(ele);
            var email = $(ele).attr('data-email');

            $('#spanBirthdate').html(($(ele).attr('data-bdate')==''||$(ele).attr('data-bdate')==undefined)?'{{ trans('labels.unset') }}':$(ele).attr('data-bdate'));
            $('#spanName').html($(ele).attr('data-name'));
            $('#spanEmail').html($(ele).attr('data-email'));
            $('#spanJob').html($(ele).attr('data-job'));
            $('#spanPhone').html($(ele).attr('data-phone'));
            $('#spanLocation').html($(ele).attr('data-location'));
            $('#detailsImg').attr('src', $(ele).attr('data-img'));
            $('#aLinkDetailsEditUser').attr('href', $(ele).attr('data-edit'));
            $('#aLinkDetailsdeleteUser').attr('href', $(ele).attr('data-delete'));
            if(email == '{{ config('app.super-admin') }}'){
                $('#aLinkDetailsdeleteUser').hide();
            }else{
                $('#aLinkDetailsdeleteUser').show();
            }
        }

        function activate(ele){
            var url = $(ele).attr('data-url');
            var id = $(ele).attr('data-id');

            $.ajax({
                url: url,
                success: function (result) {
                    $('#aLinkActivate'+id).hide();
                    $('#aLinkDeactivate'+id).show();
                    $('#listItem'+id).removeClass('danger');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /// Show error message
                    alert('Something went wrong, Please try again.');
                }
            });
        }

        function deactivate(ele){
            var url = $(ele).attr('data-url');
            var id = $(ele).attr('data-id');

            $.ajax({
                url: url,
                success: function (result) {
                    $('#aLinkActivate'+id).show();
                    $('#aLinkDeactivate'+id).hide();
                    $('#listItem'+id).addClass('danger');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /// Show error message
                    alert('Something went wrong, Please try again.');
                }
            });
        }

        function delete_user(ele){
            var url = $(ele).attr('data-url');
            var id = $(ele).attr('data-id');

            $.ajax({
                url: url,
                success: function (result) {
                    $('#aLinkDelete'+id).remove();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /// Show error message
                    alert('Something went wrong, Please try again.');
                }
            });
        }

    </script>
@endsection
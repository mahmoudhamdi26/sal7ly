<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 2/12/17
 * Time: 4:19 PM
 */
        ?>
@extends('layouts.app')

@section('app_header')
    <div class="app-header white bg b-b">
        <div class="navbar" data-pjax>
            <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
                <i class="ion-navicon"></i>
            </a>
            <div class="navbar-item pull-left h5" id="pageTitle">Create New Account</div>
            <!-- nabar right -->
            @include('tiles.nav_bar_right')
            <!-- / navbar right -->
        </div>
    </div>

@endsection

@section('content')
<div class="padding">
    <form action="{{ action('AccountsController@postCreate') }}" method="post">
        {!! csrf_field() !!}
    <div class="row">
        {{--<div class="col-md-12">--}}
            {{--@foreach ($errors->all() as $error)--}}
                {{--<div>{{ $error }}</div>--}}
            {{--@endforeach--}}
        {{--</div>--}}

        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h2>User Information</h2>
                    <!-- <small>Use Bootstrap's predefined grid classes to align labels and groups of form controls in a horizontal layout by adding .form-horizontal to the form. Doing so changes .form-groups to behave as grid rows, so no need for .row.</small> -->
                </div>
                <div class="box-divider m-a-0"></div>
                <div class="box-body">
                    <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('isadmin') ? ' has-error' : '' }}">
                        <label for="isadmin" class="col-md-4 control-label">Is Admin</label>

                        <div class="col-md-6">
                            <select id="isadmin" class="form-control" name="isadmin" onchange="typeChanged()" required>
                                <option>{{ trans('labels.select') }}</option>
                                {{--<option value="ADMIN">Admin</option>--}}
                                <option @if(old('isadmin')) selected @endif value="1">Yes</option>
                                <option @if(!old('isadmin')) selected @endif value="0">No</option>
                            </select>

                            @if ($errors->has('isadmin'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('isadmin') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('job') ? ' has-error' : '' }}">
                        <label for="job" class="col-md-4 control-label">Job</label>

                        <div class="col-md-6">
                            <input id="job" type="text" class="form-control" name="job" value="{{ old('job') }}" required>

                            @if ($errors->has('job'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('job') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-4 control-label">phone</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control"
                                   name="phone" value="{{ old('phone') }}" required>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box" id="aclContainer" @if(empty(old('isadmin')) || old('isadmin') != '1') style="display: none;" @endif>
                <div class="box-header">
                    <h2>ACL Groups</h2>
                </div>
                <div class="box-divider m-a-0"></div>
                <div class="box-body">
                    <div class="form-group row">
                        <div class="box-body">
                            @foreach($roles as $role)
                                <label><input type="radio" class="chkRole"
                                              data-name="{{ $role->label }}"
                                            {{ (old("roles") != null &&  in_array($role->id, old("roles")))?'checked':'' }}
                                              name="roles[]" value="{{ $role->id }}">{{ $role->label }}</label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-body">
                    <div class="form-group row m-t-md">
                        <div class="col-sm-offset-2 col-sm-10 text-center">
                            <button class="btn btn-fw success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('libs/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('.mydatepicker').datetimepicker({
                'format':'D-M-YYYY'
            });
        });

        {{--$(document).ready(function(){--}}
           {{--@if(!empty(old('countries_id')))--}}
            {{--getInstitutions($('#countries_id'));--}}
            {{--@endif--}}
        {{--});--}}


        function typeChanged(){
            var val = $('#isadmin').val();
            if(val == '1'){
                $('#aclContainer').show();
            }else{
                $('#aclContainer').hide();
                $( ".chkRole" ).each(function( index ) {
                    $(this).removeAttr('checked');
                });
            }
        }

    </script>
@endsection
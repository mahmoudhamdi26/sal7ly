<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 1/23/17
 * Time: 7:14 AM
 */
        ?>

@extends('layouts.app_no_side')

@section('content')

    <div class="padding">
        <div class="navbar">
            <div class="pull-center">
                <!-- brand -->
                <a href="#" class="navbar-brand">
                    <div data-ui-include="'images/logo.svg'"></div>
                    <img src="images/logo.png" alt="." class="hide">
                    <span class="hidden-folded inline">123 Kora</span>
                </a>
                <!-- / brand -->
            </div>
        </div>
    </div>
    <div class="b-t">
        <div class="center-block w-xxl w-auto-xs p-y-md text-center">
            <div class="p-a-md">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="m-b-md">
                        <label class="md-check">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}>
                            <i class="primary"></i> Keep me signed in
                        </label>
                    </div>
                    <button type="submit" class="btn btn-lg black p-x-lg">Sign in</button>
                </form>
                <div class="m-y">
                    <a href="javascript: restorePass();" class="_600">Forgot password?</a>
                </div>
                <div class="hide">
                    Do not have an account?
                    <a href="signup.html" class="text-primary _600">Sign up</a>
                </div>
            </div>
        </div>
    </div>


    <div id="modalRestorePass" class="modal" data-backdrop="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ action('LoginController@postResetPassword') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('labels.restore_pass') }}</h5>
                    </div>
                    <div class="modal-body text-center p-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ trans('labels.msg_restore_password') }}</label>
                            <input type="email" class="form-control" name="email"
                                   value="{{ old('email') }}"
                                   id="exampleInputEmail1" placeholder="{{ trans('labels.email') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn success p-x-md">Restore</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

    <script>
        function restorePass() {
            $('#modalRestorePass').modal('show');
        }
    </script>

@endsection

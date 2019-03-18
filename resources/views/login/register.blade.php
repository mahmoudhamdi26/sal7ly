<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 1/23/17
 * Time: 6:51 AM
 */
?>



    <div class="container">
        <div class="row">
            <form class="form-horizontal" action="{{ action('LoginController@postRegister') }}" method="POST"
                  role="form">
                {!! csrf_field() !!}

                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="" class="col-md-4 control-label">{{ trans('labels.fname') }}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" id="" value="{{ old('name') }}"
                               name="name" placeholder="First Name">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('lname') ? ' has-error' : '' }}">
                    <label for="" class="col-md-4 control-label">{{ trans('labels.lname') }}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" id="" value="{{ old('lname') }}"
                               placeholder="Last Name" name="lname">
                        @if ($errors->has('lname'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="" class="col-md-4 control-label">{{ trans('labels.email') }}</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" id="" value="{{ old('email') }}"
                               placeholder="Email" name="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="" class="col-md-4 control-label">{{ trans('labels.phone') }}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" id="" value="{{ old('phone') }}"
                               placeholder="Phone" name="phone">
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                {{--Role--}}
                {{--<div class="form-group {{ $errors->has('account_type') ? ' has-error' : '' }}">--}}
                {{--<label for="">Account Type</label>--}}
                {{--<select class="form-control" id="" name="account_type">--}}
                {{--<option selected value="USER">User</option>--}}
                {{--<option value="BROKER">Broker</option>--}}
                {{--<option value="COMPANY">Company</option>--}}
                {{--</select>--}}
                {{--@if ($errors->has('account_type'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('account_type') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
                {{--</div>--}}

                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="" class="col-md-4 control-label">{{ trans('labels.password')}}</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" id="" value="{{ old('password') }}"
                               placeholder="Password" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-blue">{{ trans('labels.signup') }}</button>
                </div>

            </form>
        </div>
    </div>
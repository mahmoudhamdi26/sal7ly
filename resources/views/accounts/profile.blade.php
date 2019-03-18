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
            <!-- link and dropdown -->
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <span class="navbar-item text-md">Edit {{ $model->name }}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" data-toggle="modal" data-target="#modal-new" title="Reply">
      				            <span class="" onclick="updatePassword()">
      				            	<i class="fa fa-fw fa-lock"></i>
      				            	<span class="hidden-sm-down">Update Password</span>
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

@endsection


@section('content')
    <div class="padding">

        @if(Session::has('message'))
            <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                    <div class="alert alert-{{ Session::get('alert-class', 'info') }}">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ action('AccountsController@postUpdateProfile') }}" method="post">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-12">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>

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
                                    <input id="name" type="text" class="form-control"
                                           name="name" value="{{ $model->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-4 form-control-label">Birth Date</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' name="birth_date"
                                               value="{{ (empty($model->birth_date))?'':$model->birth_date->format('d-m-Y') }}"
                                               class="form-control mydatepicker"/>
                                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('job') ? ' has-error' : '' }}">
                                <label for="job" class="col-md-4 control-label">Job</label>

                                <div class="col-md-6">
                                    <input id="job" type="text" class="form-control"
                                           name="job" value="{{ $model->job }}" required>

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
                                           name="phone" value="{{ $model->phone }}" required>

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            @if($model->email != config('app.super-admin') && $model->email != 'test@aol.com')
                                <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control"
                                               name="email" value="{{ $model->email }}" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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

        <div id="modalChangePassword" class="modal" data-backdrop="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ action('AccountsController@postUpdateProfilePassword') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <h5 class="modal-title">Update Password</h5>
                        </div>
                        <div class="modal-body text-center p-lg">
                            <div class="form-group">
                                {{--<label for="idOldPassword">Old Password</label>--}}
                                <input type="text" class="form-control" name="oldpass"
                                       id="idOldPassword" placeholder="Old Password">
                            </div>
                        </div>

                        <div class="modal-body text-center p-lg">
                            <div class="form-group">
                                {{--<label for="idNewPassword">New Password</label>--}}
                                <input type="text" class="form-control" name="pass"
                                       id="idNewPassword" placeholder="New Password">
                            </div>
                        </div>

                        <div class="modal-body text-center p-lg">
                            <div class="form-group">
                                {{--<label for="idCNewPassword">Confirm Password</label>--}}
                                <input type="text" class="form-control" name="cpass"
                                       id="idCNewPassword" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                            <button type="submit" class="btn success p-x-md">Yes</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet"
          href="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('libs/moment/moment.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        function updatePassword() {
            $('#modalChangePassword').modal('show');
        }

        $(function () {
            $('.mydatepicker').datetimepicker({
                'format': 'D-M-YYYY'
            });
            roleChangedWithoutFetch();
        });


        function roleChangedWithoutFetch() {
//            var roleName = $(ele).attr('data-name');
            var roleName = $("input[name='roles[]']:checked").attr('data-name');

            if (roleName == '{{ trans('labels.para_focal') }}') {
                $('#countryContainer').show();
                $('#countries_id').attr('required', 'required');
                if ($('#institutions_id')) {
                    $('#institutions_id').attr('required');
                }
            }
            else if (roleName == '{{ trans('labels.para_qc') }}') {
                $('#countryContainer').show();
                $('#countries_id').removeAttr('required');
                $('#institutions_container').html('');
            }
            else if (roleName == '{{ trans('labels.para_publisher') }}') {
                $('#countryContainer').show();
                $('#countries_id').removeAttr('required');
                $('#institutions_container').html('');
            }
            else if (roleName == '{{ trans('labels.para_admin') }}') {
                $('#countryContainer').hide();
                $('#countries_id').removeAttr('required').val('');
                $('#institutions_container').html('');
            }
        }

        function roleChanged() {
//            var roleName = $(ele).attr('data-name');
            var roleName = $("input[name='roles[]']:checked").attr('data-name');

            if (roleName == '{{ trans('labels.para_focal') }}') {
                $('#countryContainer').show();
                $('#countries_id').attr('required', 'required');
                if ($('#institutions_id')) {
                    $('#institutions_id').attr('required');
                }
                getInstitutions($('#countries_id'));
            }
            else if (roleName == '{{ trans('labels.para_qc') }}') {
                $('#countryContainer').show();
                $('#countries_id').removeAttr('required');
                $('#institutions_container').html('');
            }
            else if (roleName == '{{ trans('labels.para_publisher') }}') {
                $('#countryContainer').show();
                $('#countries_id').removeAttr('required');
                $('#institutions_container').html('');
            }
            else if (roleName == '{{ trans('labels.para_admin') }}') {
                $('#countryContainer').hide();
                $('#countries_id').removeAttr('required').val('');
                $('#institutions_container').html('');
            }
        }

        function getInstitutions(ele) {
            var countryid = $(ele).val();
            if (countryid == '' || countryid == undefined) {
                $('#institutions_container').html('');
                return;
            }

            var roleName = $("input[name='roles[]']:checked").attr('data-name');
            if (roleName != undefined && roleName != '') {
                if (roleName == '{{ trans('labels.para_admin') }}'
                    || roleName == '{{ trans('labels.para_publisher') }}'
                    || roleName == '{{ trans('labels.para_qc') }}') {
                    return;
                }
            }

            var url = '{{ action('InstitutionsController@getInstitutionsByCountry', '0') }}';
            url = url.replace('/0', '/' + countryid);

            $.ajax({
                url: url,
                success: function (result) {
                    $('#institutions_container').html(result);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /// Show error message
                    alert('Something went wrong, Please try again.');
                }
            });

        }


        function typeChanged() {
            var val = $('#account_type').val();
            if (val == 'GOVERN') {
                $('#aclContainer').show();
            } else {
                $('#aclContainer').hide();
                $(".chkRole").each(function (index) {
                    $(this).removeAttr('checked');
                });
            }
        }
    </script>
@endsection
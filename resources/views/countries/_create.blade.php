<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 3/25/16
 * Time: 1:41 PM
 */
        ?>

@extends('layouts.app')

@section('app_header')
    <div class="app-header white bg b-b">
        <div class="navbar" data-pjax>
            <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
                <i class="ion-navicon"></i>
            </a>
            <div class="navbar-item pull-left h5" id="pageTitle">Create New Country</div>
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
        <form class="form-horizontal" role="form" enctype="multipart/form-data"
              method="POST" action="{{ action('CountryController@postStore') }}">
            {!! csrf_field() !!}
            <div class="row">
                {{--<div class="col-md-12">--}}
                {{--@foreach ($errors->all() as $error)--}}
                {{--<div>{{ $error }}</div>--}}
                {{--@endforeach--}}
                {{--</div>--}}

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h2>{{trans('labels.add_new')}}  </h2>
                            <!-- <small>Use Bootstrap's predefined grid classes to align labels and groups of form controls in a horizontal layout by adding .form-horizontal to the form. Doing so changes .form-groups to behave as grid rows, so no need for .row.</small> -->
                        </div>
                        <div class="box-divider m-a-0"></div>
                        <div class="box-body">
                            {!! csrf_field() !!}

                            <div class="form-group row required {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">{{trans('labels.name')}}</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           required="">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row required {{ $errors->has('name_ar') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">{{trans('labels.name_ar')}}</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar') }}"
                                           required="">

                                    @if ($errors->has('name_ar'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row required {{ $errors->has('abbreviation') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">{{trans('labels.abbreviation')}}</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="abbreviation" value="{{ old('abbreviation') }}"
                                           required="">

                                    @if ($errors->has('abbreviation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('abbreviation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row required {{ $errors->has('stats_id') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">{{trans('labels.stats_id')}}</label>

                                <div class="col-md-7">
                                    <input type="number" class="form-control" name="stats_id" value="{{ old('stats_id') }}"
                                           required="">

                                    @if ($errors->has('stats_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('stats_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row required {{ $errors->has('leagues') ? ' has-error' : '' }}">
                                <label class="col-md-3 control-label">{{trans('labels.leagues')}}</label>

                                <div class="col-md-7">
                                    <select  multiple="multiple"  name="leagues[]" size="5" class="form-control select2">
                                        @foreach ($leagues as $key => $league)
                                            <option value="{{ $league->id}}" @if (old("leagues")){{ (in_array($league->id, old("leagues")) ? "selected":"") }}@endif>{{ $league->displayname }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('leagues'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('leagues') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row" style="margin-top: 10px;">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-check"></i>{{trans('labels.create')}}
                                    </button>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@endsection

@section('scripts')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script> 
            $('.select2').select2();
    </script>
@endsection
<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 3/23/16
 * Time: 9:14 AM
 */
?>

@extends('layouts.app')

@section('app_header')
    <div class="app-header white bg b-b">
        <div class="navbar" data-pjax>
            <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up p-r m-a-0">
                <i class="ion-navicon"></i>
            </a>
            <div class="navbar-item pull-left h5" id="pageTitle">{{ $model->name }}</div>
            <!-- nabar right -->
            @include('tiles.nav_bar_right')
            <!-- / navbar right -->
        </div>
    </div>

@endsection

@section('content')

    <div class="padding">

        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h2>{{ $model->name }}</h2>
                        <!-- <small>Use Bootstrap's predefined grid classes to align labels and groups of form controls in a horizontal layout by adding .form-horizontal to the form. Doing so changes .form-groups to behave as grid rows, so no need for .row.</small> -->
                    </div>
                    <div class="box-divider m-a-0"></div>
                    <div class="box-body">
                        {{--  <dl class="dl-horizontal">
                            <dt>{{trans('labels.code')}}</dt>
                            <dd>{{$model->id}}</dd>
                        </dl>  --}}
                        
                        <dl class="dl-horizontal">
                            <dt>{{trans('labels.name')}}</dt>
                            <dd>{{$model->name}}</dd>
                        </dl>

                        <dl class="dl-horizontal">
                            <dt>{{trans('labels.abbreviation')}}</dt>
                            <dd>{{$model->abbreviation}}</dd>
                        </dl>

                        <dl class="dl-horizontal">
                            <dt>{{trans('labels.stats_id')}}</dt>
                            <dd>{{$model->stats_id}}</dd>
                        </dl>

                        <dl class="dl-horizontal">
                                <dt>{{trans('labels.leagues')}}</dt>
                                @foreach($leagues as $key=>$league)
                                    <dd>{{$league->displayname}}</dd>
                                @endforeach
                        </dl>
                        

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <div class="form-group row m-t-md">
                            <div class="col-sm-offset-2 col-sm-10 text-center">
                                <a class="btn btn-block btn-success"
                                   href="{{action('CategoryController@getEdit', $model->id)}}">{{trans('labels.edit')}}</a>
                                <a class="btn btn-block btn-warning"
                                   href="{{action('CategoryController@getDestroy', $model->id)}}">{{trans('labels.delete')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
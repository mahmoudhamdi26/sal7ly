<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 3/25/16
 * Time: 1:40 PM
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
                    <span class="navbar-item text-md">{{trans('labels.countries')}}</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="{{ action('CountryController@getCreate') }}"
                       data-toggle_="modal" data-target_="#modal-new" title="Reply">
      				            <span class="">
      				            	<i class="fa fa-fw fa-plus"></i>
      				            	<span class="hidden-sm-down">{{trans('labels.add_new')}}</span>
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
    <!-- ############ PAGE START-->
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

            <div class="row">
                <div class="col-md-12 text-center" style="margin: 10px;">
                    <form action="" method="get" class="form-inline">
                        <div class="form-group">
                            <input class="form-control" style="width: 300px;"
                                   type="text" placeholder="Name"
                                   value="{{ \Illuminate\Support\Facades\Input::get('name', '') }}" name="name">
                        </div>

                        <button type="submit" class="btn btn-primary">Find</button>
                    </form>
                </div>
            </div>

        <div class="box">
            <div>
                <table class="table m-b-none" data-ui-jp_="footable" data-filter_="#filter" data-page-size_="15">
                    <thead>
                    <tr>
                        <th>{{trans('labels.sn')}}</th>
                        <th>{{trans('labels.name')}}</th>
                        <th>{{trans('labels.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <a href="{{ action('CountryController@getShow', $item->id) }}">{{ $item->name }}</a>
                            </td>
                            <td>
                                <a href="{{ action('CountryController@getEdit', $item->id ) }}">
                                    <i class="ion-ios-gear-outline m-x-xs"></i>
                                </a>
                                <a onclick="return confirm('Are you sure you want to delete this item?');"
                                        href="{{ action('CountryController@getDestroy', $item->id ) }}">
                                    <i class="ion-ios-trash-outline m-x-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="hide">
                        <td>Education Level</td>
                        <td>
                            <span class="label rounded">Primary Stage</span>
                            <span class="label rounded">Preparatory Stage</span>
                            <span class="label rounded">Secondary Education</span>
                            <span class="label rounded">Post-Secondary education</span>
                        </td>
                        <td>
                            <a><i class="ion-ios-gear-outline m-x-xs"></i></a>
                            <a><i class="ion-ios-trash-outline m-x-xs"></i></a>
                        </td>
                    </tr>
                    </tbody>

                    <tfoot class="hide-if-no-paging">
                    <tr>
                        <td colspan="5" class="text-center">
                            {{--{!! $items->render() !!}--}}
                            {{ $items->appends(request()->except('page'))->links() }}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- ############ PAGE END-->

@endsection
@extends('layouts.app')

@section('content')

    <!-- BEGIN PAGE CONTAINER-->
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Widget Settings</h3>
            </div>
            <div class="modal-body">Widget settings form goes here</div>
        </div>
        <div class="clearfix"></div>
        <div class="content">
            <ul class="breadcrumb">
                <li>
                    <p>YOU ARE HERE</p>
                </li>
                <li><a href="#" class="active">{{ @trans('labels.nav_main_cats') }}</a>
                </li>
            </ul>
            <div class="page-title"><i class="icon-custom-left"></i>
                <h3><span class="semi-bold">{{ @trans('labels.add_new') }}</span></h3>
                <a class="nav-link text-muted" href="{{ action('DeviceTypeController@getCreate') }}"
                   data-toggle_="modal" data-target_="#modal-new" title="{{ @trans('labels.add_new') }}">
      				            <span class="">
      				            	<i class="fa fa-fw fa-plus"></i>
      				            	<span class="hidden-sm-down">{{trans('labels.add_new')}}</span>
      				            </span>
                </a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple ">
                        <div class="grid-title no-border">
                            <h4>Table <span class="semi-bold">Styles</span></h4>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                                <a href="#grid-config" data-toggle="modal" class="config"></a>
                                <a href="javascript:;" class="reload"></a>
                                <a href="javascript:;" class="remove"></a>
                            </div>
                        </div>
                        <div class="grid-body no-border">
                            <h3>
                                <span class="semi-bold">{{ @trans('labels.table') .' '.  @trans('labels.nav_devices') }}</span>
                            </h3>
                            <table class="table no-more-tables">
                                <thead>
                                <tr>
                                    <th style="width:9%">{{ trans('labels.company') }}</th>
                                    <th style="width:9%">{{ trans('labels.service') }}</th>
                                    <th style="width:9%">{{ trans('labels.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="v-align-middle">
                                                <span class="muted">{{ $item->company }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                                <span class="muted">{{ $item->service->name }}</span>
                                        </td>

                                        <td class="v-align-middle">
                                            <div class="btn-group">
                                                <a href="{{ action('DeviceTypeController@getEdit', $item->id ) }}"
                                                   class="btn" aria-pressed="false"><i class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Are you sure you want to delete this item?');"
                                                   href="{{ action('DeviceTypeController@getDestroy', $item->id ) }}"
                                                   class="btn btn-primary"><i class="fa fa-remove"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE -->
    </div>

@endsection

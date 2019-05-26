@extends('layouts.app')

@section('content')

    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Widget Settings</h3>
            </div>
            <div class="modal-body"> Widget settings form goes here</div>
        </div>
        <div class="clearfix"></div>
        <div class="content">
            <ul class="breadcrumb">
                <li>
                    <p>YOU ARE HERE</p>
                </li>
                <li>
                    {{ @trans('labels.nav_devices') }}
                </li>
                <li><a href="#" class="active">Create</a></li>
            </ul>
            <div class="page-title"><i class="icon-custom-left"></i>
                <h3>{{ @trans('labels.create') }} - <span class="semi-bold">{{ @trans('labels.company') }}</span></h3>
            </div>
            <!-- BEGIN BASIC FORM ELEMENTS-->
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-title no-border">
                            <h4>Simple <span class="semi-bold">Elemets</span></h4>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                                <a href="#grid-config" data-toggle="modal" class="config"></a>
                                <a href="javascript:;" class="reload"></a>
                                <a href="javascript:;" class="remove"></a>
                            </div>
                        </div>
                        <div class="grid-body no-border">
                            <br>
                            <div class="row">
                                <form class="" role="form" enctype="multipart/form-data"
                                      method="POST" action="{{ action('DeviceTypeController@postStore') }}">
                                    {!! csrf_field() !!}
                                    <div class="col-md-8 col-sm-8 col-xs-8">

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.company') }}</label>
                                            <span class="help">e.g. "توشيبا"</span>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="company"
                                                       value="{{ old('company') }}"
                                                       required="">

                                                @if ($errors->has('company'))
                                                    <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.service') }}</label>
                                            {{--<span class="help">e.g. "سباكة "</span>--}}
                                            <div class="controls">
                                                <select name="service_id" class="form-control" required>
                                                    @foreach($services as $service)
                                                        <option value="{{$service->id}}"
                                                                @if(old('service_id')==$service->id)
                                                                selected
                                                                @endif
                                                        >{{$service->name}}</option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('service_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('service_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="pull-right">
                                                <button class="btn btn-success btn-cons" type="submit"><i
                                                            class="icon-ok"></i> Save
                                                </button>
                                                <a href="{{ action('DeviceTypeController@getIndex') }}">
                                                    <button class="btn btn-white btn-cons" type="button">Cancel</button>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

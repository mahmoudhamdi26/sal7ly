@extends('layouts.app')

@section('content')

    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Widget Settings</h3>
            </div>
            <div class="modal-body"> Widget settings form goes here </div>
        </div>
        <div class="clearfix"></div>
        <div class="content">
            <ul class="breadcrumb">
                <li>
                    <p>YOU ARE HERE</p>
                </li>
                <li>
                    Countries
                </li>
                <li><a href="#" class="active">Create</a> </li>
            </ul>
            <div class="page-title"> <i class="icon-custom-left"></i>
                <h3>Create - <span class="semi-bold">Country</span></h3>
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
                                      method="POST" action="{{ action('CountryController@postStore') }}">
                                    {!! csrf_field() !!}
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.code') }}</label>
                                        <span class="help">e.g. "EG"</span>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="code" value="{{ old('code') }}"
                                                   required="">

                                            @if ($errors->has('code'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ">{{ trans('labels.name') }}</label>
                                        <span class="help">e.g. "Egypt"</span>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                   required="">

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-actions">
                                        <div class="pull-right">
                                            <button class="btn btn-success btn-cons" type="submit"><i class="icon-ok"></i> Save</button>
                                            <button class="btn btn-white btn-cons" type="button">Cancel</button>
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

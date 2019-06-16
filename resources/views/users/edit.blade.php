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
                    Countries
                </li>
                <li><a href="#" class="active">Create</a></li>
            </ul>
            <div class="page-title"><i class="icon-custom-left"></i>
                <h3>{{ @trans('labels.update') }} - <span class="semi-bold">{{ @trans('labels.category') }}</span></h3>
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
                                      method="POST" action="{{ action('UsersController@postUpdate', $model->id) }}">
                                    {!! csrf_field() !!}
                                    <div class="col-md-8 col-sm-8 col-xs-8">

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.name') }}</label>
                                            <span class="help">e.g. "Mohamed Ali"</span>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="name"
                                                       value="{{ $model->name }}" required="">

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.email') }}</label>
                                            <span class="help">e.g. "m.ali@gmail.com"</span>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="email"
                                                       value="{{ $model->email }}" required="">

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.password') }}</label>
                                            <span class="help">"لابد ان تحتوى على 6 ارقام على الاقل"</span>
                                            <div class="controls">
                                                <input type="password" class="form-control" name="password"
                                                       value="" >

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.mobile') }}</label>
                                            <span class="help">"01011232800"</span>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="mobile"
                                                       value="{{ $model->mobile }}" >

                                                @if ($errors->has('mobile'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('mobile') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label ">{{ trans('labels.address') }}</label>
                                            <span class="help">"المقطم شارع 9 قطعه 123"</span>
                                            <div class="controls">
                                                <input type="text" class="form-control" name="address"
                                                       value="{{ $model->address }}" >

                                                @if ($errors->has('address'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="pull-right">
                                                <button class="btn btn-success btn-cons" type="submit"><i
                                                            class="icon-ok"></i> Save
                                                </button>
                                                <a href="{{ action('CategoryController@getIndex') }}">
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

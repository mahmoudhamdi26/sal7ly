<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 3/25/16
 * Time: 1:41 PM
 */
?>

@extends('layouts.app')

@section('content')

    @if(Session::has('message'))
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <div class="alert alert-{{ Session::get('alert-class', 'info') }}">
                    <p>{{ Session::get('message') }}</p>
                </div>
            </div>
        </div>
    @endif


    <h1>{{trans('labels.add_new')}} {{ trans('labels.permissions_group') }}</h1>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" enctype="multipart/form-data"
                          method="POST" action="{{ action('ACLController@postStore') }}">
                        {!! csrf_field() !!}


                        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }}">
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

                        <div class="form-group required {{ $errors->has('permissions_id') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">{{trans('labels.can_access')}}</label>

                            <div class="col-md-7">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input value="" type="checkbox"> {{ $permission->label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($errors->has('permissions_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permissions_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group" style="margin-top: 10px;">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-check"></i>{{trans('labels.create')}}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('fields.handlebar_temps')
@endsection

@section('scripts')
    <script>
        var counter = 0;
        function typeChanged(){
            var val = $('#typeSelect').val();
            if(val === 'SELECT'){
                $('#addNewContainer').show();
                addOption();
            }else{
                var ele = $('#dynamicContent');
                ele.html('');
                ele.hide();
                $('#addNewContainer').hide();
            }
        }

        function addOption(){
            var ele = $('#dynamicContent');

            var source   = $("#entry-template").html();
            var template = Handlebars.compile(source);
            var context = {"counter": counter};
            var html    = template(context);
            counter++;

            ele.append(html);
            ele.show();
        }

        function removeOptionsGroup(id){
            var ele = $('#dynamicContent');
            if(ele.children().length > 1){
                $('#'+id).remove();
            }
        }


    </script>
@endsection
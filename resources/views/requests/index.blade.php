@extends('layouts.app')

@section('css')
    <link href="/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css">

@endsection
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
                <li><a href="#" class="active">{{ @trans('labels.nav_job_reqs') }}</a>
                </li>
            </ul>

            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple ">

                        <div class="grid-body no-border">
                            <br><br>
                            <form>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-4">
                                        <div class="input-append success date ">
                                            <input autocomplete="off" type="text" class="span12" name="from"
                                                   placeholder="التاريخ من">
                                            <span class="add-on"><span class="arrow"></span><i
                                                        class="icon-th"></i></span>
                                        </div>

                                    </div>
                                    <div class="col-md-offset-1 col-md-4">
                                        <div class="input-append success date">
                                            <input autocomplete="off" type="text" class="span12" name="to"
                                                   placeholder="التاريخ الى">
                                            <span class="add-on"><span class="arrow"></span><i
                                                        class="icon-th"></i></span>
                                        </div>

                                    </div>
                                    <div class="col-md-2" style="max-height: 100%">
                                        <button class="btn btn-success align-middle" type="submit">بحث</button>
                                    </div>

                                </div>
                            </form>


                            <h3>
                                <span class="semi-bold">{{ @trans('labels.table') .' '.  @trans('labels.nav_job_reqs') }}</span>
                            </h3>
                            <table class="table no-more-tables">
                                <thead>
                                <tr>
                                    <th style="width:12%">{{ trans('labels.username') }}</th>
                                    <th style="width:9%">{{ trans('labels.mobile') }}</th>
                                    <th style="width:9%">{{ trans('labels.job_type') }}</th>
                                    <th style="width:9%">{{ trans('labels.company') }}</th>
                                    <th style="width:9%">{{ trans('labels.needed_at') }}</th>
                                    <th style="width:18%">{{ trans('labels.desc') }}</th>
                                    <th style="width:9%">{{ trans('labels.done') }}</th>
                                    <th style="width:9%">{{ trans('labels.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr @if($item->done) class="bg-success" @endif>
                                        <td class="v-align-middle">
                                            <span class="muted">{{ $item->user->name }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">{{ $item->user->mobile }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted"> @if($item->job_type){{$item->job_type->name}} @else {{$item->service->name}} @endif </span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">@if($item->device_type){{ $item->device_type->company }}@endif</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">{{ $item->needed_at }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">{{ $item->desc }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <input type="checkbox" @if($item->done) checked @endif class="muted"
                                                   onchange="handleChanged({{$item->id}},this)"/>
                                        </td>
                                        <td class="v-align-middle">
                                            <div class="btn-group">
                                                <a onclick="return confirm('Are you sure you want to delete this item?');"
                                                   href="{{ action('JobReqController@getDestroy', $item->id ) }}"
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
@section('scripts')
    <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script>

        $('.input-append.date').datepicker({
            orientation: "auto",
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        function handleChanged(id, elem) {

            $.ajax({
                url: "/job-requests/update/"+id,
                method: "POST",
                data:{"done":elem.checked,'_token': '{{csrf_token()}}'},
                success: function (result) {
                    $(elem).parent().parent().toggleClass('bg-success');
                }
            });
        }

    </script>
@endsection
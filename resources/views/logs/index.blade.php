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
        @foreach($items as $item)
        <div class="modal fade" id="{{"modal".$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <br>
                        <h4 id="myModalLabel" class="semi-bold">بيانات سجل الاعضاء بالتفصيل</h4>
                        <p class="no-margin">{{$item->user->name}} </p>
                        <p class="no-margin">{{ trans('labels.'.$item->action)." ".trans('labels.'.$item->item_type)}} </p>
                        <br>
                    </div>
                    <div class="modal-body">

                        <table dir="rtl" class="table text-center">
                            @foreach($item->item_data as $key => $val)
                            <tr>
                                <td>{{trans('labels.'.$key)}}</td>
                                <td>{{$val}}</td>
                            </tr>
                            @endforeach
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        @endforeach
            <div class="content">
            <ul class="breadcrumb">
                <li>
                    <p>YOU ARE HERE</p>
                </li>
                <li><a href="#" class="active">{{ @trans('labels.logs') }}</a>
                </li>
            </ul>

            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple ">

                        <div class="grid-body no-border">
                            <br><br>
                            <h3>
                                <span class="semi-bold">{{ @trans('labels.table') .' '.  @trans('labels.logs') }}</span>
                            </h3>
                            <table class="table no-more-tables">
                                <thead>
                                <tr>
                                    <th style="width:12%">{{ trans('labels.username') }}</th>
                                    <th style="width:9%">{{ trans('labels.action') }}</th>
                                    <th style="width:9%">{{ trans('labels.target') }}</th>
                                    <th style="width:9%">{{ trans('labels.target_id') }}</th>
                                    <th style="width:9%">{{ trans('labels.time') }}</th>
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
                                            <span class="muted">  {{trans('labels.'.$item->action)}}  </span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">  {{trans('labels.'.$item->item_type)}}  </span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">{{ $item->item_id }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <span class="muted">{{ $item->created_at }}</span>
                                        </td>
                                        <td class="v-align-middle">
                                            <div class="btn-group">
                                                <button class="btn btn-mini btn-primary" data-toggle="modal" data-target="#{{"modal".$item->id}}"> <i class="fa fa-eye"></i> </button>
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
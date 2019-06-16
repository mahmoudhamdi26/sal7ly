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
            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li>
                    <p>YOU ARE HERE</p>
                </li>
                <li><a href="#" class="active">Users</a></li>
            </ul>
            <div class="page-title"><a href="#"><i class="icon-custom-left"></i></a>
                <h3>Users - <span class="semi-bold">List</span></h3>
            </div>
            <!-- end Breadcrumb -->

            <!-- Users List -->
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-title no-border">
                            <div class="col-md-3">
                                <input name="filtersSearch" type="text" class="form-control" id="filtersSearch"
                                       placeholder="Search">
                            </div>
                            <div class="col-md-7">

                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-link" href="{{ action('UsersController@getCreate') }}">
                                    <i class="glyphicon glyphicon-plus"></i> Add New
                                </a>
                            </div>
                        </div>

                        <div class="grid-body no-border ">
                            <br/><br/><br/>
                            @if($users != null && count($users)>0 )
                            <table class="table no-more-tables">
                                <thead>
                                <tr>
                                    <th>{{ trans('labels.name') }}</th>
                                    <th>{{ trans('labels.email') }}</th>
                                    <th>{{ trans('labels.mobile') }}</th>
                                    <th>{{ trans('labels.address') }}</th>
                                    <th>{{ trans('labels.actions') }}</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $user)
                                <tr>
                                    <td class="v-align-middle">{{ $user->name }}</td>
                                    <td class="v-align-middle">{{ $user->email }}</td>
                                    <td class="v-align-middle"><span class="muted">{{ $user->mobile }}</span></td>

                                    <td class="v-align-middle">{{ $user->address }}</td>
                                    <td class="v-align-middle">
                                        <div class="btn-group">
                                            <a href="{{ action('UsersController@getEdit', $user->id ) }}"
                                               class="btn btn-primary" aria-pressed="false"><i class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Are you sure you want to delete this item?');"
                                               href="{{ action('UsersController@getDestroy', $user->id ) }}"
                                               class="btn btn-danger"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            @else
                            <h3 class="text-center padding-20"> There is No Users Yet!</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end Users List -->

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
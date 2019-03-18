<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 2/8/17
 * Time: 8:40 AM
 */
?>

@extends('layouts.app')

@section('content')

    <div class="padding">
        <div class="row">
            <div class="box">
                @foreach($roles as $role)
                    <div class="col-md-4">
                        <h6><strong>{{ $role->label }}</strong>
                            @if(!in_array($role->label, [trans('labels.para_focal'), trans('labels.para_qc'), trans('labels.para_publisher'), trans('labels.para_admin')]))<a href="{{ action('ACLController@getDelete', $role->id) }}">Delete</a>@endif</h6>

                        <div class="m-b" id="accordion">
                            @foreach($permissions as $permission)
                                <div class="panel box no-border m-b-xs">
                                    <div class="box-header p-y-sm">
                                        <a data-toggle="collapse" data-parent="#accordion"
                                           data-target="#c_{{ $role->id }}_{{ $permission->id }}">
                                            {{ $permission->label }}
                                        </a>
                                    </div>
                                    <div id="c_{{ $role->id }}_{{ $permission->id }}" class="collapse">
                                        <div class="box-body">
                                            <div class="text-sm text-muted">
                                                @foreach($permission->functions as $function)
                                                    <p>
                                                        <label>
                                                            <input type="checkbox"
                                                                   id="chk_{{ $role->id }}-{{ $permission->id }}_{{ $function->id }}"
                                                                   onchange="functionChanged(this)"
                                                                   data-role="{{ $role->id }}"
                                                                   data-permission="{{ $permission->id }}"
                                                                   data-function="{{ $function->id }}"
                                                            @if(isset($selected[$role->id]) && in_array($function->id, $selected[$role->id]))
                                                                   checked
                                                                    @endif
                                                                    >
                                                            {{ $function->name }}
                                                        </label>
                                                    </p>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>
            <!-- .box -->
        </div>
    </div>

    <div id="modalCreateGroup" class="modal" data-backdrop="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ action('ACLController@postCreateRole') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Group</h5>
                    </div>
                    <div class="modal-body text-center p-lg">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Group Name</label>
                            <input type="text" class="form-control" name="label"
                                   id="exampleInputEmail1" placeholder="Group Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                        <button type="submit" class="btn success p-x-md">Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        function createGroup() {
            $('#modalCreateGroup').modal('show');
        }

        function functionChanged(ele) {
            var roles_id = $(ele).attr('data-role');
            var permissions_id = $(ele).attr('data-permission');
            var functions_id = $(ele).attr('data-function');
            var isChecked = $(ele).is(":checked");

            var url = '{{ action('ACLController@getToggleAssignFunction', [0, 0]) }}';
            url = url.replace('/0/0', '/' + roles_id + '/' + functions_id);

            $.ajax({
                url: url,
                success: function (result) {
                    if (result.status == 1) {

                    } else {
                        /// Reset the status
                        if (isChecked) {
                            $(ele).removeAttr('checked');
                        } else {
                            $(ele).attr('checked', 'checked');
                        }

                        /// Show error message
                        alert('Something went wrong, Please try again.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    /// Reset the status
                    if (isChecked) {
                        $(ele).removeAttr('checked');
                    } else {
                        $(ele).attr('checked', 'checked');
                    }

                    /// Show error message
                    alert('Something went wrong, Please try again.');
                }
            });
        }

    </script>
@endsection
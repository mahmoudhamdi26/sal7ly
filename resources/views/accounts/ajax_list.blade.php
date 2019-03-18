<?php
/**
 * Created by PhpStorm.
 * User: mahmoud
 * Date: 2/11/17
 * Time: 2:47 PM
 */
?>

<div data-count="{{ $users->count() }}"
     data-next="{{ $users->nextPageUrl() }}"
     data-prev="{{ $users->previousPageUrl() }}"
     data-total="{{ $users->total() }}" >
@foreach($users as $user)

    <div class="list-item {{ ($user->isactive)?'':'danger' }}" id="listItem{{$user->id}}" onclick="userDetails(this)"
         data-id="{{ $user->id }}"
            data-email="{{ $user->email }}"
            data-phone="{{ !empty($user->phone)?$user->phone:trans('labels.unset') }}"
            data-name="{{ $user->name }}"
            data-job="{{ $user->job }}"
            @if(empty($user->imgid) || $user->imgid==null)
            {{--data-img="{{ action('ImageController', ['profiles', $user->imgid]) }}"--}}
         data-img="images/guest.jpg"
         @else
            data-img="images/guest.jpg"
                    @endif

            data-edit="{{ action('AccountsController@getEdit', $user->id) }}"
        data-delete="{{ action('AccountsController@getDelete', $user->id) }}"

            >
        <div class="list-left">
            <span class="w-40 avatar circle blue-grey">
			    {{ substr($user->name, 0, 1) }}
			</span>
        </div>
        <div class="list-body">
            <div class="pull-right dropdown">
                <a href="#" data-toggle="dropdown" class="text-muted"><i class="fa fa-fw fa-ellipsis-v"></i></a>

                <div class="dropdown-menu pull-right text-color" role="menu">
                    <a href="{{ action('AccountsController@getEdit', $user->id) }}" class="dropdown-item">
                        <i class="fa fa-pencil"></i>
                        Edit User
                    </a>
                    @if($user->isactive)
                        <a id="aLinkDeactivate{{ $user->id }}"
                           data-id="{{ $user->id }}"
                           data-url="{{ action('AccountsController@getDeactivate', $user->id) }}"
                           href_="{{ action('AccountsController@getDeactivate', $user->id) }}"
                           href="#"
                           onclick="deactivate(this)"
                           class="dropdown-item">
                            <i class="fa fa-trash"></i>
                            De-Activate User
                        </a>
                        <a id="aLinkActivate{{ $user->id }}"
                           data-id="{{ $user->id }}"
                           data-url="{{ action('AccountsController@getActivate', $user->id) }}"
                           href_="{{ action('AccountsController@getDeactivate', $user->id) }}"
                           href="#"
                           onclick="activate(this)"
                           class="dropdown-item" style="display: none;">
                            <i class="fa fa-trash"></i>
                            Activate User
                        </a>
                    @else
                        <a id="aLinkDeactivate{{ $user->id }}"
                           data-id="{{ $user->id }}"
                           data-url="{{ action('AccountsController@getDeactivate', $user->id) }}"
                           href_="{{ action('AccountsController@getDeactivate', $user->id) }}"
                           href="#"
                           onclick="deactivate(this)"
                           class="dropdown-item" style="display: none;">
                            <i class="fa fa-trash"></i>
                            De-Activate User
                        </a>
                        <a id="aLinkActivate{{ $user->id }}"
                           data-id="{{ $user->id }}"
                           data-url="{{ action('AccountsController@getActivate', $user->id) }}"
                           href_="{{ action('AccountsController@getDeactivate', $user->id) }}"
                           href="#"
                           onclick="activate(this)"
                           class="dropdown-item">
                            <i class="fa fa-trash"></i>
                            Activate User
                        </a>
                    @endif

                    <div class="dropdown-divider hide"></div>
                    <a class="dropdown-item hide">
                        <i class="fa fa-ellipsis-h"></i>
                        More action
                    </a>
                </div>
            </div>
            <div class="item-title">
                <a href="#" class="_500">{{ $user->name }} {{ $user->lname }}</a>
            </div>
            <small class="block text-muted text-ellipsis">
                {{ $user->email }}
            </small>
        </div>
    </div>
@endforeach
</div>
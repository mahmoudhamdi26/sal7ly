<?php

namespace App\Http\Controllers;

use App\models\Service;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UsersController extends Controller {
    public function __construct() {
        $this->middleware( 'auth' );
    }

    public function getIndex() {
        if ( Gate::denies( 'check-ability', 'Users|List' ) ) {
            abort( 403, 'Unauthorized action.' );
        }
        $users = User::where('is_staff', '=', true)->get();
        return View::make( 'users.index', compact( 'users' ) );
    }

    public function getCreate() {
        if ( Gate::denies( 'check-ability', 'Users|Create' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        return view( 'users.create');
    }

    public function postStore( Request $request ) {
        if ( Gate::denies( 'check-ability', 'Users|Create' ) ) {
            abort( 403, 'Unauthorized action.' );
        }



        $this->validate($request,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'mobile' => 'nullable|regex:/(01)[0-9]{9}/',
                'address' => 'nullable|string|min:12',
            ]);

        $user = User::create($request->all());
        $user->is_staff=true;
        $user->save();
        return redirect( 'users' );
    }


    public function getEdit( $id ) {
        if ( Gate::denies( 'check-ability', 'Users|Update' ) ) {
            abort( 403, 'Unauthorized action.' );
        }


        $sessionUser = Auth::user();

        $model           = User::findOrFail( $id );
        return view( 'users.edit', compact( 'sessionUser', 'model') );
    }

    public function postUpdate( Request $request, $id ) {
        if ( Gate::denies( 'check-ability', 'Users|Update' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        $model   = User::findOrFail( $id );
        $oldData = $model->toJson();

        $this->validate( $request,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$model->id,
                'password' => 'nullable|string|min:6',
                'mobile' => 'nullable|regex:/(01)[0-9]{9}/',
                'address' => 'nullable|string|min:12',
            ] );

        try {
            $inputs = $request->all();
            $model->update( $inputs );

            //// Logging
            $logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Updated User $model->id";
            $routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );


        } catch ( Exception $ex ) {
            Session::flash( 'message', 'Error, Please try again!' );
            Session::flash( 'alert-class', 'danger' );

            return Redirect::back()->withInput();
        }

        Session::flash( 'message', 'Item Updated!' );

        return redirect( action( 'UsersController@getEdit', $model->id ) );
    }

    public function getDestroy( $id ) {
        if ( Gate::denies( 'check-ability', 'Users|Delete' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        try {
            # delete leagues
            $item = User::where( 'id', $id )->first();
            $item->delete();
            //// Logging
            $logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Deleted User $item->id";
            $routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );


        } catch ( QueryException $ex ) {
            if ( $ex->getCode() == 23000 ) {
                Session::flash( 'message', "Can't delete User because there is assigned types to it." );
            } else {
                Session::flash( 'message', $ex->getMessage() );
            }
            Session::flash( 'alert-class', 'danger' );

            return Redirect::back();
        }

        Session::flash( 'message', 'Item deleted!' );

        return Redirect::to( action( 'UsersController@getIndex' ) );
    }
}

<?php

namespace App\Http\Controllers;

use App\models\Category;
use App\models\Logs;
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
use Illuminate\Support\Facades\View;

class CategoryController extends Controller {
    public function __construct() {
        $this->middleware( 'auth' );
    }

    public function getIndex() {
        if ( Gate::denies( 'check-ability', 'Service|List' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $itemsQ = Category::orderBy( 'name' );
        if ( Input::has( 'name' ) && ! empty( Input::get( 'name' ) ) ) {
//			$itemsQ = $itemsQ->where( 'lower(name)', 'like', strtolower(Input::get( 'name' ) . '%') );
            $itemsQ = $itemsQ->whereRaw('LOWER(name) LIKE ? ',[trim(strtolower(Input::get( 'name' ))).'%']);
            $itemsQ = $itemsQ->orWhere( 'abbreviation', 'like', strtoupper(Input::get( 'name' ) . '%'));
        }
        $items = $itemsQ->paginate( 20 );

        return View::make( 'categories.index', compact( 'items' ) );
    }

    public function getCreate() {
        if ( Gate::denies( 'check-ability', 'Service|Create' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        return view( 'categories.create');
    }

    public function postStore( Request $request ) {
        if ( Gate::denies( 'check-ability', 'Service|Create' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        $this->validate( $request,
            [
                'name'         => 'required|unique:category',
            ] );

        DB::beginTransaction();
        try {
            $inputs = $request->all();
            $item   = Category::create( $inputs );

        } catch ( Exception $ex ) {
            DB::rollback();
            Session::flash( 'message', 'Error, Please try again!' );
            Session::flash( 'alert-class', 'danger' );
            return Redirect::back()->withInput();
        }
        if($request->file('icon')) {
            $path = $request->file('icon')->storeAs(
                'public/icons', uniqid('cat_')
            );
            $item->update(['icon_url' => Storage::url($path)]);
        }
        DB::commit();
        Session::flash( 'message', 'Category added!' );

        $log_data=['action'=>'create','item_id'=>$item->id,'item_type'=>'category',
            'user_id'=>$request->user()->id,'item_data'=>$item->toJson()];
        Logs::create($log_data);
        return redirect( 'categories' );
    }


    public function getEdit( $id ) {
        if ( Gate::denies( 'check-ability', 'Service|Update' ) ) {
            abort( 403, 'Unauthorized action.' );
        }


        $sessionUser = Auth::user();

        $model           = Category::findOrFail( $id );
        return view( 'categories.edit', compact( 'sessionUser', 'model') );
    }

    public function postUpdate( Request $request, $id ) {
        if ( Gate::denies( 'check-ability', 'Service|Update' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        $model   = Category::findOrFail( $id );
        $oldData = $model->toJson();

        $this->validate( $request,
            [
                'name'         => 'required|unique:category,name,' . $model->id,
            ] );

        try {
            $inputs = $request->all();
            #$inputs['id'] = strtoupper($inputs['id']);
            $model->update( $inputs );
            $newData = $model->toJson();

            //// Logging
            $logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Updated Category $model->id";
            $routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );


        } catch ( Exception $ex ) {
            Session::flash( 'message', 'Error, Please try again!' );
            Session::flash( 'alert-class', 'danger' );

            return Redirect::back()->withInput();
        }

        Session::flash( 'message', 'Item Updated!' );
        if($request->file('icon')) {
            $path = $request->file('icon')->storeAs(
                'public/icons', uniqid('cat_')
            );
            $model->update(['icon_url' => Storage::url($path)]);
        }
        $log_data=['action'=>'update','item_id'=>$model->id,'item_type'=>'category',
            'user_id'=>$request->user()->id,'item_data'=>$model->toJson()];
        Logs::create($log_data);
        return redirect( action( 'CategoryController@getEdit', $model->id ) );
    }

    public function getDestroy( $id ) {
        if ( Gate::denies( 'check-ability', 'Service|Delete' ) ) {
            abort( 403, 'Unauthorized action.' );
        }

        $sessionUser = Auth::user();

        try {
            # delete leagues
            $item = Category::where( 'id', $id )->first();
            $item->delete();
            //// Logging
            $logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Deleted Category $item->id";
            $routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );


        } catch ( QueryException $ex ) {
            if ( $ex->getCode() == 23000 ) {
                Session::flash( 'message', "Can't delete Category because there is assigned types to it." );
            } else {
                Session::flash( 'message', $ex->getMessage() );
            }
            Session::flash( 'alert-class', 'danger' );

            return Redirect::back();
        }

        Session::flash( 'message', 'Item deleted!' );
        $log_data=['action'=>'delete','item_id'=>$item->id,'item_type'=>'category',
            'user_id'=>$sessionUser->id,'item_data'=>$item->toJson()];
        Logs::create($log_data);
        return Redirect::to( action( 'CategoryController@getIndex' ) );
    }
}

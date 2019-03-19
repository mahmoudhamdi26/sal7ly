<?php

namespace App\Http\Controllers;

use App\Libraries\SharedFunctions;
use App\models\Country;
use App\models\League;
use App\models\CountryLeagues;
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
use Illuminate\Support\Facades\View;

class CountryController extends Controller {
	public function __construct() {
		$this->middleware( 'auth' );
	}

	public function getIndex() {
		if ( Gate::denies( 'check-ability', 'Countries|List' ) ) {
			abort( 403, 'Unauthorized action.' );
		}

		$itemsQ = Country::orderBy( 'name' );
		if ( Input::has( 'name' ) && ! empty( Input::get( 'name' ) ) ) {
//			$itemsQ = $itemsQ->where( 'lower(name)', 'like', strtolower(Input::get( 'name' ) . '%') );
			$itemsQ = $itemsQ->whereRaw('LOWER(name) LIKE ? ',[trim(strtolower(Input::get( 'name' ))).'%']);
			$itemsQ = $itemsQ->orWhere( 'abbreviation', 'like', strtoupper(Input::get( 'name' ) . '%'));
		}
		$items = $itemsQ->paginate( 20 );

		return View::make( 'countries.index', compact( 'items' ) );
	}

	public function getCreate() {
		if ( Gate::denies( 'check-ability', 'Countries|Create' ) ) {
			abort( 403, 'Unauthorized action.' );
		}

		$sessionUser = Auth::user();

		return view( 'countries.create');
	}

	public function postStore( Request $request ) {
		if ( Gate::denies( 'check-ability', 'Countries|Create' ) ) {
			abort( 403, 'Unauthorized action.' );
		}

		$sessionUser = Auth::user();

		$this->validate( $request,
			[
				'name'         => 'required|unique:countries',
				'code' => 'required|unique:countries',
			] );

		DB::beginTransaction();
		try {
			$inputs = $request->all();
			$item   = Country::create( $inputs );

			$newData = $item->toJson();
			//// Logging
			$logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Created Country $item->id";
			$routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );
			// SharedFunctions::registerActionWithChanges(Auth::user(), 'COUNTRY-CREATE',
			//     $routeParts[0], $routeParts[1], 0, $logMsg, null, $newData);

		} catch ( Exception $ex ) {
			DB::rollback();
			Session::flash( 'message', 'Error, Please try again!' );
			Session::flash( 'alert-class', 'danger' );

			return Redirect::back()->withInput();
		}

		DB::commit();
		Session::flash( 'message', 'Country added!' );

		return redirect( 'countries' );
	}

	public function getShow( $id ) {
		if ( Gate::denies( 'check-ability', 'Countries|Show' ) ) {
			abort( 403, 'Unauthorized action.' );
		}


		$sessionUser     = Auth::user();
		$Country_leagues = CountryLeagues::where( 'country_id', $id )->get();
		$leagues         = array();

		foreach ( $Country_leagues as $key => $country_league ) {
			$leagues[ $key ] = League::findOrFail( $country_league->league_id );
		}

		$model = Country::findOrFail( $id );

		return view( 'countries.show', compact( 'sessionUser', 'model', 'leagues' ) );
	}

	public function getEdit( $id ) {
		if ( Gate::denies( 'check-ability', 'Countries|Update' ) ) {
			abort( 403, 'Unauthorized action.' );
		}


		$sessionUser = Auth::user();

		$model           = Country::findOrFail( $id );
		$leagues         = League::all();
		$Country_leagues = CountryLeagues::where( 'country_id', $id )->get();
		$country_leagues = array();
		foreach ( $Country_leagues as $key => $country_league ) {
			$country_leagues[ $key ] = $country_league->league_id;
		}

		return view( 'countries.edit', compact( 'sessionUser', 'model', 'leagues', 'country_leagues' ) );
	}

	public function postUpdate( Request $request, $id ) {
		if ( Gate::denies( 'check-ability', 'Countries|Update' ) ) {
			abort( 403, 'Unauthorized action.' );
		}

		$sessionUser = Auth::user();

		$model   = Country::findOrFail( $id );
		$oldData = $model->toJson();

		$this->validate( $request,
			[
				#'id' => 'required|max:4|unique:countries,id,'.$model->id,
				'name'         => 'required|unique:countries,name,' . $model->id,
				'abbreviation' => 'required|unique:countries,abbreviation,' . $model->id,
				'stats_id'     => 'numeric|unique:countries,stats_id,' . $model->id,
				'leagues'      => 'array',

			] );

		try {
			$inputs = $request->all();
			#$inputs['id'] = strtoupper($inputs['id']);
			$model->update( $inputs );

			# delete existing leagues first
			$Country_leagues = CountryLeagues::where( 'country_id', $id )->get();
			foreach ( $Country_leagues as $key => $country_league ) {
				$country_league->delete();
			}
			# insert new records
			if ( $request->filled( 'leagues' ) ) {
				$leagues = $inputs['leagues'];
				foreach ( $leagues as $key => $league ) {
					$country_league             = new CountryLeagues;
					$country_league->league_id  = $league;
					$country_league->country_id = $model->id;
					$country_league->save();
				}
			}
			$newData = $model->toJson();

			//// Logging
			$logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Updated Country $model->id";
			$routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );
			// SharedFunctions::registerActionWithChanges(Auth::user(), 'COUNTRY-UPDATE',
			//     $routeParts[0], $routeParts[1], 0, $logMsg, $oldData, $newData);

		} catch ( Exception $ex ) {
			Session::flash( 'message', 'Error, Please try again!' );
			Session::flash( 'alert-class', 'danger' );

			return Redirect::back()->withInput();
		}

		Session::flash( 'message', 'Item Updated!' );

		return redirect( action( 'CountryController@getEdit', $model->id ) );
	}

	public function getDestroy( $id ) {
		if ( Gate::denies( 'check-ability', 'Countries|Delete' ) ) {
			abort( 403, 'Unauthorized action.' );
		}

		$sessionUser = Auth::user();

		try {
			// $count = Indicator::where('countries_id', $id)->count();
			// if($count > 0){
			//     Session::flash('message', "Can't delete country because there is assigned indicators to it.");
			//     Session::flash('alert-class', 'danger');
			//     return Redirect::back();
			// }

			// $institCount = Institution::where('countries_id', $id)->count();
			// if($institCount > 0){
			//     Session::flash('message', "Can't delete country because there is assigned institutions to it.");
			//     Session::flash('alert-class', 'danger');
			//     return Redirect::back();
			// }

			// $usersCount = User::where('countries_id', $id)->count();
			// if($usersCount > 0){
			//     Session::flash('message', "Can't delete country because there is assigned users to it.");
			//     Session::flash('alert-class', 'danger');
			//     return Redirect::back();
			// }

//            $item = Country::findOrFail($id);
//            $item->delete(); 

			# delete leagues
			$Country_leagues = CountryLeagues::where( 'country_id', $id )->get();
			foreach ( $Country_leagues as $key => $country_league ) {
				$country_league->delete();
			}
			$item = Country::where( 'id', $id )->first();
			$item->delete();
			//// Logging
			$logMsg     = $sessionUser->name . " " . $sessionUser->lname . " Deleted Country $item->id";
			$routeParts = explode( '@', Route::getCurrentRoute()->getActionName() );
//            SharedFunctions::registerAction(Auth::user(), 'COUNTRY-DELETE',
//                $routeParts[0], $routeParts[1], 0, $logMsg);

		} catch ( QueryException $ex ) {
			if ( $ex->getCode() == 23000 ) {
				Session::flash( 'message', "Can't delete country because there is assigned types to it." );
			} else {
				Session::flash( 'message', $ex->getMessage() );
			}
			Session::flash( 'alert-class', 'danger' );

			return Redirect::back();
		}

		Session::flash( 'message', 'Item deleted!' );

		return Redirect::to( action( 'CountryController@getIndex' ) );
	}
}

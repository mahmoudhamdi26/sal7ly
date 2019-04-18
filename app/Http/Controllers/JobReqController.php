<?php

namespace App\Http\Controllers;

use App\models\Category;
use App\models\JobRequest;
use App\models\JobType;
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
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class JobReqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        if (Gate::denies('check-ability', 'Service|List')) {
            abort(403, 'Unauthorized action.');
        }

//        $itemsQ = JobType::orderBy('name');
//        if (Input::has('name') && !empty(Input::get('name'))) {
////			$itemsQ = $itemsQ->where( 'lower(name)', 'like', strtolower(Input::get( 'name' ) . '%') );
//            $itemsQ = $itemsQ->whereRaw('LOWER(name) LIKE ? ', [trim(strtolower(Input::get('name'))) . '%']);
//            $itemsQ = $itemsQ->orWhere('abbreviation', 'like', strtoupper(Input::get('name') . '%'));
//        }
//        $items = $itemsQ->paginate(20);
        $items = JobRequest::whereDate('created_at', Carbon::today())->orderBy('created_at', 'DESC')->get();

        return View::make('requests.index', compact('items'));
    }


    public function getDestroy($id)
    {
        if (Gate::denies('check-ability', 'Service|Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();

        try {
            $item = JobRequest::where('id', $id)->first();
            $item->delete();

        } catch (QueryException $ex) {
            if ($ex->getCode() == 23000) {
                Session::flash('message', "Can't delete Service because there is assigned types to it.");
            } else {
                Session::flash('message', $ex->getMessage());
            }
            Session::flash('alert-class', 'danger');

            return Redirect::back();
        }

        Session::flash('message', 'Item deleted!');

        return Redirect::to(action('JobReqController@getIndex'));
    }
}

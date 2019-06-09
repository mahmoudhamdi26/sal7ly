<?php

namespace App\Http\Controllers;

use App\models\Category;
use App\models\JobRequest;
use App\models\JobType;
use App\models\Service;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        $itemsQ = JobRequest::orderBy('needed_at');
        if (Input::has('from') && !empty(Input::get('from')))
            $itemsQ = $itemsQ->whereDate('needed_at', '>=', Input::get('from'));
        if (Input::has('to') && !empty(Input::get('to')))
            $itemsQ = $itemsQ->whereDate('needed_at', '<=', Input::get('to'));
        $items = $itemsQ->get();

        return View::make('requests.index', compact('items'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('check-ability', 'Service|List')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $model = JobRequest::findOrFail($id);
            $model->done = $request->done == "true" ? 1 : 0;
            $model->save();
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'update error'], 400);
        }

        return response()->json(['message' => 'updated successfully'], 200);
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

<?php

namespace App\Http\Controllers;

use App\models\Category;
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

class ServicesController extends Controller
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

        $itemsQ = Service::orderBy('name');
        if (Input::has('name') && !empty(Input::get('name'))) {
//			$itemsQ = $itemsQ->where( 'lower(name)', 'like', strtolower(Input::get( 'name' ) . '%') );
            $itemsQ = $itemsQ->whereRaw('LOWER(name) LIKE ? ', [trim(strtolower(Input::get('name'))) . '%']);
            $itemsQ = $itemsQ->orWhere('abbreviation', 'like', strtoupper(Input::get('name') . '%'));
        }
        $items = $itemsQ->paginate(20);

        return View::make('services.index', compact('items'));
    }

    public function getCreate()
    {
        if (Gate::denies('check-ability', 'Service|Create')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();
        $cats = Category::orderBy( 'name' )->get();

        return View::make('services.create',compact('cats'));
    }

    public function postStore(Request $request)
    {
        if (Gate::denies('check-ability', 'Service|Create')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();

        $this->validate($request,
            [
                'name' => 'required|unique:service',
                'category_id' => 'required|exists:category,id',
                'desc' => 'required',
            ]);

        DB::beginTransaction();
        try {
            $inputs = $request->all();
            $item = Service::create($inputs);

        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }

        DB::commit();
        Session::flash('message', 'Service added!');

        return redirect('services');
    }

    public function getShow($id)
    {
        if (Gate::denies('check-ability', 'Service|Show')) {
            abort(403, 'Unauthorized action.');
        }

        $category = Category::findOrFail($id);
        $sessionUser = Auth::user();
        $cat_services = Service::where('category_id', $id)->get();

        print($cat_services);


        return view('services.index', compact('sessionUser', 'category', 'cat_services'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('check-ability', 'Service|Update')) {
            abort(403, 'Unauthorized action.');
        }


        $sessionUser = Auth::user();
        $cats = Category::orderBy( 'name' )->get();
        $model = Service::findOrFail($id);
        return view('services.edit', compact('sessionUser', 'model','cats'));
    }

    public function postUpdate(Request $request, $id)
    {
        if (Gate::denies('check-ability', 'Service|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();

        $model = Service::findOrFail($id);
        $oldData = $model->toJson();

        $this->validate($request,
            [
                'name' => 'required|unique:service,name,' . $model->id,
            ]);

        try {
            $inputs = $request->all();
            #$inputs['id'] = strtoupper($inputs['id']);
            $model->update($inputs);
            $newData = $model->toJson();


        } catch (Exception $ex) {
            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');

            return Redirect::back()->withInput();
        }

        Session::flash('message', 'Item Updated!');

        return redirect(action('ServicesController@getEdit', $model->id));
    }

    public function getDestroy($id)
    {
        if (Gate::denies('check-ability', 'Service|Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();

        try {
            # delete leagues
            $item = Service::where('id', $id)->first();
            $item->delete();
            //// Logging
            $logMsg = $sessionUser->name . " " . $sessionUser->lname . " Deleted Service $item->id";
            $routeParts = explode('@', Route::getCurrentRoute()->getActionName());


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

        return Redirect::to(action('ServiceController@getIndex'));
    }
}

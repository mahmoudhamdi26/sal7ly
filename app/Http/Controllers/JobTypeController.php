<?php

namespace App\Http\Controllers;

use App\models\Category;
use App\models\JobType;
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
use Illuminate\Support\Facades\View;

class JobTypeController extends Controller
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

        $itemsQ = JobType::orderBy('name');
        if (Input::has('name') && !empty(Input::get('name'))) {
//			$itemsQ = $itemsQ->where( 'lower(name)', 'like', strtolower(Input::get( 'name' ) . '%') );
            $itemsQ = $itemsQ->whereRaw('LOWER(name) LIKE ? ', [trim(strtolower(Input::get('name'))) . '%']);
            $itemsQ = $itemsQ->orWhere('abbreviation', 'like', strtoupper(Input::get('name') . '%'));
        }
        $items = $itemsQ->paginate(20);

        return View::make('jobs.index', compact('items'));
    }

    public function getCreate()
    {
        if (Gate::denies('check-ability', 'Service|Create')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();
        $services = Service::orderBy('name')->get();

        return View::make('jobs.create', compact('services'));
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
                'service_id' => 'required|exists:service,id',
                'price_from' => 'required|numeric|min:0',
                'price_to' => 'required|numeric|min:'.$request->input('price_from'),
            ]);

        DB::beginTransaction();
        try {
            $inputs = $request->all();
            $item = JobType::create($inputs);

        } catch (Exception $ex) {
            DB::rollback();
            Session::flash('message', 'Error, Please try again!');
            Session::flash('alert-class', 'danger');
            return Redirect::back()->withInput();
        }

        DB::commit();
        Session::flash('message', 'JobType added!');
        $log_data=['action'=>'create','item_id'=>$item->id,'item_type'=>'job_type',
            'user_id'=>$request->user()->id,'item_data'=>$item->toJson()];
        Logs::create($log_data);
        return redirect(action('JobTypeController@getIndex'));
    }


    public function getEdit($id)
    {
        if (Gate::denies('check-ability', 'Service|Update')) {
            abort(403, 'Unauthorized action.');
        }


        $sessionUser = Auth::user();
        $services = Service::orderBy('name')->get();
        $model = JobType::findOrFail($id);
        return view('jobs.edit', compact('sessionUser', 'model', 'services'));
    }

    public function postUpdate(Request $request, $id)
    {
        if (Gate::denies('check-ability', 'Service|Update')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();

        $model = JobType::findOrFail($id);
        $oldData = $model->toJson();

        $this->validate($request,
            [
                'name' => 'required|unique:service,name,' . $model->id,
                'service_id' => 'required|exists:service,id',
                'price_from' => 'required|numeric|min:0',
                'price_to' => 'required|numeric|min:'.$request->input('price_from'),
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
        $log_data=['action'=>'update','item_id'=>$model->id,'item_type'=>'job_type',
            'user_id'=>$request->user()->id,'item_data'=>$model->toJson()];
        Logs::create($log_data);
        return redirect(action('JobTypeController@getEdit', $model->id));
    }

    public function getDestroy($id)
    {
        if (Gate::denies('check-ability', 'Service|Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $sessionUser = Auth::user();

        try {
            $item = JobType::where('id', $id)->first();
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
        $log_data=['action'=>'delete','item_id'=>$item->id,'item_type'=>'job_type',
            'user_id'=>$sessionUser->id,'item_data'=>$item->toJson()];
        Logs::create($log_data);
        return Redirect::to(action('JobTypeController@getIndex'));
    }
}

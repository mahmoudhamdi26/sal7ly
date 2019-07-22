<?php

namespace App\Http\Controllers;

use App\models\Category;
use App\models\Country;
use App\models\JobRequest;
use App\models\Problem;
use App\models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class JobRequestController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $jobOrders = $request->user()->job_requests()->with('job_type', 'service')->
        orderby('created_at', 'DESC')->get();
        return response()->json(['requests' => $jobOrders, 'user' => $request->user()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cats(Request $request)
    {
        $cats = Category::orderBy('created_at','DESC')->get();
        return response()->json(['categories' => $cats]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function services(Request $request, $id)
    {
        $services = Service::where('category_id', $id)->orderBy('created_at','DESC')->with('job_types', 'device_types')->get();
        return response()->json(['services' => $services]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'desc' => 'nullable',
            'job_type_id' => 'nullable|exists:job_type,id',
            'service_id' => 'required|exists:service,id',
            'device_type_id' => 'nullable|exists:device_type,id',
            'needed_at' => 'required'
        ]);

        if (!isset($user->address) || !isset($user->mobile)) {
            return response()->json([
                'message' => 'you must fill your address and mobile first',
                'status' => 0,
            ])->setStatusCode(400);
        }
        $request->request->set('user_id', $user->id);
        $req = JobRequest::create($request->all());

        return response()->json([
            'status' => 1,
            'message' => 'Great success! New Job request created',
            'job_request' => $req,
        ]);
    }

    public function storeProblem(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'desc' => 'required|string',
        ]);

        $request->request->set('user_id', $user->id);
        $req = Problem::create($request->all());

        return response()->json([
            'status' => 1,
            'message' => 'Great success! New Job request created',
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bad_res = response()->json([
            'message' => 'you do not have job request with this id',
            'status' => 0,
        ])->setStatusCode(404);

        try {
            $model = JobRequest::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $bad_res;
        }
        if ($model->user_id != $request->user()->id) {
            return $bad_res;
        }

        $request->validate([
            'desc' => 'nullable',
            'job_type_id' => 'required|exists:job_type,id',
            'needed_at' => 'required|date|after_or_equal:' . min($model->needed_at, Carbon::now())
        ]);

        $model->update($request->all());
        return response()->json([
            'data' => $model,
            'status' => 1,
            'message' => 'Great success! Updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $bad_res = response()->json([
            'message' => 'you do not have job request with this id',
            'status' => 0,
        ])->setStatusCode(404);

        try {
            $model = JobRequest::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $bad_res;
        }
        if ($model->user_id != $request->user()->id) {
            return $bad_res;
        }

        $model->delete();
        return response()->json([
            'message' => 'deleted successfully',
            'status' => 1,
        ]);
    }
}

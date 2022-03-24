<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        //aqui definimos token e obrigamos a autenticação
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services =  Service::all();

        if($services){
            return response()->json($services);
        }else{
            return response()->json(['error' => 'Response not found.'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service();
        $service->name = $request->name;
		$service->description = $request->description;
		$service->cost = $request->cost;
		$service->company_id = $request->company_id;
		$service->save();

        if($service){
            return response()->json($service);
        }else{
            return response()->json(['error' => 'Response not save.'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);

        if($service){
            return response()->json($service);
        }else{
            return response()->json(['error' => 'Response not found.'], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::find($id);

        if($service){
            return response()->json($service);
        }else{
            return response()->json(['error' => 'Response not found.'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        $service->name = $request->name;
		$service->description = $request->description;
		$service->cost = $request->cost;
		$service->company_id = $request->company_id;
		$service->save();


        if($service){
            return response()->json($service);
        }else{
            return response()->json(['error' => 'Response not updated.'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);

        if($service){
            $service->delete();
            return response()->json($service);
        }else{
            return response()->json(['error' => 'Response not deleted.'], 401);
        }
    }
}

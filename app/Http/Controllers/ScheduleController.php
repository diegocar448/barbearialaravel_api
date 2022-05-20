<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
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
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $schedules = Schedule::with('employee', 'service')->where('user_id', $user->id)->orderBy('scheduling_date')->get();
        //return "TESTE";
        if($schedules){
            return response()->json($schedules);
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
        //return $request->all();

        //$employee = !isset($request->employee_id) ? $request->employee_id : "1";


        $schedule = new Schedule();
        $schedule->scheduling_date = $request->scheduling_date;
		// $schedule->scheduling_hour = $request->scheduling_hour;
		$schedule->hour_start = $request->hour_start;
		$schedule->hour_end = $request->hour_end;
		$schedule->user_id = (Integer)$request->user_id;
		$schedule->employee_id = $request->employee_id;//(Integer)$request->employee_id;
		$schedule->service_id = (Integer)$request->service_id;
		$schedule->save();

        if($schedule){
            return response()->json($schedule);
        }else{
            return response()->json(['error' => 'Response not save.']);
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
        $schedule = Schedule::find($id);

        if($schedule){
            return response()->json($schedule);
        }else{
            return response()->json(['error' => 'Response not found.']);
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
        $schedule = Schedule::find($id);

        if($schedule){
            return response()->json($schedule);
        }else{
            return response()->json(['error' => 'Response not found.']);
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
        $schedule = Schedule::find($id);
        $schedule->schedule_date = $request->schedule_date;
		$schedule->scheduling_hour = $request->scheduling_hour;
		$schedule->hour_start = $request->hour_start;
		$schedule->hour_end = $request->hour_end;
		$schedule->user_id = $request->user_id;
		$schedule->employee_id = $request->employee_id;
		$schedule->service_id = $request->service_id;
		$schedule->save();

        if($schedule){
            return response()->json($schedule);
        }else{
            return response()->json(['error' => 'Response not updated.']);
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
        $schedule = Schedule::find($id);

        if($schedule){
            $schedule->delete();
            return response()->json($schedule);
        }else{
            return response()->json(['error' => 'Response not deleted.']);
        }
    }
}

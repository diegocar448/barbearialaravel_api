<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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


        $employees =  Employee::all();
        //$employees =  Employee::with("company", "user", "services.scheduled", "schedules")->get();

        if($employees){
            return response()->json($employees);
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
        $employee = new Employee();
        $employee->first_name = $request->first_name;
		$employee->last_name = $request->last_name;
		$employee->image = $request->image;
		$employee->company_id = $request->company_id;
		$employee->user_id = $request->user_id;
		$employee->save();

        if($employee){
            return response()->json($employee);
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
        $employee = Employee::find($id);

        if($employee){
            return response()->json($employee);
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
        $employee = Employee::find($id);

        if($employee){
            return response()->json($employee);
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
        $employee = Employee::find($id);
        $employee->first_name = $request->first_name;
		$employee->last_name = $request->last_name;
		$employee->image = $request->image;
		$employee->company_id = $request->company_id;
		$employee->user_id = $request->user_id;
		$employee->save();

        if($employee){
            return response()->json($employee);
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
        $employee = Employee::find($id);

        if($employee){
            $employee->delete();
            return response()->json($employee);
        }else{
            return response()->json(['error' => 'Response not deleted.'], 401);
        }
    }

    public function schedules($employee){
        $schedules = Schedule::with('user', 'service', 'employee')->orWhere('employee_id', $employee)->orWhere('employee_id', null)->get();

        if($schedules->count() > 0){
            return response()->json($schedules);
        }else{
            return response()->json(['error' => 'Employee not found.'], 401);
        }
    }
}

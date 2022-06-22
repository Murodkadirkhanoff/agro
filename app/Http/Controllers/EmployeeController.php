<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data'=> Employee::all()], 200);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'passport' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'position' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'company_id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
     
        $result = $this->checkRole($request->company_id);
        if($result == false){
            return response()->json(['error' => 'no access'], 201);
        }
        $employee = Employee::create($validator->validated());

        return response()->json(['data' => $employee], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json(['data' => $employee], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(),[
            'passport' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'position' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'company_id' => 'required|numeric'
        ]);

        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $result = $this->checkRole($request->company_id);
        if($result == false){
            return response()->json(['error' => 'no access'], 201);
        }

        $employee->update($validator->validated());

        return response()->json(['data' => $employee], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
       $result = $this->checkRole($employee->id);
        if($result == false){
            return response()->json(['error' => 'no access'], 201);
        }
        $employee->delete();
        return response()->json(['data' => 'record deleted successfully'], 200);
    }
}

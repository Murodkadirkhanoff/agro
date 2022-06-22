<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data'=> Company::all()], 200);
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
            'company_name' => 'required',
            'director' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'phone_number' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
       
        $company = Company::create($validator->validated());

        return response()->json(['data' => $company], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return response()->json(['data' => $company], 200);
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(),[
            'company_name' => 'required',
            'director' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'phone_number' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $result = $this->checkRole($company->id); 
        if($result == false){
            return response()->json(['error' => 'no access'], 201);
        }
        $company->update($validator->validated());

        return response()->json(['data' => $company], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $result =$this->checkRole($company->id);
        if($result == false){
            return response()->json(['error' => 'no access'], 201);
        } 
        
        $company->delete();
        return response()->json(['data' => 'record deleted successfully'], 200);
    }
}

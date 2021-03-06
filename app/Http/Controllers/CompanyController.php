<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(5);
        return view('company.index', compact('companies'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        Company::create($request->validated() + ['logo' => $request->file('logo_company')->store('company') ]);

        return redirect()->route('company.index')->with('success', 'Company has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $request->validated();
        
        if ( $request->file('logo_company') ) {
            Storage::delete($company->logo);
            
            $company->update($request->validated()+ ['logo' => $request->file('logo_company')->store('company') ]);
        } else {
            $company->update($request->validated());
        }
        return redirect()->route('company.index')->with('success', 'Company has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        Storage::delete($company->logo);
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Company has been deleted!');
    }

    /**
    * Show the application dataAjax.
    *
    * @return \Illuminate\Http\Response
    */
    public function dataAjax(Request $request)
    {
        if ($request->ajax())
        {            
            $companies = Company::filter(request(['term']))->get();

            $results = array(
                "results" => $companies,
                "count_filtered" => count($companies)
            );

            return response()->json($results);
        }
    }
}

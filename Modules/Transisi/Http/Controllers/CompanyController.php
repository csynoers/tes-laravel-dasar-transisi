<?php

namespace Modules\Transisi\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Transisi\Entities\Company;
use Modules\Transisi\Http\Requests\StoreCompanyRequest;
use Modules\Transisi\Http\Requests\UpdateCompanyRequest;
use Modules\Transisi\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    protected $companyRepository;
    
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->is('api/*')) {
            $status = 200;
            $response['success'] = true;
            $response['message'] = 'Companies retrieved successfully.';
            
            try {
                $response['data'] = $this->companyRepository->fetch();
            } catch (Exception $e) {
                $status = 404;
                $response['success'] = false;
                $response['data'] = $e->getMessage();
                $response['message'] = 'Companies not found.';
            }
    
            return response()->json($response, $status);
        }

        $companies = $this->companyRepository->fetch();
        return view('transisi::company.index', compact('companies'));        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('transisi::company.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreCompanyRequest $request)
    {
        $validate = $request->validated() + ['logo' => $request->file('logo_company')->store('company') ];
        if ($request->is('api/*')) {
            $status = 201;
            $response['success'] = true;
            $response['message'] = 'Company created successfully.';
    
            try {
                $this->companyRepository->save($validate);
            } catch (Exception $e) {
    
                $status = 500;
                $response['success'] = false;
                $response['data'] = $validate;
                $response['message'] = $e->getMessage();
    
            }
    
            return response()->json($response, $status);
        }

        $this->companyRepository->save($validate);

        return redirect()->to('/company')->with('success', 'Company has been created!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, $id)
    {
        if ($request->is('api/*')) {            
            $status = 200;
            $response['success'] = true;
            $response['data'] = $this->companyRepository->find($id);
            $response['message'] = 'Company retrieved successfully.';
            
            if (empty($response['data'])) {
                $status = 404;
                $response['success'] = false;
                $response['message'] = 'Company not found.';
            }
    
            return response()->json($response, $status);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Company $company)
    {
        return view('transisi::company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $validate = $request->validated();

        if ( $request->file('logo_company') ) {
            Storage::delete($company->logo);
            $validate += ['logo' => $request->file('logo_company')->store('company') ];
        }

        if ($request->is('api/*')) {
            $status = 200;
            $response['success'] = true;
            $response['message'] = 'Company updated successfully.';            
    
            try {
                $this->companyRepository->update($validate, $company->id);
            } catch (Exception $e) {
    
                $status = 500;
                $response['success'] = false;
                $response['data'] = $validate;
                $response['message'] = $e->getMessage();
    
            }
    
            return response()->json($response, $status);
        }

        $this->companyRepository->update($validate, $company->id);
        return redirect()->to('/company')->with('success', 'Company has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Company $company, Request $request)
    {
        Storage::delete($company->logo);
        $this->companyRepository->delete($company->id);

        if ($request->is('api/*')) {
            $status = 200;
            $response['success'] = true;
            $response['message'] = 'Company deleted successfully.';

    
            return response()->json($response, $status);
        }

        return redirect()->to('/company')->with('success', 'Company has been deleted!');

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
            $companies = $this->companyRepository->dataAjax(request(['term']));

            $results = array(
                "results" => $companies,
                "count_filtered" => count($companies)
            );

            return response()->json($results);
        }
    }
}

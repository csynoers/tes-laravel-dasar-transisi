<?php

namespace Modules\Transisi\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Transisi\Services\CompanyService;

class CompanyController extends Controller
{
    protected $companyService;
    
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): JsonResponse
    {
        $status = 200;
        $response['success'] = true;
        $response['message'] = 'Companies retrieved successfully.';
        
        try {
            $response['data'] = $this->companyService->fetch();
        } catch (Exception $e) {
            $status = 404;
            $response['success'] = false;
            $response['data'] = $e->getMessage();
            $response['message'] = 'Companies not found.';
        }

        return response()->json($response, $status);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only([
            'name',
            'email',
            'website',
            'logo_company',
        ]);
        $data['logo_company'] = $request->file('logo_company') ?? null;

        $status = 201;
        $response['success'] = true;
        $response['data'] = $data;
        $response['message'] = 'Company created successfully.';

        try {
            $response['data'] = $this->companyService->save($data);
        } catch (Exception $e) {

            $status = 500;
            $response['success'] = false;
            $response['data'] = $data;
            $response['message'] = $e->getMessage();

        }

        return response()->json($response, $status);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id): JsonResponse
    {
        $status = 200;
        $response['success'] = true;
        $response['data'] = $this->companyService->find($id);
        $response['message'] = 'Company retrieved successfully.';
        
        if (empty($response['data'])) {
            $status = 404;
            $response['success'] = false;
            $response['message'] = 'Company not found.';
        }

        return response()->json($response, $status);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id): JsonResponse 
    {
        $data = $request->only([
            'name',
            'email',
            'website',
            'logo_company',
        ]);
        $data['logo_company'] = $request->file('logo_company') ?? null;

        $status = 200;
        $response['success'] = true;
        $response['data'] = $data;
        $response['message'] = 'Company updated successfully.';

        try {
            $response['data'] = $this->companyService->update($data, $id);
        } catch (Exception $e) {

            $status = 500;
            $response['success'] = false;
            $response['data'] = $data;
            $response['message'] = $e->getMessage();

        }

        return response()->json($response, $status);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id): JsonResponse
    {
        $status = 200;
        $response['success'] = true;
        $response['message'] = 'Company deleted successfully.';
        $this->companyService->delete($id);

        return response()->json($response, $status);
    }
}

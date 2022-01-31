<?php

namespace Modules\Transisi\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Transisi\Services\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeeService;
    
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request): JsonResponse
    {
        $status = 200;
        $response['success'] = true;
        $response['message'] = 'Employees retrieved successfully.';
        
        try {
            $response['data'] = $this->employeeService->fetch();
        } catch (Exception $e) {
            $status = 404;
            $response['success'] = false;
            $response['data'] = $e->getMessage();
            $response['message'] = 'Employees not found.';
        }

        return response()->json($response, $status);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'company',
            'email',
            'status',
        ]);

        $status = 201;
        $response['success'] = true;
        $response['data'] = $data;
        $response['message'] = 'Employee created successfully.';

        try {
            $response['data'] = $this->employeeService->save($data);
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
        $response['data'] = $this->employeeService->find($id);
        $response['message'] = 'Employee retrieved successfully.';
        
        if (empty($response['data'])) {
            $status = 404;
            $response['success'] = false;
            $response['message'] = 'Employee not found.';
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
            'company',
            'email',
            'status',
        ]);

        $status = 200;
        $response['success'] = true;
        $response['data'] = $data;
        $response['message'] = 'Employee updated successfully.';

        try {
            $response['data'] = $this->employeeService->update($data, $id);
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
        $response['message'] = 'Employee deleted successfully.';
        $this->employeeService->delete($id);

        return response()->json($response, $status);
    }
}

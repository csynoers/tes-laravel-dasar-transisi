<?php

namespace Modules\Transisi\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Transisi\Constants\Status;
use Modules\Transisi\Entities\Employee;
use Modules\Transisi\Http\Requests\ImportEmployeeRequest;
use Modules\Transisi\Http\Requests\StoreEmployeeRequest;
use Modules\Transisi\Http\Requests\UpdateEmployeeRequest;
use Modules\Transisi\Imports\EmployeesImport;
use Modules\Transisi\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    protected $employeeRepository;
    
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
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
            $response['message'] = 'Employees retrieved successfully.';
            
            try {
                $response['data'] = $this->employeeRepository->fetch($request->toArray());
            } catch (Exception $e) {
                $status = 404;
                $response['success'] = false;
                $response['data'] = $e->getMessage();
                $response['message'] = 'Employees not found.';
            }
    
            return response()->json($response, $status);
        }

        $status = Status::labels();
        $employees = $this->employeeRepository->fetch($request->toArray());
        return view('transisi::employee.index', compact('employees','status'));   
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $status = Status::labels();

        return view('transisi::employee.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validate = $request->validated();
        if ($request->is('api/*')) {
            $status = 201;
            $response['success'] = true;
            $response['message'] = 'Employee created successfully.';
    
            try {
                $this->employeeRepository->save($validate);
            } catch (Exception $e) {
    
                $status = 500;
                $response['success'] = false;
                $response['data'] = $validate;
                $response['message'] = $e->getMessage();
    
            }
            
            return response()->json($response, $status);
        }

        $this->employeeRepository->save($validate);

        return redirect()->to('/employee')->with('success', 'Employee has been created!');
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
            $response['data'] = $this->employeeRepository->find($id);
            $response['message'] = 'Employee retrieved successfully.';
            
            if (empty($response['data'])) {
                $status = 404;
                $response['success'] = false;
                $response['message'] = 'Employee not found.';
            }
    
            return response()->json($response, $status);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee  $employee)
    {
        $status = Status::labels();

        return view('transisi::employee.edit', compact(['employee','status']));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee) 
    {
        $validate = $request->validated();
        if ($request->is('api/*')) {
            $status = 200;
            $response['success'] = true;
            $response['message'] = 'Employee updated successfully.';
    
            try {
                $this->employeeRepository->update($validate, $employee->id);
            } catch (Exception $e) {
    
                $status = 500;
                $response['success'] = false;
                $response['data'] = $validate;
                $response['message'] = $e->getMessage();
    
            }
            
            return response()->json($response, $status);
        }
        
        $this->employeeRepository->update($validate, $employee->id);

        return redirect()->to('/employee')->with('success', 'Employee has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Employee $employee, Request $request)
    {
        $this->employeeRepository->delete($employee->id);

        if ($request->is('api/*')) {
            $status = 200;
            $response['success'] = true;
            $response['message'] = 'Employee deleted successfully.';
    
            return response()->json($response, $status);            
        }

        return redirect()->route('employee.index')->with('success', 'Employee has been deleted!');
    }

    /**
     * Export PDF.
     *
     * @param  \App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Request $request)
    {
        $status = Status::labels();
        $employees = $this->employeeRepository->exportPdf($request->toArray());
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('transisi::employee.pdf', compact(['employees','status']));

        return $pdf->stream();
    }

    public function importExcel(ImportEmployeeRequest $request){

        $request->validated();
        Excel::import(new EmployeesImport, request()->file('file'));
             
        return redirect()->to('/employee')->with('success', 'Employee has been imported!');
    }
}

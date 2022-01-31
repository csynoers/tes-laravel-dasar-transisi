<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Imports\EmployeesImport;
use App\Models\Employee;
use Modules\Transisi\Constants\Status;
use PDF;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::labels();
        $employees = Employee::latest()->paginate(5);
        return view('employee.index', compact(['employees','status']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Status::labels();

        return view('employee.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect()->to('/employee')->with('success', 'Employee has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        return view('employee.edit', compact(['employee','status']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee  $employee)
    {
        $employee->update($request->validated());

        return redirect()->to('/employee')->with('success', 'Employee has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee  $employee)
    {
        $employee->delete();

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
        $employees = Employee::latest()->filter(request(['company']))->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('employee.pdf', compact(['employees','status']));

        return $pdf->stream();
    }

    public function importExcel(ImportEmployeeRequest $request){
        $request->validated();
        Excel::import(new EmployeesImport, request()->file('file'));
             
        // return redirect()->to('/employee')->with('success', 'Employee has been imported!');
    }
}

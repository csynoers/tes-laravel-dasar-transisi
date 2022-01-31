<?php
namespace Modules\Transisi\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Modules\Transisi\Constants\Status;
use Modules\Transisi\Repositories\EmployeeRepository;

class EmployeeService
{
    protected $employeeRepository;
    protected $status;

    public function __construct(EmployeeRepository $employeeRepository, Status $status)
    {
        $this->employeeRepository = $employeeRepository;
        $this->status = $status;
    }

    public function find($id)
    {
        return $this->employeeRepository->find($id);
    }


    public function fetch()
    {
        return $this->employeeRepository->fetch();
    }

    public function save($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'company' => 'required',
            'email' => 'email|required|unique:employees',
            'status' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->employeeRepository->save($data);
        
        return $result;
    }
    
    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'company' => 'required',
            'email' => 'email|required',
            'status' => 'required',
        ]);        

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->employeeRepository->update($data, $id);
        
        return $result;

    }

    public function delete($id)
    {
        $result = $this->employeeRepository->delete($id);

        return $result;
    }
}

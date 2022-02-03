<?php
namespace Modules\Transisi\Repositories;

use Modules\Transisi\Entities\Employee;

class EmployeeRepository
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function fetch(array $params)
    {
        $query = $this->model->query();

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query->paginate();
    }

    public function save($data)
    {
        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        $employee = $this->model->find($id);
        $employee->name = $data['name'];
        $employee->company = $data['company'];
        $employee->email = $data['email'];
        $employee->status = $data['status'];
        
        return $employee->save();
    }

    public function delete($id)
    {
        $employee = $this->model->find($id);
        
        return $employee->delete();
    }

    public function exportPdf(array $params)
    {
        return $this->model->latest()->filter($params)->get();
    }

    // method lainya ...
}

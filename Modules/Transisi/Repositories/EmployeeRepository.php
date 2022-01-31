<?php
namespace Modules\Transisi\Repositories;

use Modules\Transisi\Repositories\Entities\Employee;

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

    public function fetch()
    {
        $query = $this->model->query();
        
        return $query->paginate();
    }

    public function save($data)
    {
        $id = $this->model->save($data);
        
        return $this->model->find($id);
    }

    public function update($data, $id)
    {
        $this->model->update($data, $id);
        
        return $this->model->find($id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    // method lainya ...
}

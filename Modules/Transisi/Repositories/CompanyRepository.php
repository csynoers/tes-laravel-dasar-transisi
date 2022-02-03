<?php
namespace Modules\Transisi\Repositories;

use Modules\Transisi\Entities\Company;

class CompanyRepository
{
    protected $model;

    public function __construct(Company $model)
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
        return $this->model->create($data);
    }

    public function update($data, $id)
    {   
        $company = $this->model->find($id);
        $company->name = $data['name'];
        $company->email = $data['email'];
        $company->website = $data['website'];

        if ( ! empty($data['logo']) ) {
            $company->logo = $data['logo'];
        }

        return $company->save();
    }

    public function delete($id)
    {
        $company = $this->model->find($id);
        return $company->delete();
    }

    public function dataAjax($terms)
    {
        return $this->model->filter($terms)->get();
    }

    // method lainya ...
}

<?php
namespace Modules\Transisi\Repositories;

use App\Models\Company;

class CompanyRepository
{
    protected $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return Company::find($id);
    }

    public function fetch(array $params)
    {
        $query = Company::select();

        if (isset($params['status'])) {
            // $query->where('status', $params['status']);
        }
        return $query->paginate();
    }

    // method lainya ...
}

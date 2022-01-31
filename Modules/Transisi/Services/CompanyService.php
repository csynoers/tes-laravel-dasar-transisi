<?php
namespace Modules\Transisi\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Modules\Transisi\Repositories\CompanyRepository;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRespository)
    {
        $this->companyRepository = $companyRespository;
    }

    public function find($id)
    {
        return $this->companyRepository->find($id);
    }


    public function fetch()
    {
        return $this->companyRepository->fetch();
    }

    public function save($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'email|required|unique:companies',
            'website' => 'required|url|unique:companies',
            'logo_company' => 'required|image|file|mimes:png|dimensions:min_width=100,min_height=100|max:2048'
        ]);
        
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        
        $data['logo'] = $data['logo_company']->store('company');
        unset($data['logo_company']);
        $result = $this->companyRepository->save($data);
        
        return $result;
    }
    
    public function update($data, $id)
    {
        $company = $this->companyRepository->find($id);

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => [
                'email',
                'required',
            ],
            'website' => [
                'required',
                'url',
            ],
            'logo_company' => 'image|file|mimes:png|dimensions:min_width=100,min_height=100|max:2048'
        ]);        

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if ($data['logo_company']) {
            Storage::delete($company->logo);
            $data['logo'] = $data['logo_company']->store('company');
        }

        unset($data['logo_company']);
        $result = $this->companyRepository->update($data, $id);
        
        return $result;

    }

    public function delete($id)
    {
        $company = $this->companyRepository->find($id);
        // unlink logo
        Storage::delete($company->logo);

        $result = $this->companyRepository->delete($id);

        return $result;
    }
}

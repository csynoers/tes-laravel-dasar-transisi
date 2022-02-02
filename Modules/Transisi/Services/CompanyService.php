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

    public function save($request)
    {   
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $request->file('logo_company')->store('company'),
        ]; 

        $result = $this->companyRepository->save($data);
        
        return $result;
    }
    
    public function update($request, $id)
    {
        $company = $this->companyRepository->find($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
        ]; 

        if ($request->file('logo_company')) {
            Storage::delete($company->logo);
            $data['logo'] = $request->file('logo_company')->store('company');
        }
        
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

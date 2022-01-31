<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EmployeesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.name' => 'required',
             '*.email' => 'email|required|unique:employees',
             '*.status' => 'required',
         ])->validate();
        
        foreach ($rows as $key => $row) {
            $rows[$key] = [
                'name' => $row['name'],
                'company' => request('company'),
                'email' => $row['email'],
                'status' => $row['status'],
            ];
        }

        dd($rows);
    }
}

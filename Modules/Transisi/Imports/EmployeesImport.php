<?php
namespace Modules\Transisi\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
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

        DB::table('employees')->insert($rows->toArray());
    }

    public function batchSize(): int
    {
        return 10;
    }

    public function chunkSize(): int
    {
        return 10;
    }
}

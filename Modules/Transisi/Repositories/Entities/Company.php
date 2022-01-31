<?php
namespace Modules\Transisi\Repositories\Entities;

use Illuminate\Support\Facades\DB;

class Company
{
    protected $table = 'companies';

    public function find($id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->first();
    }
    
    public function query()
    {
        return DB::table($this->table);
    }

    public function save($data)
    {
        DB::table($this->table)->insert($data);
        return DB::getPdo()->lastInsertId();
    }

    public function update($data, $id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return DB::table($this->table)
            ->where('id', $id)
            ->delete();
    }
}

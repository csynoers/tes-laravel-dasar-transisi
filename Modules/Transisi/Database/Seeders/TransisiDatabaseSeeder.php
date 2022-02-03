<?php

namespace Modules\Transisi\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Transisi\Entities\Company;

class TransisiDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("CompanyTableSeeder");
        Company::factory()->count(100)->create();
        echo " Insert: companies \n\n";
    }
}

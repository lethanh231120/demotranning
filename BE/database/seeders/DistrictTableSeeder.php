<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/jsons/db.json");
        $data = json_decode($json);
        foreach ($data -> district as $district) {
            District::create(array(
                'id' => $district->idDistrict,
                'name' => $district->name,
                'province_id' => $district->idProvince,
            ));
        }
    }
}

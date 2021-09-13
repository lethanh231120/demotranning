<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Province;
class ProvinceTableSeeder extends Seeder
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
        foreach ($data -> province as $province) {
            Province::create(array(
                'id' => $province->idProvince,
                'name' => $province->name,
            ));
        }
    }
}

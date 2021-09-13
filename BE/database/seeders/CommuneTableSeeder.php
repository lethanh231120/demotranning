<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CommuneTableSeeder extends Seeder
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
        foreach ($data -> commune as $commune) {
            Commune::create(array(
                'id' => $commune->idCommune,
                'name' => $commune->name,
                'district_id' => $commune->idDistrict,
            ));
        }
    }
}

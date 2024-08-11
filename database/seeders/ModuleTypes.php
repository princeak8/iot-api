<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ModuleType;

class ModuleTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ["Transmission Station", "Power Station", "Oil Rig", "Bottiling Company", "Water Pump"];

        foreach($types as $type) {
            $moduleType = new ModuleType;
            $moduleType->name = $type;
            $moduleType->save();
        }
    }
}

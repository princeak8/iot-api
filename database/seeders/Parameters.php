<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Parameter;

class Parameters extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ["power"=>"MW", "Reactive Power"=>"MVar", "Voltage"=>"kV", "Current"=>"A", "Degrees"=>"Deg"];
        foreach($names as $name=>$unit) {
            $parameter = new Parameter;
            $parameter->name = $name;
            $parameter->unit = $unit;
            $parameter->save();
        }
    }
}

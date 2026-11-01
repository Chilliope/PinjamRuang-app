<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Seeder;

class BuildingStaffSeeder extends Seeder
{
    public function run(): void
    {
        $building = Building::findOrFail(8);
        $staff = User::findOrFail(2);

        $building->staff()->syncWithoutDetaching([
            $staff->id,
        ]);
    }
}

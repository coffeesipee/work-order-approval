<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::insertOrIgnore([
            'id' => 1,
            'name' => 'Region 6',
            'description' => 'Region 6 - Jawa timur',
            'budgets' => 1000000,
        ]);

        Unit::insertOrIgnore([
            'id' => 1,
            'name' => 'SPBU 1',
            'code' => 'SPBU-001',
            'description' => 'SPBU 1 - Jawa timur',
            'budgets' => 500000,
            'region_id' => 1,
        ]);
    }
}

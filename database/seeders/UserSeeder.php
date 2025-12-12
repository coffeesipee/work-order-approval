<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => 1,
            'name' => 'Superadmin',
            'type' => Role::TYPE_SUPERADMIN
        ]);

        User::create([
            'id' => 1,
            'email' => 'superadmin@app.com',
            'name' => 'Superadmin',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);
    }
}

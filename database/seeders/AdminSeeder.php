<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function up(): void
    {
        // Handled in run method
    }

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@company.com'],
            [
                'name' => 'Company Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department' => 'Operations',
                'position' => 'Chief Administrator',
            ]
        );
    }
}

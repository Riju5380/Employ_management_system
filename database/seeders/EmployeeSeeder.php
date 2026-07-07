<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'John Doe',
                'email' => 'john@company.com',
                'role' => 'employee',
                'department' => 'Engineering',
                'position' => 'Senior Developer',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@company.com',
                'role' => 'employee',
                'department' => 'Engineering',
                'position' => 'QA Engineer',
            ],
            [
                'name' => 'Robert Johnson',
                'email' => 'robert@company.com',
                'role' => 'employee',
                'department' => 'Design',
                'position' => 'UI/UX Designer',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@company.com',
                'role' => 'employee',
                'department' => 'Marketing',
                'position' => 'Marketing Specialist',
            ],
            [
                'name' => 'Michael Wilson',
                'email' => 'michael@company.com',
                'role' => 'employee',
                'department' => 'Support',
                'position' => 'Support Engineer',
            ],
        ];

        foreach ($employees as $emp) {
            User::updateOrCreate(
                ['email' => $emp['email']],
                array_merge($emp, [
                    'password' => Hash::make('password'),
                ])
            );
        }
    }
}

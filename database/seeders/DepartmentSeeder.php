<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['name' => 'Administration'],
            ['name' => 'Accounting'],
            ['name' => 'Anthropology'],
            ['name' => 'Architecture'],
            ['name' => 'Astronomy'],
            ['name' => 'Biology'],
            ['name' => 'Business Administration'],
            ['name' => 'Chemistry'],
            ['name' => 'Civil Engineering'],
            ['name' => 'Communication Studies'],
            ['name' => 'Computer Science'],
            ['name' => 'Dance'],
            ['name' => 'Dentistry'],
            ['name' => 'Earth Sciences'],
            ['name' => 'Economics'],
            ['name' => 'Education'],
            ['name' => 'Electrical Engineering'],
            ['name' => 'English'],
            ['name' => 'Environmental Science'],
            ['name' => 'Finance'],
            ['name' => 'Fine Arts'],
            ['name' => 'Foreign Languages'],
            ['name' => 'Geography'],
            ['name' => 'History'],
            ['name' => 'Human Resources Management'],
            ['name' => 'International Studies'],
            ['name' => 'Law'],
            ['name' => 'Linguistics'],
            ['name' => 'Marketing'],
            ['name' => 'Mathematics'],
            ['name' => 'Mechanical Engineering'],
            ['name' => 'Medicine'],
            ['name' => 'Music'],
            ['name' => 'Nursing'],
            ['name' => 'Pharmacy'],
            ['name' => 'Philosophy'],
            ['name' => 'Physics'],
            ['name' => 'Political Science'],
            ['name' => 'Psychology'],
            ['name' => 'Public Health'],
            ['name' => 'Social Work'],
            ['name' => 'Sociology'],
            ['name' => 'Theater and Drama'],
            ['name' => 'Urban Planning'],
            ['name' => 'Veterinary Medicine']
        ];
        Department::insert($departments);
    }
}

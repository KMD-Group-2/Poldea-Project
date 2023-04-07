<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['name' => 'Department Chair'],
            ['name' => 'Professor'],
            ['name' => 'Academic Advisor'],
            ['name' => 'Lecturer in Economics'],
            ['name' => 'Admissions Officer'],
            ['name' => 'Student Services Coordinator'],
            ['name' => 'IT Support Technician'],
            ['name' => 'Campus Security Officer'],
            ['name' => 'Teacher'],
            ['name' => 'Internship'],
            ['name' => 'Apprenticeship'],
        ];
        Position::insert($positions);
    }
}
